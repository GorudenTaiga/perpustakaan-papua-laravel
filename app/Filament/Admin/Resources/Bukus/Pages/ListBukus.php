<?php

namespace App\Filament\Admin\Resources\Bukus\Pages;

use App\Filament\Admin\Resources\Bukus\BukuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBukus extends ListRecords
{
    protected static string $resource = BukuResource::class;

    

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}