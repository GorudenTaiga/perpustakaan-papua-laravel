<?php

namespace App\Filament\Resources\Admin\BookReservations\Pages;

use App\Filament\Resources\Admin\BookReservations\BookReservationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookReservations extends ListRecords
{
    protected static string $resource = BookReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
