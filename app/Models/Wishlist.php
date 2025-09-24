<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    /** @use HasFactory<\Database\Factories\WishlistFactory> */
    use HasFactory;

    protected $fillable = [
        'member_id',
        'buku_id'
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id', 'membership_number');
    }

    public function buku() {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
}