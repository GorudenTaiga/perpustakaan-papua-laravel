<?php

namespace App\Filament\Resources\Admin\Pinjamen\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PinjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.user.name')
                    ->label('Peminjam')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),
                TextColumn::make('buku.judul')
                    ->label('Buku')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->buku?->judul),
                TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('loan_date')
                    ->label('Tgl Pinjam')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),
                TextColumn::make('due_date')
                    ->label('Batas Kembali')
                    ->date('d M Y')
                    ->sortable()
                    ->color(fn ($record) => $record->status !== 'dikembalikan' && $record->due_date && $record->due_date < now()->format('Y-m-d') ? 'danger' : null)
                    ->icon(fn ($record) => $record->status !== 'dikembalikan' && $record->due_date && $record->due_date < now()->format('Y-m-d') ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-clock'),
                TextColumn::make('return_date')
                    ->label('Dikembalikan')
                    ->date('d M Y')
                    ->placeholder('Belum dikembalikan')
                    ->sortable()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : null),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'menunggu_verif' => 'info',
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        'jatuh_tempo' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'menunggu_verif' => 'Menunggu Verif',
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'jatuh_tempo' => 'Jatuh Tempo',
                        default => $state,
                    })
                    ->icon(fn($state) => match ($state) {
                        'menunggu_verif' => 'heroicon-o-clock',
                        'dipinjam' => 'heroicon-o-book-open',
                        'dikembalikan' => 'heroicon-o-check-circle',
                        'jatuh_tempo' => 'heroicon-o-exclamation-triangle',
                        default => null,
                    }),
                ToggleColumn::make('verif')
                    ->label('Verifikasi')
                    ->afterStateUpdated(function (bool $state, $record) {
                        // Single update to trigger observer correctly
                        $record->update([
                            'verif' => $state,
                            'status' => $state ? 'dipinjam' : 'menunggu_verif',
                        ]);
                    })
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
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
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'menunggu_verif' => 'Menunggu Verifikasi',
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'jatuh_tempo' => 'Jatuh Tempo',
                    ]),
                TernaryFilter::make('verif')
                    ->label('Verifikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Terverifikasi')
                    ->falseLabel('Belum Verifikasi'),
                TernaryFilter::make('returned')
                    ->label('Pengembalian')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah Kembali')
                    ->falseLabel('Belum Kembali')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('return_date'),
                        false: fn ($query) => $query->whereNull('return_date'),
                    ),
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
            ->striped()
            ->paginated([10, 25, 50]);
    }
}