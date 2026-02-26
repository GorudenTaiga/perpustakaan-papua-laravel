<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookReview;
use App\Models\Member;
use App\Models\Buku;

class BookReviewSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::where('verif', true)->pluck('membership_number')->toArray();
        $bukuIds = Buku::pluck('id')->toArray();

        if (empty($members) || empty($bukuIds)) {
            return;
        }

        $reviewTexts = [
            'Buku yang sangat bagus dan inspiratif! Recommended banget.',
            'Isinya sangat informatif, cocok untuk menambah wawasan.',
            'Ceritanya seru dan tidak membosankan. Saya baca sampai habis.',
            'Penulisannya rapi dan mudah dipahami. Sangat menyenangkan.',
            'Buku ini biasa saja, tapi lumayan untuk mengisi waktu luang.',
            'Sangat bermanfaat untuk belajar. Topiknya sangat relevan.',
            'Agak membosankan di awal, tapi semakin seru di pertengahan.',
            'Masterpiece! Setiap halaman penuh dengan insight baru.',
            'Bagus untuk pemula yang ingin belajar topik ini.',
            'Buku wajib baca untuk semua kalangan.',
            null,
            null,
        ];

        $ratings = [5, 4, 5, 4, 3, 5, 3, 5, 4, 5, 4, 3];

        $reviews = [
            ['member' => 0, 'buku' => 0],
            ['member' => 0, 'buku' => 1],
            ['member' => 1, 'buku' => 0],
            ['member' => 1, 'buku' => 2],
            ['member' => 2, 'buku' => 3],
            ['member' => 2, 'buku' => 5],
            ['member' => 3, 'buku' => 1],
            ['member' => 3, 'buku' => 8],
            ['member' => 4, 'buku' => 0],
            ['member' => 4, 'buku' => 4],
            ['member' => 5, 'buku' => 6],
            ['member' => 5, 'buku' => 7],
            ['member' => 6, 'buku' => 2],
            ['member' => 6, 'buku' => 9],
            ['member' => 7, 'buku' => 3],
            ['member' => 7, 'buku' => 10],
            ['member' => 0, 'buku' => 15],
            ['member' => 1, 'buku' => 18],
            ['member' => 2, 'buku' => 20],
            ['member' => 3, 'buku' => 25],
        ];

        foreach ($reviews as $i => $r) {
            $memberIdx = $r['member'] % count($members);
            $bukuIdx   = $r['buku'] % count($bukuIds);

            BookReview::firstOrCreate(
                [
                    'member_id' => $members[$memberIdx],
                    'buku_id'   => $bukuIds[$bukuIdx],
                ],
                [
                    'rating' => $ratings[$i % count($ratings)],
                    'review' => $reviewTexts[$i % count($reviewTexts)],
                ]
            );
        }
    }
}
