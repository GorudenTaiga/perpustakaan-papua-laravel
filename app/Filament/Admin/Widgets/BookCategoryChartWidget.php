<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;
use App\Models\Buku;

class BookCategoryChartWidget extends ChartWidget
{
    protected ?string $heading = 'Distribusi Buku per Kategori';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // $data = Buku::join('categories', 'buku.category_id', '=', 'categories.id')
        //     ->selectRaw('categories.nama as category, COUNT(buku.id) as count')
        //     ->groupBy('categories.nama')
        //     ->orderBy('count', 'desc')
        //     ->pluck('count', 'category')
        //     ->toArray();
        // return [
        //     'datasets' => [
        //         [
        //             'label' => 'Jumlah Buku',
        //             'data' => array_values($data),
        //             'backgroundColor' => [
        //                 'rgb(255, 99, 132)',
        //                 'rgb(54, 162, 235)',
        //                 'rgb(255, 205, 86)',
        //                 'rgb(75, 192, 192)',
        //                 'rgb(153, 102, 255)',
        //                 'rgb(255, 159, 64)',
        //             ],
        //         ],
        //     ],
        //     'labels' => array_keys($data),
        // ];

        $categories = Category::all()->pluck('nama', 'id')->toArray();

        // Ambil semua buku dan langsung flatMap category_id (karena sudah array, bukan string JSON)
        $data = Buku::all()->flatMap(function ($buku) {
            return $buku->category_id ?? [];
        })
        ->countBy() // hitung jumlah per category_id
        ->mapWithKeys(fn ($count, $categoryId) => [$categories[$categoryId] ?? 'Unknown' => $count])
        ->sortDesc();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Buku',
                    'data' => array_values($data->toArray()),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)',
                    ],
                ],
            ],
            'labels' => array_keys($data->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}