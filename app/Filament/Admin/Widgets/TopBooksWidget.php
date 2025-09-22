<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TopBooksWidget extends BaseWidget
{
    protected static ?string $heading = '5 Buku Teratas';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\Buku::query()
                    ->select(
                        'buku.*',
                        DB::raw('COUNT(pinjaman.quantity) as total_pinjaman'),
                        DB::raw('SUM(COALESCE(pinjaman.final_price, pinjaman.total_price)) as total_pendapatan')
                    )
                    ->leftJoin('pinjaman', 'buku.id', '=', 'pinjaman.buku_id')
                    ->leftJoin('categories', 'buku.category_id', '=', 'categories.id')
                    ->groupBy(
                        'buku.id',
                    'buku.uuid',
                        'buku.judul',
                        'buku.author',
                        'buku.publisher',
                        'buku.year',
                        'buku.stock',
                        'buku.price_per_day',
                        'buku.max_days',
                        'buku.deskripsi',
                        'buku.slug',
                        'buku.category_id',
                        'buku.rating',
                        'buku.banner',
                        'buku.created_at',
                        'buku.updated_at'
                    )
                    ->orderBy('total_pinjaman', 'desc')
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('category_id')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '-';
                        }

                        // Kalau masih string JSON, decode ke array
                        if (is_string($state)) {
                            $decoded = json_decode($state, true);
                            $state = is_array($decoded) ? $decoded : [$state];
                        }

                        // Pastikan array of int
                        $ids = array_map('intval', $state);

                        $categories = Category::whereIn('id', $ids)->pluck('nama');

                        return $categories->isNotEmpty()
                            ? $categories->implode(', ')
                            : '-';
                    })
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->alignCenter(),

                Tables\Columns\BadgeColumn::make('total_pinjaman')
                    ->label('Total Dipinjam')
                    ->numeric()
                    ->alignCenter()
                    ->color('success'),

                Tables\Columns\TextColumn::make('price_per_day')
                    ->label('Harga/Hari')
                    ->money('IDR')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_pendapatan')
                    ->label('Total Pendapatan')
                    ->money('IDR')
                    ->alignCenter()
                    ->color('primary'),
            ])
            ->defaultSort('total_pinjaman', 'desc')
            ->striped();
    }
}