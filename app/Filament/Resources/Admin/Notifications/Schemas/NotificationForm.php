<?php

namespace App\Filament\Resources\Admin\Notifications\Schemas;

use App\Models\Buku;
use DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Penerima Notifikasi')
                    ->icon('heroicon-o-user-group')
                    ->description('Pilih target penerima notifikasi')
                    ->schema([
                        Toggle::make('send_to_all')
                            ->label('Kirim ke Semua Anggota')
                            ->default(false)
                            ->live()
                            ->helperText('Aktifkan untuk mengirim notifikasi ke semua anggota'),

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
                            ->required(fn ($get) => !$get('send_to_all'))
                            ->disabled(fn ($get) => $get('send_to_all'))
                            ->suffixIcon('heroicon-o-user')
                            ->helperText(fn ($get) => $get('send_to_all') ? 'Notifikasi akan dikirim ke semua anggota' : null),
                    ]),

                Section::make('Isi Notifikasi')
                    ->icon('heroicon-o-envelope')
                    ->description('Detail pesan notifikasi')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('type')
                                ->label('Tipe Notifikasi')
                                ->required()
                                ->default('custom')
                                ->options([
                                    'custom' => '📢 Custom / Pengumuman',
                                    'buku_baru' => '📚 Buku Baru',
                                    'deadline_peminjaman' => '⏰ Deadline Peminjaman',
                                    'denda' => '💰 Denda / Tagihan',
                                    'update_profile' => '👤 Update Profile',
                                    'peminjaman' => '📖 Info Peminjaman',
                                    'reservasi' => '📅 Reservasi Buku',
                                ])
                                ->native(false),

                            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Judul notifikasi...')
                                ->suffixIcon('heroicon-o-pencil'),
                        ]),

                        Textarea::make('message')
                            ->label('Pesan')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Tulis pesan notifikasi di sini...'),
                    ]),
            ]);
    }
}
