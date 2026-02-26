<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'member_id',
        'plan',
        'amount',
        'payment_method',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public const PLANS = [
        '1_bulan'  => ['label' => '1 Bulan',  'duration_months' => 1,  'price' => 50000],
        '3_bulan'  => ['label' => '3 Bulan',  'duration_months' => 3,  'price' => 125000],
        '6_bulan'  => ['label' => '6 Bulan',  'duration_months' => 6,  'price' => 225000],
        '12_bulan' => ['label' => '12 Bulan', 'duration_months' => 12, 'price' => 400000],
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'membership_number');
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date?->isFuture();
    }
}
