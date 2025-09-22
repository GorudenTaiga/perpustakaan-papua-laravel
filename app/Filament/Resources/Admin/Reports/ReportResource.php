<?php

namespace App\Filament\Resources\Admin\Reports;

use App\Filament\Resources\Admin\Reports\Pages\CreateReport;
use App\Filament\Resources\Admin\Reports\Pages\EditReport;
use App\Filament\Resources\Admin\Reports\Pages\ListReports;
use App\Filament\Resources\Admin\Reports\Schemas\ReportForm;
use App\Filament\Resources\Admin\Reports\Tables\ReportsTable;
use App\Models\Report;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $recordTitleAttribute = 'Report';

    public static function form(Schema $schema): Schema
    {
        return ReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportsTable::configure($table);
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
            'index' => ListReports::route('/'),
            'create' => CreateReport::route('/create'),
            'edit' => EditReport::route('/{record}/edit'),
        ];
    }
}