<?php

namespace App\Filament\Resources\Admin\Pinjamen\Schemas;

use App\Models\Buku;
use DB;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PinjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Peminjaman')
                    ->icon('heroicon-o-book-open')
                    ->description('Informasi peminjam dan buku')
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

                            TextInput::make('quantity')
                                ->label('Jumlah Buku')
                                ->default(1)
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->suffixIcon('heroicon-o-hashtag'),

                            Select::make('status')
                                ->label('Status Peminjaman')
                                ->required()
                                ->default('dipinjam')
                                ->options([
                                    'menunggu_verif' => 'Menunggu Verifikasi',
                                    'dipinjam' => 'Dipinjam',
                                    'dikembalikan' => 'Dikembalikan',
                                    'jatuh_tempo' => 'Jatuh Tempo',
                                ])
                                ->native(false),
                        ]),
                    ]),

                Section::make('Jadwal Peminjaman')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        Grid::make(3)->schema([
                            DatePicker::make('loan_date')
                                ->label('Tanggal Pinjam')
                                ->required()
                                ->default(now())
                                ->suffixIcon('heroicon-o-calendar'),

                            DatePicker::make('due_date')
                                ->label('Batas Kembali')
                                ->required()
                                ->default(now()->addDays(14))
                                ->suffixIcon('heroicon-o-clock'),

                            DatePicker::make('return_date')
                                ->label('Tanggal Kembali')
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    if ($state) {
                                        $set('status', 'dikembalikan');
                                    }
                                })
                                ->suffixIcon('heroicon-o-arrow-uturn-left')
                                ->helperText('Isi saat buku dikembalikan'),
                        ]),
                        Placeholder::make('info_jadwal')
                            ->label('')
                            ->content(new HtmlString(
                                '<div class="text-xs text-gray-500 dark:text-gray-400 rounded-lg bg-gray-50 dark:bg-gray-800 p-3">'
                                . '💡 Tanggal kembali akan otomatis mengubah status menjadi "Dikembalikan".'
                                . '</div>'
                            )),
                    ]),
            ]);
    }
}