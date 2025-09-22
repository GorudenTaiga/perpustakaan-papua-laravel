<?php

namespace App\Filament\Resources\Admin\Reports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReportsTable
{
    public static function configure(Table $table): Table
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}