<?php

namespace App\Filament\Resources\Admin\Pinjamen\Pages;

use App\Filament\Resources\Admin\Pinjamen\PinjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPinjamen extends ListRecords
{
    protected static string $resource = PinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
