<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookReservation;
use App\Models\Member;
use App\Models\Buku;

class BookReservationSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::where('verif', true)->pluck('membership_number')->toArray();
        $bukuIds = Buku::pluck('id')->toArray();

        if (empty($members) || empty($bukuIds)) {
            return;
        }

        $reservations = [
            // Menunggu
            ['member' => 0, 'buku' => 14, 'status' => 'waiting',   'reserved' => '-2 days',  'notified' => null],
            ['member' => 1, 'buku' => 16, 'status' => 'waiting',   'reserved' => '-1 days',  'notified' => null],
            ['member' => 2, 'buku' => 22, 'status' => 'waiting',   'reserved' => '-3 days',  'notified' => null],

            // Tersedia (sudah dinotifikasi)
            ['member' => 3, 'buku' => 13, 'status' => 'available', 'reserved' => '-5 days',  'notified' => '-1 days'],
            ['member' => 4, 'buku' => 17, 'status' => 'available', 'reserved' => '-4 days',  'notified' => '-1 days'],

            // Terpenuhi
            ['member' => 5, 'buku' => 19, 'status' => 'fulfilled', 'reserved' => '-10 days', 'notified' => '-7 days'],
            ['member' => 6, 'buku' => 21, 'status' => 'fulfilled', 'reserved' => '-8 days',  'notified' => '-5 days'],

            // Dibatalkan
            ['member' => 7, 'buku' => 23, 'status' => 'cancelled', 'reserved' => '-6 days',  'notified' => null],
            ['member' => 0, 'buku' => 24, 'status' => 'cancelled', 'reserved' => '-12 days', 'notified' => null],
        ];

        foreach ($reservations as $r) {
            $memberIdx = $r['member'] % count($members);
            $bukuIdx   = $r['buku'] % count($bukuIds);

            BookReservation::create([
                'member_id'   => $members[$memberIdx],
                'buku_id'     => $bukuIds[$bukuIdx],
                'status'      => $r['status'],
                'reserved_at' => now()->modify($r['reserved']),
                'notified_at' => $r['notified'] ? now()->modify($r['notified']) : null,
            ]);
        }
    }
}
