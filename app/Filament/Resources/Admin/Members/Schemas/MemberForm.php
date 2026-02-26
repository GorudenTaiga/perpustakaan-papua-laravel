<?php

namespace App\Filament\Resources\Admin\Members\Schemas;

use App\Models\User;
use App\Services\ImageWebpConverter;
use Auth;
use Carbon\Carbon;
use Date;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
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
                    ->label('Jenis Anggota')
                    ->options([
                        'Pelajar' => 'Pelajar',
                        'Mahasiswa' => 'Mahasiswa',
                        'Guru' => 'Guru',
                        'Dosen' => 'Dosen',
                        'Umum' => 'Umum',
                    ]),
                Select::make('tier')
                    ->label('Tier Keanggotaan')
                    ->options([
                        'reguler' => 'Reguler',
                        'premium' => 'Premium',
                    ])
                    ->default('reguler')
                    ->required(),
                DateTimePicker::make('tier_expired_at')
                    ->label('Masa Berlaku Premium')
                    ->visible(fn ($get) => $get('tier') === 'premium')
                    ->nullable(),
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
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->saveUploadedFileUsing(function ($file) {
                        return ImageWebpConverter::convertAndStore($file, 'images/member/foto', 'public');
                    })
                    ->nullable(),
                
                FileUpload::make('document_path')
                    ->label('Dokumen Pendukung')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->maxSize(2048)
                    ->visibility('public')
                    ->directory('documents/members')
                    ->saveUploadedFileUsing(function ($file) {
                        $mime = $file->getMimeType();
                        if (in_array($mime, ['image/jpeg', 'image/png', 'image/jpg'])) {
                            return ImageWebpConverter::convertAndStore($file, 'documents/members', 'public');
                        }
                        return $file->store('documents/members', 'public');
                    })
                    ->helperText('Upload surat aktif kuliah/sekolah, KTP, atau dokumen identitas lainnya (Max 2MB)')
                    ->nullable(),
            ]);
    }
}