<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pinjaman;
use App\Models\Member;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $table = 'report';

    protected $fillable = [
        'total_registrations',
        'total_members',
        'total_loans',
        'total_returns',
    ];

    protected $casts = [
        'total_registrations' => 'integer',
        'total_members' => 'integer',
        'total_loans' => 'integer',
        'total_returns' => 'integer',
    ];

    public static function calculateTotals()
    {
        $totalRegistrations = Member::count();
        $totalMembers = Member::count();
        $totalLoans = Pinjaman::count();
        $totalReturns = Pinjaman::where('status', 'dikembalikan')->count();

        return [
            'total_registrations' => $totalRegistrations,
            'total_members' => $totalMembers,
            'total_loans' => $totalLoans,
            'total_returns' => $totalReturns,
        ];
    }
}