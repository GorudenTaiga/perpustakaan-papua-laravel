<?php

namespace App\Filament\Resources\Admin\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pinjaman.member.user.name')
                    ->label('Nama Peminjam')
                    ->sortable(),
                TextColumn::make('pinjaman.buku.judul')
                    ->label('Buku')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Jumlah Denda')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('payment_date')
                    ->label('Tanggal Bayar')
                    ->date()
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
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
