<?php

namespace App\Filament\Resources\Admin\Payments;

use App\Filament\Resources\Admin\Payments\Pages\CreatePayments;
use App\Filament\Resources\Admin\Payments\Pages\EditPayments;
use App\Filament\Resources\Admin\Payments\Pages\ListPayments;
use App\Filament\Resources\Admin\Payments\Schemas\PaymentsForm;
use App\Filament\Resources\Admin\Payments\Tables\PaymentsTable;
use App\Models\Payments;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PaymentsResource extends Resource
{
    protected static ?string $model = Payments::class;

    protected static ?string $navigationLabel = 'Denda & Sanksi';
    
    protected static ?string $modelLabel = 'Denda';
    
    protected static ?string $pluralModelLabel = 'Denda & Sanksi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Denda';

    public static function form(Schema $schema): Schema
    {
        return PaymentsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
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
            'index' => ListPayments::route('/'),
            'create' => CreatePayments::route('/create'),
            'edit' => EditPayments::route('/{record}/edit'),
        ];
    }
}
