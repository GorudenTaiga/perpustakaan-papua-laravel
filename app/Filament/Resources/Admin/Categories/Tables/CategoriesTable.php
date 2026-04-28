<?php

namespace App\Filament\Resources\Admin\Categories\Tables;

use App\Models\Buku;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Storage;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Ikon')
                    ->getStateUsing(fn ($record) => $record->image ? Storage::disk('s3')->url($record->image) : null)
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=K&background=6366f1&color=fff')
                    ->size(40),
                TextColumn::make('nama')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('book_count')
                    ->label('Jumlah Buku')
                    ->getStateUsing(function ($record) {
                        return Buku::whereJsonContains('category_id', $record->id)->count()
                            ?: Buku::whereJsonContains('category_id', (string) $record->id)->count();
                    })
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->suffix(' buku'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nama', 'asc')
            ->filters([
                //
            ])
            ->recordActions([
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
            ->striped();
    }
}