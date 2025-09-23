<?php

namespace App\Filament\Resources\Admin\Members\Schemas;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Date;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user.name')
                    ->label('User Name')
                    ->formatStateUsing(fn ($record) => $record?->user?->name)
                    ->disabled()
                    ->dehydrated(false),
                Select::make('jenis')
                    ->options([
                        'Siswa' => 'Siswa',
                        'Mahasiswa' => 'Mahasiswa',
                        'Guru' => 'Guru',
                        'Dosen' => 'Dosen',
                        'Umum' => 'Umum',
                    ]),
                DatePicker::make('valid_date')
                    ->default(fn () => Carbon::now()->addYears(2)->toDateString()) // buat create
                    ->formatStateUsing(fn ($state) => $state ?? Carbon::now()->addYears(2)->toDateString()) // fallback kalau null
                    ->disabled(Auth::user()->role == 'member')
                    ->dehydrated(true),

                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->visibility('public')
                    ->directory('images/member/foto')
                    ->nullable(),
            ]);
    }
}