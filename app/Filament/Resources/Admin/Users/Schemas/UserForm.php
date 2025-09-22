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
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('role')
                    ->required()
                    ->default('member')
                    ->options([
                        'admin' => 'admin',
                        'member' => 'member',
                        'kepala' => 'kepala'
                    ]),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}