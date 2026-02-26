<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\Member;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::pluck('membership_number')->toArray();

        if (empty($members)) {
            return;
        }

        $subscriptions = [
            // Member 0,1,2 - Premium aktif (berbagai paket)
            ['member' => 0, 'plan' => '3_bulan',  'amount' => 125000, 'method' => 'transfer', 'status' => 'active',  'start' => '-30 days',  'end' => '+60 days'],
            ['member' => 1, 'plan' => '12_bulan', 'amount' => 400000, 'method' => 'qris',     'status' => 'active',  'start' => '-60 days',  'end' => '+305 days'],
            ['member' => 2, 'plan' => '6_bulan',  'amount' => 225000, 'method' => 'cash',     'status' => 'active',  'start' => '-10 days',  'end' => '+170 days'],

            // Member 3 - Premium expired (pernah langganan, sudah habis)
            ['member' => 3, 'plan' => '1_bulan',  'amount' => 50000,  'method' => 'qris',     'status' => 'expired', 'start' => '-45 days',  'end' => '-15 days'],

            // Member 4 - Pending payment
            ['member' => 4, 'plan' => '3_bulan',  'amount' => 125000, 'method' => 'transfer', 'status' => 'pending', 'start' => null,         'end' => null],

            // Member 5 - Cancelled
            ['member' => 5, 'plan' => '1_bulan',  'amount' => 50000,  'method' => 'cash',     'status' => 'cancelled','start' => null,        'end' => null],

            // Member 1 - Riwayat sebelumnya (expired, lalu perpanjang)
            ['member' => 1, 'plan' => '1_bulan',  'amount' => 50000,  'method' => 'cash',     'status' => 'expired', 'start' => '-100 days', 'end' => '-70 days'],
        ];

        foreach ($subscriptions as $s) {
            $memberIdx = $s['member'] % count($members);

            Subscription::create([
                'member_id'      => $members[$memberIdx],
                'plan'           => $s['plan'],
                'amount'         => $s['amount'],
                'payment_method' => $s['method'],
                'status'         => $s['status'],
                'start_date'     => $s['start'] ? now()->modify($s['start'])->toDateString() : null,
                'end_date'       => $s['end'] ? now()->modify($s['end'])->toDateString() : null,
            ]);
        }

        // Update tier pada member yang punya langganan aktif
        foreach (Member::all() as $member) {
            $activeSubscription = Subscription::where('member_id', $member->membership_number)
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->latest()
                ->first();

            if ($activeSubscription) {
                $member->update([
                    'tier' => 'premium',
                    'tier_expired_at' => $activeSubscription->end_date,
                ]);
            }
        }
    }
}
