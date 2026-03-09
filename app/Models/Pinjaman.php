<?php

namespace App\Models;

use App\Observers\PinjamanObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(PinjamanObserver::class)]
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
        'uuid',
        'verif',
        'extended',
        'extension_date'
    ];

    protected $casts = [
        'verif' => 'boolean',
        'extended' => 'boolean',
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id', 'membership_number');
    }

    public function buku() {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }

    public function payments() {
        return $this->hasMany(Payments::class, 'pinjaman_id', 'id');
    }
}