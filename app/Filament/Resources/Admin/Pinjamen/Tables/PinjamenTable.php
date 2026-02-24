<?php

namespace App\Filament\Resources\Admin\Pinjamen\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
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
                TextColumn::make('buku.judul')
                    ->label('Judul Buku')
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
                        'menunggu_verif' => 'primary',
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        'jatuh_tempo' => 'danger',
                        default => '',
                    })
                    ->searchable(),
                ToggleColumn::make('verif')
                    ->label('Terverifikasi')
                    ->afterStateUpdated(function (bool $state, $record) {
                        $record->update(['verif' => $state]);
                        $record->update(['status' => $state ? 'dipinjam' : 'menunggu_verif']);
                    })
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Jumlah')
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