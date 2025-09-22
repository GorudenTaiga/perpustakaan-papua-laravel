<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Models\Payments;

class LibraryStatsWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            StatsOverviewWidget\Stat::make('Total Buku', Buku::count()),
            StatsOverviewWidget\Stat::make('Total Member', Member::count()),
            StatsOverviewWidget\Stat::make('Total Pinjaman', Pinjaman::count()),
            StatsOverviewWidget\Stat::make('Total Pembayaran', Payments::count()),
        ];
    }
}