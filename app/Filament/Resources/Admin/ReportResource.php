<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\ReportResource\Pages\ManageReports;
use App\Models\Report;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    // protected static ?string $navigationIcon = Heroicon::ChartBar;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Reports are read-only, so no form fields needed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('total_registrations')->label('Total Registrations'),
                TextColumn::make('total_members')->label('Total Members'),
                TextColumn::make('total_loans')->label('Total Loans'),
                TextColumn::make('total_returns')->label('Total Returns'),
                TextColumn::make('created_at')->dateTime()->label('Reported At'),
                TextColumn::make('updated_at')->dateTime()->label('Updated At')
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageReports::route('/'),
        ];
    }
}