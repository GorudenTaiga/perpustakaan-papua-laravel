<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $table = 'member';

    protected $fillable = [
        'users_id',
        'valid_date',
        'jenis',
        'membership_number',
        'image'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function wishlist() {
        return $this->belongsTo(Wishlist::class, 'membership_number', 'member_id');
    }
}