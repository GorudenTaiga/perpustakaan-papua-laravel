<?php

namespace App\Filament\Resources\Admin\Members\Schemas;

use App\Services\ImageWebpConverter;
use Auth;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Anggota')
                    ->icon('heroicon-o-user')
                    ->description('Data identitas anggota perpustakaan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('user.name')
                                ->label('Nama Lengkap')
                                ->formatStateUsing(fn ($record) => $record?->user?->name)
                                ->disabled()
                                ->dehydrated(false)
                                ->suffixIcon('heroicon-o-user'),
                            TextInput::make('membership_number')
                                ->label('Nomor Keanggotaan')
                                ->disabled()
                                ->dehydrated(false)
                                ->suffixIcon('heroicon-o-identification')
                                ->formatStateUsing(fn ($record) => $record?->membership_number),
                            Select::make('jenis')
                                ->label('Jenis Anggota')
                                ->options([
                                    'Pelajar' => '🎒 Pelajar',
                                    'Mahasiswa' => '🎓 Mahasiswa',
                                    'Guru' => '👨‍🏫 Guru',
                                    'Dosen' => '👨‍🔬 Dosen',
                                    'Umum' => '👤 Umum',
                                ])
                                ->native(false),
                            DatePicker::make('valid_date')
                                ->label('Berlaku Hingga')
                                ->default(fn () => Carbon::now()->addYears(2)->toDateString())
                                ->formatStateUsing(fn ($state) => $state ?? Carbon::now()->addYears(2)->toDateString())
                                ->disabled(Auth::user()->role == 'member')
                                ->dehydrated(true)
                                ->suffixIcon('heroicon-o-calendar'),
                        ]),
                    ]),

                Section::make('Tier Keanggotaan')
                    ->icon('heroicon-o-star')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('tier')
                                ->label('Tier')
                                ->options([
                                    'reguler' => '🟢 Reguler',
                                    'premium' => '⭐ Premium',
                                ])
                                ->default('reguler')
                                ->required()
                                ->native(false)
                                ->live(),
                            DateTimePicker::make('tier_expired_at')
                                ->label('Berakhir Pada')
                                ->visible(fn ($get) => $get('tier') === 'premium')
                                ->nullable()
                                ->helperText('Tanggal berakhirnya tier premium'),
                        ]),
                        Placeholder::make('tier_info')
                            ->label('')
                            ->content(new HtmlString(
                                '<div class="text-xs text-gray-500 dark:text-gray-400 rounded-lg bg-gray-50 dark:bg-gray-800 p-3">'
                                . '💡 Member premium mendapat akses prioritas dan batas peminjaman lebih tinggi.'
                                . '</div>'
                            )),
                    ]),

                Section::make('Foto & Dokumen')
                    ->icon('heroicon-o-document')
                    ->description('Upload foto anggota dan dokumen pendukung untuk verifikasi')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('image')
                                ->label('Foto Anggota')
                                ->disk('s3')
                                ->image()
                                ->visibility('public')
                                ->directory('images/member/foto')
                                ->fetchFileInformation(false)
                                ->imagePreviewHeight('200')
                                ->getUploadedFileUsing(function (string $file): ?array {
                                    return [
                                        'name' => basename($file),
                                        'size' => 0,
                                        'type' => 'image/webp',
                                        'url' => Storage::disk('s3')->url($file),
                                    ];
                                })
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                                ->saveUploadedFileUsing(function ($file) {
                                    return ImageWebpConverter::convertAndStore($file, 'images/member/foto', 's3');
                                })
                                ->nullable(),

                            FileUpload::make('document_path')
                                ->label('Dokumen Pendukung')
                                ->disk('s3')
                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                                ->maxSize(2048)
                                ->visibility('public')
                                ->directory('documents/members')
                                ->fetchFileInformation(false)
                                ->getUploadedFileUsing(function (string $file): ?array {
                                    return [
                                        'name' => basename($file),
                                        'size' => 0,
                                        'type' => null,
                                        'url' => Storage::disk('s3')->url($file),
                                    ];
                                })
                                ->saveUploadedFileUsing(function ($file) {
                                    $mime = $file->getMimeType();
                                    if (in_array($mime, ['image/jpeg', 'image/png', 'image/jpg'])) {
                                        return ImageWebpConverter::convertAndStore($file, 'documents/members', 's3');
                                    }
                                    return $file->store('documents/members', 's3');
                                })
                                ->helperText('Surat aktif kuliah/sekolah, KTP, atau dokumen identitas lainnya (Max 2MB)')
                                ->nullable(),
                        ]),
                    ]),
            ]);
    }
}