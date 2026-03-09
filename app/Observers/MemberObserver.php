<?php

namespace App\Observers;

use App\Models\Member;
use App\Models\Notification;
use App\Services\WebPushService;

class MemberObserver
{
    public function updating(Member $member): void
    {
        if ($member->isDirty('verif') && $member->verif === true) {
            $this->notifyMemberVerified($member);
        }
    }

    private function notifyMemberVerified(Member $member): void
    {
        $title = 'Akun Terverifikasi ✅';
        $msg   = 'Selamat! Akun kamu telah diverifikasi oleh admin. Kamu sekarang dapat meminjam buku.';

        Notification::create([
            'member_id' => $member->membership_number,
            'type'      => 'verifikasi_akun',
            'title'     => $title,
            'message'   => $msg,
        ]);

        try {
            app(WebPushService::class)->sendToMember($member->membership_number, $title, $msg);
        } catch (\Throwable) {
            // Never let push failures break the main flow
        }
    }
}
