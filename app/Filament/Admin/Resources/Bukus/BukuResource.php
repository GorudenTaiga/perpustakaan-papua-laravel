<?php

namespace App\Filament\Admin\Resources\Bukus;

use App\Filament\Admin\Resources\Bukus\Pages\CreateBuku;
use App\Filament\Admin\Resources\Bukus\Pages\EditBuku;
use App\Filament\Admin\Resources\Bukus\Pages\ListBukus;
use App\Filament\Admin\Resources\Bukus\Schemas\BukuForm;
use App\Filament\Admin\Resources\Bukus\Tables\BukusTable;
use App\Models\Buku;
use BackedEnum;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Str;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Buku';

    protected static ?string $modelLabel = 'Buku';
    protected static ?string $pluralModelLabel = 'Buku';

    public static function form(Schema $schema): Schema
    {
        return BukuForm::configure($schema);
    }

    // public static function form(Form)

    public static function table(Table $table): Table
    {
        return BukusTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBukus::route('/'),
            'create' => CreateBuku::route('/create'),
            'edit' => EditBuku::route('/{record}/edit'),
        ];
    }
}