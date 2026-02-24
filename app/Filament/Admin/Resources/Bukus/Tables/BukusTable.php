<?php

namespace App\Filament\Admin\Resources\Bukus\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Storage;

class BukusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->label('UUID')
                    ->searchable(),
                ImageColumn::make('banner') 
                    ->getStateUsing(fn ($record) => Storage::disk('public')->url($record->banner))
                    ->toggleable(false),
                TextColumn::make('judul')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('author')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('publisher')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('year')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('stock')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('denda_per_hari')
                    ->label('Denda/Hari')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('slug')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('category_id')
                    ->label('Kategori')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '-';
                        }

                        // Kalau masih string JSON, decode ke array
                        if (is_string($state)) {
                            $decoded = json_decode($state, true);
                            $state = is_array($decoded) ? $decoded : [$state];
                        }

                        // Kalau integer atau bukan array, jadikan array
                        if (!is_array($state)) {
                            $state = [$state];
                        }

                        // Pastikan array of int
                        $ids = array_map('intval', $state);

                        $categories = Category::whereIn('id', $ids)->pluck('nama');

                        return $categories->isNotEmpty()
                            ? $categories->implode(', ')
                            : '-';
                    })
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge()
                    ->color('success'),
                TextColumn::make('images_count')
                    ->label('Image Count')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categories')
                ->multiple()
                ->label('Category')
                ->options(Category::pluck('nama', 'id'))
                ->query(function ($query, $data) {
                    $values = $data['values'] ?? [];
                    logger()->info('Filter values: ', $values);
                    if (blank($values)) {
                        return $query;
                    }

                    return $query->where(function ($q) use ($values) {
                        foreach ($values as $value) {
                            $q->orWhereJsonContains('category_id', (string) $value);
                        }
                    });
                })
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}