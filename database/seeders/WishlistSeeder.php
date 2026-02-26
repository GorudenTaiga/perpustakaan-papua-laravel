<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wishlist;
use App\Models\Member;
use App\Models\Buku;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::pluck('membership_number')->toArray();
        $bukuIds = Buku::pluck('id')->toArray();

        if (empty($members) || empty($bukuIds)) {
            return;
        }

        // Setiap member punya 2-3 wishlist items
        $wishlists = [
            ['member' => 0, 'buku' => 2],
            ['member' => 0, 'buku' => 5],
            ['member' => 0, 'buku' => 15],
            ['member' => 1, 'buku' => 3],
            ['member' => 1, 'buku' => 8],
            ['member' => 2, 'buku' => 1],
            ['member' => 2, 'buku' => 12],
            ['member' => 3, 'buku' => 4],
            ['member' => 3, 'buku' => 18],
            ['member' => 4, 'buku' => 7],
            ['member' => 4, 'buku' => 10],
            ['member' => 5, 'buku' => 0],
            ['member' => 5, 'buku' => 6],
            ['member' => 6, 'buku' => 9],
            ['member' => 7, 'buku' => 11],
        ];

        foreach ($wishlists as $w) {
            $memberIdx = $w['member'] % count($members);
            $bukuIdx   = $w['buku'] % count($bukuIds);

            Wishlist::firstOrCreate([
                'member_id' => $members[$memberIdx],
                'buku_id'   => (string) $bukuIds[$bukuIdx],
            ]);
        }
    }
}
