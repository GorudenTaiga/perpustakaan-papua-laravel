<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Buku;
use App\Models\Category;
use App\Models\Member;
use App\Models\Pinjaman;

class LibraryStatsWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            StatsOverviewWidget\Stat::make('Total Buku', Buku::count())
                ->description('Koleksi perpustakaan')
                ->icon('heroicon-o-book-open'),
            StatsOverviewWidget\Stat::make('Total Member', Member::count())
                ->description('Anggota terdaftar')
                ->icon('heroicon-o-user-group'),
            StatsOverviewWidget\Stat::make('Sedang Dipinjam', Pinjaman::where('status', 'dipinjam')->count())
                ->description('Buku sedang dipinjam')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning'),
            StatsOverviewWidget\Stat::make('Dikembalikan', Pinjaman::where('status', 'dikembalikan')->count())
                ->description('Total pengembalian')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),
            StatsOverviewWidget\Stat::make('Jatuh Tempo', Pinjaman::where('status', 'jatuh_tempo')->count())
                ->description('Terlambat dikembalikan')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),
            StatsOverviewWidget\Stat::make('Total Kategori', Category::count())
                ->description('Kategori buku')
                ->icon('heroicon-o-tag'),
        ];
    }
}