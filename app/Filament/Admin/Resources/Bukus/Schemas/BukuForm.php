<?php

namespace App\Filament\Admin\Resources\Bukus\Schemas;

use App\Models\Category;
use App\Services\ImageWebpConverter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\FormsComponent;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BukuForm extends FormsComponent
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('uuid')
                //     ->default(Str::random(16))
                //     ->disabled(),
                TextInput::make('judul')
                    ->live(true)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('author'),
                TextInput::make('publisher'),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('stock')
                    ->required()
                    ->numeric(),
                TextInput::make('denda_per_hari')
                    ->label('Denda Keterlambatan per Hari (Rp)')
                    ->helperText('Nominal denda yang dikenakan per hari jika buku terlambat dikembalikan')
                    ->required()
                    ->minValue(0)
                    ->maxValue(999999)
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('slug')
                    ->readOnly()
                    ->required(),
                RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->relationship('category', 'nama')
                    ->options(Category::all()->pluck('nama', 'id'))
                    ->live(false)
                    ->multiple()
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Category')
                            ->required()
                    ]),
                FileUpload::make('banner')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->visibility('public')
                    ->disk('public')
                    ->directory('buku/images/banner')
                    ->saveUploadedFileUsing(function ($file) {
                        return ImageWebpConverter::convertAndStore($file, 'buku/images/banner', 'public');
                    }),
                TextInput::make('gdrive_link')
                    ->label('Link Google Drive (Buku Digital)')
                    ->url()
                    ->helperText('Masukkan link Google Drive untuk buku digital (opsional)')
                    ->placeholder('https://drive.google.com/...')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}