<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\Member;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::pluck('membership_number')->toArray();

        if (empty($members)) {
            return;
        }

        $notifications = [
            // Member 0
            ['member' => 0, 'type' => 'loan_approved',     'title' => 'Pinjaman Disetujui',       'message' => 'Pinjaman buku Anda telah disetujui. Silakan ambil buku di perpustakaan.', 'read' => '-1 days', 'created' => '-3 days'],
            ['member' => 0, 'type' => 'due_reminder',      'title' => 'Pengingat Jatuh Tempo',     'message' => 'Pinjaman Anda akan jatuh tempo dalam 3 hari. Segera kembalikan buku.', 'read' => null, 'created' => '-1 days'],
            ['member' => 0, 'type' => 'reservation_ready',  'title' => 'Reservasi Tersedia',        'message' => 'Buku yang Anda reservasi sekarang tersedia. Silakan pinjam dalam 3 hari.', 'read' => null, 'created' => '0 days'],

            // Member 1
            ['member' => 1, 'type' => 'loan_approved',     'title' => 'Pinjaman Disetujui',       'message' => 'Pinjaman buku Anda telah disetujui oleh admin perpustakaan.', 'read' => '-2 days', 'created' => '-5 days'],
            ['member' => 1, 'type' => 'return_confirmed',   'title' => 'Pengembalian Dikonfirmasi', 'message' => 'Buku telah berhasil dikembalikan. Terima kasih!', 'read' => '-1 days', 'created' => '-2 days'],

            // Member 2
            ['member' => 2, 'type' => 'membership_verified','title' => 'Keanggotaan Diverifikasi', 'message' => 'Selamat! Keanggotaan perpustakaan Anda telah diverifikasi.', 'read' => '-5 days', 'created' => '-10 days'],
            ['member' => 2, 'type' => 'overdue_notice',     'title' => 'Pinjaman Terlambat',        'message' => 'Anda memiliki pinjaman yang telah melewati tanggal jatuh tempo. Denda Rp1.000/hari berlaku.', 'read' => null, 'created' => '-1 days'],

            // Member 3
            ['member' => 3, 'type' => 'loan_pending',      'title' => 'Pinjaman Menunggu',         'message' => 'Permintaan pinjaman Anda sedang menunggu persetujuan admin.', 'read' => null, 'created' => '-1 days'],
            ['member' => 3, 'type' => 'reservation_ready',  'title' => 'Reservasi Tersedia',        'message' => 'Buku yang Anda reservasi sudah tersedia di perpustakaan.', 'read' => null, 'created' => '0 days'],

            // Member 4
            ['member' => 4, 'type' => 'loan_approved',     'title' => 'Pinjaman Disetujui',       'message' => 'Pinjaman buku telah disetujui. Segera ambil di perpustakaan.', 'read' => '-3 days', 'created' => '-5 days'],
            ['member' => 4, 'type' => 'due_reminder',      'title' => 'Pengingat Jatuh Tempo',     'message' => 'Buku yang Anda pinjam akan jatuh tempo dalam 2 hari.', 'read' => null, 'created' => '0 days'],

            // Member 5
            ['member' => 5, 'type' => 'extension_approved', 'title' => 'Perpanjangan Disetujui',   'message' => 'Permintaan perpanjangan pinjaman Anda telah disetujui.', 'read' => '-1 days', 'created' => '-3 days'],

            // Member 6
            ['member' => 6, 'type' => 'loan_approved',     'title' => 'Pinjaman Disetujui',       'message' => 'Pinjaman buku Anda telah diverifikasi dan disetujui.', 'read' => null, 'created' => '-2 days'],

            // Member 7
            ['member' => 7, 'type' => 'overdue_notice',     'title' => 'Pinjaman Terlambat',        'message' => 'Segera kembalikan buku yang telah melewati jatuh tempo untuk menghindari denda lebih besar.', 'read' => null, 'created' => '-3 days'],
        ];

        foreach ($notifications as $n) {
            $memberIdx = $n['member'] % count($members);

            Notification::create([
                'member_id' => $members[$memberIdx],
                'type'      => $n['type'],
                'title'     => $n['title'],
                'message'   => $n['message'],
                'read_at'   => $n['read'] ? now()->modify($n['read']) : null,
                'created_at'=> now()->modify($n['created']),
            ]);
        }
    }
}
