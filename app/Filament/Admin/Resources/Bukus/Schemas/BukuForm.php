<?php

namespace App\Filament\Admin\Resources\Bukus\Schemas;

use App\Models\Category;
use App\Services\ImageWebpConverter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\FormsComponent;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class BukuForm extends FormsComponent
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Buku')
                    ->icon('heroicon-o-book-open')
                    ->description('Detail dasar informasi buku')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul Buku')
                            ->placeholder('Masukkan judul buku')
                            ->live(true)
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                $set('slug', Str::slug($state));
                            })
                            ->required()
                            ->columnSpanFull(),
                        Grid::make(2)->schema([
                            TextInput::make('author')
                                ->label('Penulis')
                                ->placeholder('Nama penulis buku'),
                            TextInput::make('publisher')
                                ->label('Penerbit')
                                ->placeholder('Nama penerbit'),
                            TextInput::make('year')
                                ->label('Tahun Terbit')
                                ->placeholder('cth: 2024')
                                ->required()
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(now()->year + 1),
                            TextInput::make('slug')
                                ->label('Slug URL')
                                ->readOnly()
                                ->required()
                                ->helperText('Otomatis dibuat dari judul'),
                        ]),
                    ]),

                Section::make('Stok & Denda')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('stock')
                                ->label('Jumlah Stok')
                                ->placeholder('0')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->suffixIcon('heroicon-o-archive-box'),
                            TextInput::make('denda_per_hari')
                                ->label('Denda per Hari')
                                ->helperText('Denda keterlambatan per hari')
                                ->placeholder('0')
                                ->required()
                                ->minValue(0)
                                ->maxValue(999999)
                                ->numeric()
                                ->prefix('Rp'),
                        ]),
                        Placeholder::make('info_denda')
                            ->label('')
                            ->content(new HtmlString(
                                '<div class="text-xs text-gray-500 dark:text-gray-400 rounded-lg bg-gray-50 dark:bg-gray-800 p-3">'
                                . '💡 Denda akan otomatis dihitung saat buku terlambat dikembalikan.'
                                . '</div>'
                            )),
                    ]),

                Section::make('Kategori')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori Buku')
                            ->relationship('category', 'nama')
                            ->options(Category::all()->pluck('nama', 'id'))
                            ->live(false)
                            ->multiple()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('nama')
                                    ->label('Nama Kategori')
                                    ->required()
                            ])
                            ->columnSpanFull(),
                            ]),
                            
                Section::make('Cover Buku')
                    ->icon('heroicon-o-photo')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('banner')
                            ->label('Gambar Cover')
                            ->helperText('Format: JPG, PNG, WebP. Akan dikonversi otomatis ke WebP.')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                            ->visibility('public')
                            ->disk('s3')
                            ->directory('buku/images/banner')
                            ->fetchFileInformation(false)
                            ->imagePreviewHeight('200')
                            ->getUploadedFileUsing(static function (string $file): ?array {
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
                            ->saveUploadedFileUsing(function ($file) {
                                return ImageWebpConverter::convertAndStore($file, 'buku/images/banner', 's3');
                            })
                            ->columnSpanFull(),
                    ]),
                    
                Section::make('Deskripsi')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->schema([
                        RichEditor::make('deskripsi')
                            ->label('')
                            ->placeholder('Tulis deskripsi atau sinopsis buku...')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

            ]);
    }
}