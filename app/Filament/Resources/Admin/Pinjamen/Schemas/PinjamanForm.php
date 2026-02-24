<?php

namespace App\Filament\Resources\Admin\Pinjamen\Schemas;

use App\Models\Buku;
use DB;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PinjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('member_id')
                    ->label('Member')
                    ->options(
                        DB::table('users as u')
                            ->leftJoin('member as mem', 'u.id', '=', 'mem.users_id')
                            ->where('u.role', '=', 'member')
                            ->pluck('u.name', 'mem.membership_number')
                    )
                    ->searchable()
                    ->required(),

                Select::make('buku_id')
                    ->label('Buku')
                    ->options(Buku::all()->pluck('judul', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('quantity')
                    ->label('Jumlah Buku')
                    ->default(1)
                    ->required()
                    ->numeric(),

                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->default('dipinjam')
                    ->options([
                        'menunggu_verif' => 'Menunggu Verifikasi',
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'jatuh_tempo' => 'Jatuh Tempo'
                    ]),

                Section::make('Tanggal')
                    ->schema([
                        DatePicker::make('loan_date')
                            ->label('Tanggal Pinjam')
                            ->required(),

                        DatePicker::make('due_date')
                            ->label('Batas Tanggal Kembali')
                            ->required(),

                        DatePicker::make('return_date')
                            ->label('Tanggal Dikembalikan')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('status', 'dikembalikan');
                                }
                            }),
                    ]),
            ]);
    }
}