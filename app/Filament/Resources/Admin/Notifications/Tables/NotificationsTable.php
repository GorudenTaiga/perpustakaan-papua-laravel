<?php

namespace App\Filament\Resources\Admin\Notifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NotificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.user.name')
                    ->label('Penerima')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'buku_baru' => 'success',
                        'deadline_peminjaman' => 'warning',
                        'denda' => 'danger',
                        'update_profile' => 'info',
                        'peminjaman' => 'primary',
                        'reservasi' => 'info',
                        'custom' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'buku_baru' => 'Buku Baru',
                        'deadline_peminjaman' => 'Deadline',
                        'denda' => 'Denda',
                        'update_profile' => 'Profile',
                        'peminjaman' => 'Peminjaman',
                        'reservasi' => 'Reservasi',
                        'custom' => 'Custom',
                        default => $state,
                    })
                    ->icon(fn ($state) => match ($state) {
                        'buku_baru' => 'heroicon-o-book-open',
                        'deadline_peminjaman' => 'heroicon-o-clock',
                        'denda' => 'heroicon-o-banknotes',
                        'update_profile' => 'heroicon-o-user',
                        'peminjaman' => 'heroicon-o-document-text',
                        'reservasi' => 'heroicon-o-calendar',
                        'custom' => 'heroicon-o-megaphone',
                        default => null,
                    }),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->title),
                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->message)
                    ->toggleable(),
                IconColumn::make('read_at')
                    ->label('Dibaca')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->read_at !== null)
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'buku_baru' => 'Buku Baru',
                        'deadline_peminjaman' => 'Deadline',
                        'denda' => 'Denda',
                        'update_profile' => 'Profile',
                        'peminjaman' => 'Peminjaman',
                        'reservasi' => 'Reservasi',
                        'custom' => 'Custom',
                    ]),
                TernaryFilter::make('read')
                    ->label('Status Baca')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah Dibaca')
                    ->falseLabel('Belum Dibaca')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('read_at'),
                        false: fn ($query) => $query->whereNull('read_at'),
                    ),
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
