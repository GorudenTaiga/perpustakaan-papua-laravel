<?php

namespace App\Filament\Resources\Admin\BookReviews;

use App\Filament\Resources\Admin\BookReviews\Pages\CreateBookReview;
use App\Filament\Resources\Admin\BookReviews\Pages\EditBookReview;
use App\Filament\Resources\Admin\BookReviews\Pages\ListBookReviews;
use App\Filament\Resources\Admin\BookReviews\Schemas\BookReviewForm;
use App\Filament\Resources\Admin\BookReviews\Tables\BookReviewsTable;
use App\Models\BookReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookReviewResource extends Resource
{
    protected static ?string $model = BookReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Ulasan Buku';

    protected static ?string $pluralModelLabel = 'Ulasan Buku';

    protected static ?string $navigationLabel = 'Ulasan';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function form(Schema $schema): Schema
    {
        return BookReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookReviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookReviews::route('/'),
            'create' => CreateBookReview::route('/create'),
            'edit' => EditBookReview::route('/{record}/edit'),
        ];
    }
}
