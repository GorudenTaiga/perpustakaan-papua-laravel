<?php

namespace App\Filament\Resources\Admin\Reports\Tables;

use App\Filament\Resources\Admin\Reports\ReportResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-document-chart-bar')
                    ->limit(40),
                TextColumn::make('period_type')
                    ->label('Periode')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'bulanan' => 'info',
                        'triwulan' => 'warning',
                        'semester' => 'success',
                        'tahunan' => 'primary',
                        'custom' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'bulanan' => 'Bulanan',
                        'triwulan' => 'Triwulan',
                        'semester' => 'Semester',
                        'tahunan' => 'Tahunan',
                        'custom' => 'Custom',
                        default => $state ?? '-',
                    }),
                TextColumn::make('period_start')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('period_end')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('total_members')
                    ->label('Anggota')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-user-group'),
                TextColumn::make('total_loans')
                    ->label('Peminjaman')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('warning')
                    ->icon('heroicon-o-book-open'),
                TextColumn::make('total_returns')
                    ->label('Kembali')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('period_type')
                    ->label('Jenis Periode')
                    ->options([
                        'bulanan' => 'Bulanan',
                        'triwulan' => 'Triwulan',
                        'semester' => 'Semester',
                        'tahunan' => 'Tahunan',
                        'custom' => 'Custom',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->url(fn ($record) => ReportResource::getUrl('view', ['record' => $record])),
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