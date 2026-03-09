<?php

namespace App\Filament\Resources\Admin\Pinjamen;

use App\Filament\Resources\Admin\Pinjamen\Pages\CreatePinjaman;
use App\Filament\Resources\Admin\Pinjamen\Pages\EditPinjaman;
use App\Filament\Resources\Admin\Pinjamen\Pages\ListPinjamen;
use App\Filament\Resources\Admin\Pinjamen\Schemas\PinjamanForm;
use App\Filament\Resources\Admin\Pinjamen\Tables\PinjamenTable;
use App\Models\Pinjaman;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PinjamanResource extends Resource
{
    protected static ?string $model = Pinjaman::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Peminjaman';

    protected static ?string $pluralModelLabel = 'Peminjaman';

    public static function getNavigationBadge(): ?string
    {
        $active = static::getModel()::whereIn('status', ['dipinjam', 'menunggu_verif', 'jatuh_tempo'])->count();
        return $active ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $overdue = static::getModel()::where('status', 'jatuh_tempo')->count();
        return $overdue > 0 ? 'danger' : 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return PinjamanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PinjamenTable::configure($table);
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
            'index' => ListPinjamen::route('/'),
            'create' => CreatePinjaman::route('/create'),
            'edit' => EditPinjaman::route('/{record}/edit'),
        ];
    }
}