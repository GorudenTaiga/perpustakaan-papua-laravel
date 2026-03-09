<?php

namespace App\Filament\Resources\Admin\Categories\Schemas;

use App\Services\ImageWebpConverter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->icon('heroicon-o-tag')
                    ->description('Kelola kategori untuk pengelompokan buku')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nama')
                                ->label('Nama Kategori')
                                ->placeholder('cth: Fiksi, Sains, Sejarah')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->columnSpan(1),
                            FileUpload::make('image')
                                ->label('Ikon Kategori')
                                ->helperText('Gambar ikon untuk kategori (opsional)')
                                ->disk('s3')
                                ->image()
                                ->visibility('public')
                                ->directory('images/categories')
                                ->fetchFileInformation(false)
                                ->imagePreviewHeight('120')
                                ->getUploadedFileUsing(function (string $file): ?array {
                                    if (blank($file)) {
                                        return null;
                                    }
                                    return [
                                        'name' => basename($file),
                                        'size' => 0,
                                        'type' => 'image/webp',
                                        'url' => Storage::disk('s3')->url($file),
                                    ];
                                })
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                                ->saveUploadedFileUsing(function ($file) {
                                    return ImageWebpConverter::convertAndStore($file, 'images/categories', 's3');
                                })
                                ->nullable()
                                ->columnSpan(1),
                        ]),
                    ]),
            ]);
    }
}
