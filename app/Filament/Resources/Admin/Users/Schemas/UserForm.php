<?php

namespace App\Filament\Resources\Admin\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required(),
                Select::make('role')
                    ->label('Peran')
                    ->required()
                    ->default('member')
                    ->options([
                        'admin' => 'Admin',
                        'member' => 'Anggota',
                        'kepala' => 'Kepala Perpustakaan',
                    ]),
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->required(),
            ]);
    }
}