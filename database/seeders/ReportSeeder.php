<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::create([
            'total_registrations' => 150,
            'total_members' => 120,
            'total_loans' => 85,
            'total_returns' => 70,
        ]);

        Report::create([
            'total_registrations' => 200,
            'total_members' => 180,
            'total_loans' => 120,
            'total_returns' => 95,
        ]);

        Report::create([
            'total_registrations' => 175,
            'total_members' => 160,
            'total_loans' => 110,
            'total_returns' => 100,
        ]);
    }
}