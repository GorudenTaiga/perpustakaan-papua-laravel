<?php

namespace App\Observers;

use App\Models\Buku;
use App\Models\Notification;
use App\Models\Pinjaman;
use App\Services\WebPushService;

class PinjamanObserver
{
    public function created(Pinjaman $pinjaman): void
    {
        if ($pinjaman->status === 'dipinjam') {
            $this->reduceStock($pinjaman);
        }
    }

    public function updating(Pinjaman $pinjaman): void
    {
        if (!$pinjaman->isDirty('status')) {
            return;
        }

        $oldStatus = $pinjaman->getOriginal('status');
        $newStatus = $pinjaman->status;

        $activeLoanStatuses = ['dipinjam', 'jatuh_tempo'];

        $wasActive = in_array($oldStatus, $activeLoanStatuses);
        $isActive = in_array($newStatus, $activeLoanStatuses);

        // Load buku once if needed for stock or notification operations
        $needsBuku = (!$wasActive && $isActive) || ($wasActive && !$isActive)
            || ($oldStatus === 'menunggu_verif' && $newStatus === 'dipinjam')
            || ($newStatus === 'dikembalikan' && $oldStatus !== 'dikembalikan');

        $buku = $needsBuku ? $pinjaman->buku ?? Buku::find($pinjaman->buku_id) : null;

        if (!$wasActive && $isActive) {
            $this->reduceStockDirect($buku, $pinjaman->quantity);
        }

        if ($wasActive && !$isActive) {
            $this->restoreStockDirect($buku, $pinjaman->quantity);
        }

        if ($oldStatus === 'menunggu_verif' && $newStatus === 'dipinjam') {
            $this->notifyLoanVerified($pinjaman, $buku);
        }

        if ($newStatus === 'dikembalikan' && $oldStatus !== 'dikembalikan') {
            $this->notifyLoanReturned($pinjaman, $buku);
        }
    }

    public function deleting(Pinjaman $pinjaman): void
    {
        $activeStatuses = ['dipinjam', 'jatuh_tempo'];
        if (in_array($pinjaman->status, $activeStatuses)) {
            $this->reduceStock($pinjaman);
        }
    }

    private function reduceStock(Pinjaman $pinjaman): void
    {
        $buku = $pinjaman->buku ?? Buku::find($pinjaman->buku_id);
        $this->reduceStockDirect($buku, $pinjaman->quantity);
    }

    private function reduceStockDirect(?Buku $buku, int $quantity): void
    {
        if ($buku) {
            $buku->stock = max(0, $buku->stock - $quantity);
            $buku->saveQuietly();
        }
    }

    private function restoreStock(Pinjaman $pinjaman): void
    {
        $buku = $pinjaman->buku ?? Buku::find($pinjaman->buku_id);
        $this->restoreStockDirect($buku, $pinjaman->quantity);
    }

    private function restoreStockDirect(?Buku $buku, int $quantity): void
    {
        if ($buku) {
            $buku->stock += $quantity;
            $buku->saveQuietly();
        }
    }

    private function notifyLoanVerified(Pinjaman $pinjaman, ?Buku $buku): void
    {
        $title = 'Peminjaman Diverifikasi';
        $msg   = "Peminjaman buku \"{$buku?->judul}\" telah diverifikasi. Batas kembali: {$pinjaman->due_date}.";

        Notification::create([
            'member_id' => $pinjaman->member_id,
            'type'      => 'peminjaman',
            'title'     => $title,
            'message'   => $msg,
        ]);

        $this->sendPush($pinjaman->member_id, $title, $msg);
    }

    private function notifyLoanReturned(Pinjaman $pinjaman, ?Buku $buku): void
    {
        $title = 'Buku Dikembalikan';
        $msg   = "Buku \"{$buku?->judul}\" telah dikembalikan pada {$pinjaman->return_date}.";

        Notification::create([
            'member_id' => $pinjaman->member_id,
            'type'      => 'peminjaman',
            'title'     => $title,
            'message'   => $msg,
        ]);

        $this->sendPush($pinjaman->member_id, $title, $msg);
    }

    private function sendPush(string $memberId, string $title, string $message): void
    {
        try {
            app(WebPushService::class)->sendToMember($memberId, $title, $message);
        } catch (\Throwable) {
            // Never let push failures break the main flow
        }
    }
}
