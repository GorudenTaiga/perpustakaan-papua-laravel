<?php

namespace App\Filament\Resources\Admin\Members\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Storage;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->getStateUsing(fn ($record) => $record->image ? Storage::disk('s3')->url($record->image) : null)
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->user?->name ?? 'M') . '&background=f59e0b&color=fff')
                    ->size(40),
                TextColumn::make('user.name')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->membership_number),
                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (?string $state): string => match($state) {
                        'Pelajar' => 'info',
                        'Mahasiswa' => 'primary',
                        'Guru' => 'success',
                        'Dosen' => 'warning',
                        'Umum' => 'gray',
                        default => 'gray',
                    })
                    ->placeholder('—'),
                TextColumn::make('tier')
                    ->label('Tier')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match($state) {
                        'premium' => '⭐ Premium',
                        default => 'Reguler',
                    })
                    ->color(fn (?string $state): string => match($state) {
                        'premium' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('valid_date')
                    ->label('Berlaku Hingga')
                    ->date('d M Y')
                    ->color(fn ($record) => $record->valid_date && $record->valid_date < now()->format('Y-m-d') ? 'danger' : null)
                    ->icon(fn ($record) => $record->valid_date && $record->valid_date < now()->format('Y-m-d') ? 'heroicon-o-exclamation-triangle' : null)
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
                ToggleColumn::make('verif')
                    ->label('Verifikasi')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),
                TextColumn::make('document_path')
                    ->label('Dokumen')
                    ->formatStateUsing(fn ($state) => $state ? '✓ Sudah Upload' : 'Belum Upload')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->icon(fn ($state) => $state ? 'heroicon-o-document-check' : 'heroicon-o-document-minus')
                    ->alignCenter()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('jenis')
                    ->label('Jenis Anggota')
                    ->options([
                        'Pelajar' => 'Pelajar',
                        'Mahasiswa' => 'Mahasiswa',
                        'Guru' => 'Guru',
                        'Dosen' => 'Dosen',
                        'Umum' => 'Umum',
                    ]),
                SelectFilter::make('tier')
                    ->label('Tier')
                    ->options([
                        'reguler' => 'Reguler',
                        'premium' => 'Premium',
                    ]),
                TernaryFilter::make('verif')
                    ->label('Status Verifikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Terverifikasi')
                    ->falseLabel('Belum Verifikasi'),
            ])
            ->recordActions([
                Action::make('lihat_dokumen')
                    ->label('Lihat Dokumen')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->modalHeading(fn ($record) => 'Dokumen — ' . ($record->user?->name ?? 'Anggota'))
                    ->modalContent(fn ($record) => view('filament.admin.members.document-preview', [
                        'url' => Storage::disk('s3')->url($record->document_path),
                        'name' => basename($record->document_path),
                    ]))
                    ->modalSubmitAction(false)
                    ->modalWidth('4xl')
                    ->visible(fn ($record) => filled($record->document_path))
                    ->color('info')
                    ->iconButton(),
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