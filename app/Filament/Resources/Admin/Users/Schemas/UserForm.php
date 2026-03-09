<?php

namespace App\Filament\Resources\Admin\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->icon('heroicon-o-user-circle')
                    ->description('Data dasar akun pengguna sistem')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->placeholder('Masukkan nama lengkap')
                                ->required()
                                ->suffixIcon('heroicon-o-user'),
                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->placeholder('contoh@email.com')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->suffixIcon('heroicon-o-envelope'),
                        ]),
                    ]),

                Section::make('Peran & Keamanan')
                    ->icon('heroicon-o-shield-check')
                    ->description('Atur peran akses dan kata sandi')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('role')
                                ->label('Peran')
                                ->required()
                                ->default('member')
                                ->options([
                                    'admin' => '🛡️ Admin',
                                    'member' => '👤 Anggota',
                                    'kepala' => '👑 Kepala Perpustakaan',
                                ])
                                ->native(false)
                                ->helperText('Admin & Kepala dapat mengakses panel admin'),
                            TextInput::make('password')
                                ->label('Kata Sandi')
                                ->password()
                                ->revealable()
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                                ->dehydrated(fn ($state) => filled($state))
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->helperText(fn (string $operation) => $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah password' : null)
                                ->suffixIcon('heroicon-o-lock-closed'),
                        ]),
                    ]),
            ]);
    }
}