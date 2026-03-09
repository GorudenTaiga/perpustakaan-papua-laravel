<?php

namespace App\Filament\Resources\Admin\BookReservations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookReservationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.user.name')
                    ->label('Anggota')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),
                TextColumn::make('buku.judul')
                    ->label('Buku')
                    ->sortable()
                    ->searchable()
                    ->limit(35)
                    ->tooltip(fn ($record) => $record->buku?->judul),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'waiting' => 'warning',
                        'available' => 'success',
                        'fulfilled' => 'info',
                        'cancelled' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'waiting' => 'Menunggu',
                        'available' => 'Tersedia',
                        'fulfilled' => 'Terpenuhi',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    })
                    ->icon(fn ($state) => match ($state) {
                        'waiting' => 'heroicon-o-clock',
                        'available' => 'heroicon-o-check-circle',
                        'fulfilled' => 'heroicon-o-gift',
                        'cancelled' => 'heroicon-o-x-circle',
                        default => null,
                    }),
                TextColumn::make('reserved_at')
                    ->label('Tgl Reservasi')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('notified_at')
                    ->label('Diberitahu')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Belum diberitahu')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Menunggu',
                        'available' => 'Tersedia',
                        'fulfilled' => 'Terpenuhi',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
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
