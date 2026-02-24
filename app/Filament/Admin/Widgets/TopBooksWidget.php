<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Buku;
use App\Models\Category;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TopBooksWidget extends BaseWidget
{
    protected static ?string $heading = 'Leaderboard Buku';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Buku::query()
                ->select(
                    'buku.id',
                    'buku.judul',
                    'buku.category_id',
                    DB::raw('COUNT(pinjaman.id) as total_pinjaman'),
                    DB::raw('SUM(CASE WHEN pinjaman.status = \'dipinjam\' THEN 1 ELSE 0 END) as sedang_dipinjam')
                )
                ->leftJoin('pinjaman', 'buku.id', '=', 'pinjaman.buku_id')
                ->groupBy('buku.id', 'buku.judul', 'buku.category_id')
                ->orderByDesc('total_pinjaman')
                ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('author')
                    ->label('Penulis')
                    ->getStateUsing(fn ($record) => $record->author ? $record->author : '')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category_id')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '-';
                        }

                        if (is_string($state)) {
                            $decoded = json_decode($state, true);
                            $state = is_array($decoded) ? $decoded : [$state];
                        }

                        if (!is_array($state)) {
                            $state = [$state];
                        }

                        $ids = array_map('intval', $state);
                        $categories = Category::whereIn('id', $ids)->pluck('nama');

                        return $categories->isNotEmpty()
                            ? $categories->implode(', ')
                            : '-';
                    })
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok Tersedia')
                    ->numeric()
                    ->alignCenter(),

                Tables\Columns\BadgeColumn::make('total_pinjaman')
                    ->label('Total Peminjaman')
                    ->numeric()
                    ->alignCenter()
                    ->color('success'),

                Tables\Columns\BadgeColumn::make('sedang_dipinjam')
                    ->label('Sedang Dipinjam')
                    ->numeric()
                    ->alignCenter()
                    ->color('warning'),
            ])
            ->defaultSort('total_pinjaman', 'desc')
            ->striped();
    }
}