<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\DB;

class LoanChartWidget extends ChartWidget
{
    /* The line `// protected ?string  = 'Statistik Peminjaman Bulanan';` is a commented out
    line of code in PHP. In PHP, the `//` syntax is used to add comments in the code, which are
    ignored by the PHP interpreter and are meant for human readers to understand the code. */
    protected ?string $heading = 'Statistik Peminjaman Bulanan';

    protected function getData(): array
    {
        $data = Pinjaman::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    ->whereYear('created_at', date('Y'))
    ->groupByRaw('MONTH(created_at)')
    ->orderByRaw('MONTH(created_at)')
    ->pluck('count', 'month')
    ->toArray();

        $months = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $counts[] = $data[str_pad($i, 2, '0', STR_PAD_LEFT)] ?? 0;
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