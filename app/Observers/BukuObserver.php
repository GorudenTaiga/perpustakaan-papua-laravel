<?php

namespace App\Observers;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Notification;
use App\Services\WebPushService;

class BukuObserver
{
    public function created(Buku $buku): void
    {
        $members = Member::pluck('membership_number');

        $title = 'Buku Baru Tersedia!';
        $msg   = "Buku baru \"{$buku->judul}\" oleh {$buku->author} telah tersedia di perpustakaan.";

        $notifications = $members->map(fn ($memberId) => [
            'member_id'  => $memberId,
            'type'       => 'buku_baru',
            'title'      => $title,
            'message'    => $msg,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (!empty($notifications)) {
            Notification::insert($notifications);
        }

        // Web push broadcast to all subscribed members
        try {
            app(WebPushService::class)->sendToAll($title, $msg);
        } catch (\Throwable) {
            // Never let push failures block book creation
        }
    }
}
