<?php

namespace App\Filament\Resources\Admin\Pinjamen\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PinjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.user.name')
                    ->label('Nama Peminjam')
                    ->sortable(),
                TextColumn::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Batas Pinjam')
                    ->sortable(),
                TextColumn::make('return_date')
                    ->label('Tanggal Pengembalian')
                    ->default('Belum dikembalikan')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        'jatuh_tempo' => 'danger',
                        default => '',
                    })
                    ->searchable(),
                TextColumn::make('final_price')
                    ->numeric()
                    ->sortable(),
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
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}