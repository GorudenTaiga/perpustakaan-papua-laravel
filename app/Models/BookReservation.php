<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReservation extends Model
{
    protected $fillable = [
        'member_id',
        'buku_id',
        'status',
        'reserved_at',
        'notified_at',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
        'notified_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'membership_number');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
}
