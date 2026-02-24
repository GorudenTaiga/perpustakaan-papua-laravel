<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pinjaman;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\DB;

class LoanChartWidget extends ChartWidget
{
    protected ?string $heading = 'Statistik Peminjaman Bulanan';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $currentYear = date('Y');
        $monthExpr = DatabaseHelper::monthExpression('created_at');
        $yearExpr = DatabaseHelper::yearExpression('created_at');
        
        $data = Pinjaman::selectRaw("{$monthExpr} as month, COUNT(*) as count")
            ->whereRaw("{$yearExpr} = ?", [$currentYear])
            ->groupByRaw($monthExpr)
            ->orderByRaw($monthExpr)
            ->pluck('count', 'month')
            ->toArray();

        $months = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            // SQLite returns '01', '02', etc. MySQL returns 1, 2, etc.
            $monthKey = DatabaseHelper::isSqlite() ? str_pad($i, 2, '0', STR_PAD_LEFT) : $i;
            $counts[] = $data[$monthKey] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjaman',
                    'data' => $counts,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}