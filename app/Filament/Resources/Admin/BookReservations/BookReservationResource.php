<?php

namespace App\Filament\Resources\Admin\BookReservations;

use App\Filament\Resources\Admin\BookReservations\Pages\CreateBookReservation;
use App\Filament\Resources\Admin\BookReservations\Pages\EditBookReservation;
use App\Filament\Resources\Admin\BookReservations\Pages\ListBookReservations;
use App\Filament\Resources\Admin\BookReservations\Schemas\BookReservationForm;
use App\Filament\Resources\Admin\BookReservations\Tables\BookReservationsTable;
use App\Models\BookReservation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookReservationResource extends Resource
{
    protected static ?string $model = BookReservation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Reservasi Buku';

    protected static ?string $pluralModelLabel = 'Reservasi Buku';

    protected static ?string $navigationLabel = 'Reservasi';

    public static function getNavigationBadge(): ?string
    {
        $waiting = static::getModel()::where('status', 'waiting')->count();
        return $waiting ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function form(Schema $schema): Schema
    {
        return BookReservationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookReservationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookReservations::route('/'),
            'create' => CreateBookReservation::route('/create'),
            'edit' => EditBookReservation::route('/{record}/edit'),
        ];
    }
}
