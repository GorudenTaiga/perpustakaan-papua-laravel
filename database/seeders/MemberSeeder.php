<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala perpustakaan
        $kepala = User::firstOrCreate(
            ['email' => 'kepala@example.com'],
            ['name' => 'Kepala Perpustakaan', 'password' => bcrypt('password'), 'role' => 'kepala']
        );

        // Member users
        $members = [
            ['name' => 'Andi Pratama',   'email' => 'andi@example.com'],
            ['name' => 'Budi Santoso',   'email' => 'budi@example.com'],
            ['name' => 'Citra Dewi',     'email' => 'citra@example.com'],
            ['name' => 'Dian Permata',   'email' => 'dian@example.com'],
            ['name' => 'Eka Saputra',    'email' => 'eka@example.com'],
            ['name' => 'Fitri Handayani','email' => 'fitri@example.com'],
            ['name' => 'Gilang Ramadhan','email' => 'gilang@example.com'],
            ['name' => 'Hana Safitri',   'email' => 'hana@example.com'],
            ['name' => 'Ivan Gunawan',   'email' => 'ivan@example.com'],
            ['name' => 'Joko Widodo',    'email' => 'joko@example.com'],
        ];

        $jenis = ['Pelajar', 'Mahasiswa', 'Guru', 'Dosen', 'Umum'];

        foreach ($members as $i => $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => bcrypt('password'), 'role' => 'member']
            );

            Member::firstOrCreate(
                ['users_id' => $user->id],
                [
                    'membership_number' => 'MBR-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'valid_date' => now()->addYear()->toDateString(),
                    'jenis' => $jenis[$i % count($jenis)],
                    'image' => null,
                    'document_path' => null,
                    'verif' => $i < 8, // 8 verified, 2 unverified
                ]
            );
        }
    }
}
