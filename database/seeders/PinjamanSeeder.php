<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pinjaman;
use App\Models\Member;
use App\Models\Buku;

class PinjamanSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::where('verif', true)->pluck('membership_number')->toArray();
        $bukuIds = Buku::pluck('id')->toArray();

        if (empty($members) || empty($bukuIds)) {
            return;
        }

        $loans = [
            // Sudah dikembalikan
            ['member' => 0, 'buku' => 0, 'qty' => 1, 'loan' => '-30 days', 'due' => '-16 days', 'return' => '-18 days', 'status' => 'dikembalikan', 'verif' => true],
            ['member' => 1, 'buku' => 1, 'qty' => 1, 'loan' => '-25 days', 'due' => '-11 days', 'return' => '-12 days', 'status' => 'dikembalikan', 'verif' => true],
            ['member' => 2, 'buku' => 2, 'qty' => 2, 'loan' => '-20 days', 'due' => '-6 days',  'return' => '-7 days',  'status' => 'dikembalikan', 'verif' => true],
            ['member' => 3, 'buku' => 5, 'qty' => 1, 'loan' => '-40 days', 'due' => '-26 days', 'return' => '-25 days', 'status' => 'dikembalikan', 'verif' => true],
            ['member' => 0, 'buku' => 8, 'qty' => 1, 'loan' => '-15 days', 'due' => '-1 days',  'return' => '-2 days',  'status' => 'dikembalikan', 'verif' => true],

            // Sedang dipinjam
            ['member' => 4, 'buku' => 3, 'qty' => 1, 'loan' => '-5 days',  'due' => '+9 days',  'return' => null, 'status' => 'dipinjam', 'verif' => true],
            ['member' => 5, 'buku' => 4, 'qty' => 1, 'loan' => '-3 days',  'due' => '+11 days', 'return' => null, 'status' => 'dipinjam', 'verif' => true],
            ['member' => 6, 'buku' => 6, 'qty' => 2, 'loan' => '-7 days',  'due' => '+7 days',  'return' => null, 'status' => 'dipinjam', 'verif' => true],
            ['member' => 1, 'buku' => 10,'qty' => 1, 'loan' => '-2 days',  'due' => '+12 days', 'return' => null, 'status' => 'dipinjam', 'verif' => true],

            // Jatuh tempo
            ['member' => 7, 'buku' => 7, 'qty' => 1, 'loan' => '-20 days', 'due' => '-6 days',  'return' => null, 'status' => 'jatuh_tempo', 'verif' => true],
            ['member' => 2, 'buku' => 9, 'qty' => 1, 'loan' => '-18 days', 'due' => '-4 days',  'return' => null, 'status' => 'jatuh_tempo', 'verif' => true],

            // Menunggu verifikasi
            ['member' => 3, 'buku' => 11,'qty' => 1, 'loan' => '-1 days',  'due' => '+13 days', 'return' => null, 'status' => 'menunggu_verif', 'verif' => false],
            ['member' => 4, 'buku' => 12,'qty' => 1, 'loan' => '0 days',   'due' => '+14 days', 'return' => null, 'status' => 'menunggu_verif', 'verif' => false],
            ['member' => 5, 'buku' => 15,'qty' => 2, 'loan' => '0 days',   'due' => '+14 days', 'return' => null, 'status' => 'menunggu_verif', 'verif' => false],

            // Dipinjam + extended
            ['member' => 0, 'buku' => 20,'qty' => 1, 'loan' => '-12 days', 'due' => '+9 days',  'return' => null, 'status' => 'dipinjam', 'verif' => true, 'extended' => true, 'extension_date' => '-2 days'],
        ];

        foreach ($loans as $loan) {
            $memberIdx = $loan['member'] % count($members);
            $bukuIdx   = $loan['buku'] % count($bukuIds);

            Pinjaman::create([
                'member_id'      => $members[$memberIdx],
                'buku_id'        => $bukuIds[$bukuIdx],
                'quantity'       => $loan['qty'],
                'loan_date'      => now()->modify($loan['loan'])->toDateString(),
                'due_date'       => now()->modify($loan['due'])->toDateString(),
                'return_date'    => $loan['return'] ? now()->modify($loan['return'])->toDateString() : null,
                'status'         => $loan['status'],
                'total_price'    => 0,
                'verif'          => $loan['verif'],
                'extended'       => $loan['extended'] ?? false,
                'extension_date' => isset($loan['extension_date']) ? now()->modify($loan['extension_date'])->toDateString() : null,
            ]);
        }
    }
}
