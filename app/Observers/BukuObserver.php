<?php

namespace App\Observers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Notification;

class BukuObserver
{
    public function created(Buku $buku): void
    {
        $members = Member::pluck('membership_number');

        $notifications = $members->map(fn ($memberId) => [
            'member_id' => $memberId,
            'type' => 'buku_baru',
            'title' => 'Buku Baru Tersedia!',
            'message' => "Buku baru \"{$buku->judul}\" oleh {$buku->author} telah tersedia di perpustakaan.",
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (!empty($notifications)) {
            Notification::insert($notifications);
        }
    }
}
