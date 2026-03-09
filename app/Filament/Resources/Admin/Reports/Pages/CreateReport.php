<?php

namespace App\Filament\Resources\Admin\Reports\Pages;

use App\Filament\Resources\Admin\Reports\ReportResource;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Models\Report;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $start = $data['period_start'];
        $end = $data['period_end'];

        // Basic summary counts
        $data['total_registrations'] = Member::whereBetween('created_at', [$start, $end])->count();
        $data['total_members'] = Member::count();
        $data['total_loans'] = Pinjaman::whereBetween('created_at', [$start, $end])->count();
        $data['total_returns'] = Pinjaman::where('status', 'dikembalikan')
            ->whereBetween('return_date', [$start, $end])->count();
        $data['generated_by'] = Auth::id();

        // Comprehensive report data
        $data['data'] = Report::generateReportData($start, $end);

        return $data;
    }
}