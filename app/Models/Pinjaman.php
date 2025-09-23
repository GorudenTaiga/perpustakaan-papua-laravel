<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    /** @use HasFactory<\Database\Factories\PinjamanFactory> */
    use HasFactory;

    protected $table = 'pinjaman';

    protected $fillable = [
        'member_id',
        'buku_id',
        'quantity',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'total_price',
        'discount',
        'final_price'
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id', 'membership_number');
    }

    public function buku() {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
}