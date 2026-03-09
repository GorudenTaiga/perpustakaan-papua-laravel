<?php

namespace App\Filament\Admin\Resources\Bukus\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Storage;

class BukusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('banner')
                    ->label('Cover')
                    ->getStateUsing(fn ($record) => $record->banner ? Storage::disk('s3')->url($record->banner) : null)
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=B&background=f59e0b&color=fff')
                    ->size(45),
                TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->judul)
                    ->description(fn ($record) => $record->author ? "oleh {$record->author}" : null),
                TextColumn::make('publisher')
                    ->label('Penerbit')
                    ->searchable()
                    ->toggleable()
                    ->icon('heroicon-o-building-library')
                    ->placeholder('—'),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state <= 0 => 'danger',
                        $state <= 5 => 'warning',
                        default => 'success',
                    })
                    ->icon(fn (int $state): string => match(true) {
                        $state <= 0 => 'heroicon-o-x-circle',
                        $state <= 5 => 'heroicon-o-exclamation-triangle',
                        default => 'heroicon-o-check-circle',
                    }),
                TextColumn::make('denda_per_hari')
                    ->label('Denda/Hari')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('category_id')
                    ->label('Kategori')
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
                    ->badge()
                    ->color('primary'),
                TextColumn::make('average_rating')
                    ->label('Rating')
                    ->getStateUsing(fn ($record) => $record->average_rating > 0
                        ? number_format($record->average_rating, 1) . ' ⭐'
                        : '—')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable()
                    ->fontFamily('mono')
                    ->size('sm'),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->fontFamily('mono')
                    ->size('sm'),
                TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('categories')
                    ->multiple()
                    ->label('Kategori')
                    ->options(Category::pluck('nama', 'id'))
                    ->query(function ($query, $data) {
                        $values = $data['values'] ?? [];
                        if (blank($values)) {
                            return $query;
                        }
                        return $query->where(function ($q) use ($values) {
                            foreach ($values as $value) {
                                $q->orWhereJsonContains('category_id', (int) $value);
                            }
                        });
                    }),
                TernaryFilter::make('stock_status')
                    ->label('Ketersediaan')
                    ->placeholder('Semua')
                    ->trueLabel('Tersedia')
                    ->falseLabel('Habis')
                    ->queries(
                        true: fn ($query) => $query->where('stock', '>', 0),
                        false: fn ($query) => $query->where('stock', '<=', 0),
                    ),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50]);
    }
}