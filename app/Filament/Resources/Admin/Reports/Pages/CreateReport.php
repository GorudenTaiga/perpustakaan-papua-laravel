<?php

namespace App\Filament\Resources\Admin\Reports\Pages;

use App\Filament\Resources\Admin\Reports\ReportResource;
use App\Models\Member;
use App\Models\Pinjaman;
use Filament\Resources\Pages\CreateRecord;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $totalRegistrations = Member::where('role', '!=', 'admin')->where('role', '!=', 'kepala')->count();
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