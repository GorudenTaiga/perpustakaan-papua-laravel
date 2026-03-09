<?php

namespace App\Filament\Resources\Admin\BookReservations\Pages;

use App\Filament\Resources\Admin\BookReservations\BookReservationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookReservation extends CreateRecord
{
    protected static string $resource = BookReservationResource::class;
}
