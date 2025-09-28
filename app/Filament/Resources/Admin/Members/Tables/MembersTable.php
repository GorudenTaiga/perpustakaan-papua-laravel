<?php

namespace App\Filament\Resources\Admin\Members\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Storage;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label('No')
                    ->rowIndex()
                    ->numeric(),
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('membership_number')
                    ->label('Nomor Keanggotaan')
                    ->searchable(),
                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->default('-')
                    ->limit(50),
                TextColumn::make('valid_date')
                    ->label('Berlaku Hingga')
                    ->searchable()
                    ->default('-'),
                ImageColumn::make('image')
                    ->label('Foto')
                    ->emptyTooltip('Belum ada Foto')
                    ->getStateUsing(fn ($record) => Storage::disk('public')->url($record->image))
                    ->rounded(),
                BadgeColumn::make('created_at')
                    ->label('Tanggal Bergabung')
                    ->sortable()
                    ->date('d, M Y'),
                IconColumn::make('user.email_verified_at')
                    ->label('Email Verified')
                    ->default(false)
                    ->boolean(),
                ToggleColumn::make('verif')
                    ->label('Terverifikasi')
                    ->default(false)
                    ->onIcon(Heroicon::CheckBadge::class)
                    ->offIcon(Heroicon::XCircle::class)
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),
            ])
            ->filters([
                //
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