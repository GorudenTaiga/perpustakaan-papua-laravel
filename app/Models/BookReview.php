<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    protected $fillable = [
        'member_id',
        'buku_id',
        'rating',
        'review',
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
