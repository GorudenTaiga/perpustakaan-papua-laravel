<?php

namespace App\Observers;

use App\Models\Buku;
use App\Models\Notification;
use App\Models\Pinjaman;

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

        // Becoming an active loan → reduce stock
        if (!$wasActive && $isActive) {
            $this->reduceStock($pinjaman);
        }

        // Was an active loan, now returned/cancelled → restore stock
        if ($wasActive && !$isActive) {
            $this->restoreStock($pinjaman);
        }

        // Send notification on verification
        if ($oldStatus === 'menunggu_verif' && $newStatus === 'dipinjam') {
            $this->notifyLoanVerified($pinjaman);
        }

        // Send notification on return
        if ($newStatus === 'dikembalikan' && $oldStatus !== 'dikembalikan') {
            $this->notifyLoanReturned($pinjaman);
        }
    }

    public function deleting(Pinjaman $pinjaman): void
    {
        $activeStatuses = ['dipinjam', 'jatuh_tempo'];
        if (in_array($pinjaman->status, $activeStatuses)) {
            $this->restoreStock($pinjaman);
        }
    }

    private function reduceStock(Pinjaman $pinjaman): void
    {
        $buku = Buku::find($pinjaman->buku_id);
        if ($buku) {
            $buku->stock = max(0, $buku->stock - $pinjaman->quantity);
            $buku->saveQuietly();
        }
    }

    private function restoreStock(Pinjaman $pinjaman): void
    {
        $buku = Buku::find($pinjaman->buku_id);
        if ($buku) {
            $buku->stock += $pinjaman->quantity;
            $buku->saveQuietly();
        }
    }

    private function notifyLoanVerified(Pinjaman $pinjaman): void
    {
        $buku = Buku::find($pinjaman->buku_id);
        Notification::create([
            'member_id' => $pinjaman->member_id,
            'type' => 'peminjaman',
            'title' => 'Peminjaman Diverifikasi',
            'message' => "Peminjaman buku \"{$buku?->judul}\" telah diverifikasi. Batas kembali: {$pinjaman->due_date}.",
        ]);
    }

    private function notifyLoanReturned(Pinjaman $pinjaman): void
    {
        $buku = Buku::find($pinjaman->buku_id);
        Notification::create([
            'member_id' => $pinjaman->member_id,
            'type' => 'peminjaman',
            'title' => 'Buku Dikembalikan',
            'message' => "Buku \"{$buku?->judul}\" telah dikembalikan pada {$pinjaman->return_date}.",
        ]);
    }
}
