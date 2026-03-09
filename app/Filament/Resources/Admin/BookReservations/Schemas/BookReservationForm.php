<?php

namespace App\Filament\Resources\Admin\BookReservations\Schemas;

use App\Models\Buku;
use DB;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Reservasi')
                    ->icon('heroicon-o-calendar-days')
                    ->description('Informasi reservasi buku oleh anggota')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('member_id')
                                ->label('Anggota')
                                ->options(
                                    DB::table('users as u')
                                        ->leftJoin('member as mem', 'u.id', '=', 'mem.users_id')
                                        ->where('u.role', '=', 'member')
                                        ->pluck('u.name', 'mem.membership_number')
                                )
                                ->searchable()
                                ->preload()
                                ->required()
                                ->suffixIcon('heroicon-o-user'),

                            Select::make('buku_id')
                                ->label('Buku')
                                ->options(Buku::all()->pluck('judul', 'id'))
                                ->searchable()
                                ->preload()
                                ->required()
                                ->suffixIcon('heroicon-o-book-open'),

                            Select::make('status')
                                ->label('Status Reservasi')
                                ->required()
                                ->default('waiting')
                                ->options([
                                    'waiting' => '⏳ Menunggu',
                                    'available' => '✅ Tersedia',
                                    'fulfilled' => '📦 Terpenuhi',
                                    'cancelled' => '❌ Dibatalkan',
                                ])
                                ->native(false),

                            DateTimePicker::make('reserved_at')
                                ->label('Tanggal Reservasi')
                                ->default(now())
                                ->required()
                                ->suffixIcon('heroicon-o-calendar'),
                        ]),
                    ]),

                Section::make('Notifikasi')
                    ->icon('heroicon-o-bell')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        DateTimePicker::make('notified_at')
                            ->label('Tanggal Diberitahu')
                            ->helperText('Diisi otomatis saat anggota dinotifikasi bahwa buku tersedia')
                            ->suffixIcon('heroicon-o-bell-alert'),
                    ]),
            ]);
    }
}
