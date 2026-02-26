<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payments;
use App\Models\Pinjaman;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        // Pembayaran denda untuk pinjaman yang dikembalikan & jatuh tempo
        $pinjamanDikembalikan = Pinjaman::where('status', 'dikembalikan')->get();
        $pinjamanJatuhTempo   = Pinjaman::where('status', 'jatuh_tempo')->get();

        $methods = ['cash', 'transfer', 'qris'];

        foreach ($pinjamanDikembalikan as $i => $pinjaman) {
            // Hanya buat payment jika ada keterlambatan
            $dueDate    = \Carbon\Carbon::parse($pinjaman->due_date);
            $returnDate = \Carbon\Carbon::parse($pinjaman->return_date);
            if ($returnDate->gt($dueDate)) {
                $daysLate = $returnDate->diffInDays($dueDate);
                Payments::create([
                    'pinjaman_id'    => $pinjaman->id,
                    'amount'         => $daysLate * 1000 * $pinjaman->quantity,
                    'payment_date'   => $pinjaman->return_date,
                    'payment_method' => $methods[$i % 2],
                ]);
            }
        }

        // Pembayaran sebagian untuk pinjaman jatuh tempo
        foreach ($pinjamanJatuhTempo as $i => $pinjaman) {
            Payments::create([
                'pinjaman_id'    => $pinjaman->id,
                'amount'         => 5000,
                'payment_date'   => now()->subDays(2)->toDateString(),
                'payment_method' => $methods[$i % 2],
            ]);
        }
    }
}
