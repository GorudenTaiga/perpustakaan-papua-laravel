<?php

namespace App\Filament\Resources\Admin\Members\Schemas;

use App\Models\User;
use Carbon\Carbon;
use Date;
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
                TextInput::make('name')
                    ->default('user.name')
                    ->disabled(),
                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->visibility('public')
                    ->directory('images/member/foto')
                    ->nullable(),
                TextInput::make('alamat')
                    ->nullable(),
                Select::make('jenis')
                    ->options([
                        'Siswa' => 'Siswa',
                        'Mahasiswa' => 'Mahasiswa',
                        'Guru' => 'Guru',
                        'Dosen' => 'Dosen',
                        'Umum' => 'Umum',
                    ]),
                TextInput::make('valid_date')
                    ->default(fn () => Carbon::now()->addYears(2)->toDateString())
                    ->readOnly()
            ]);
    }
}