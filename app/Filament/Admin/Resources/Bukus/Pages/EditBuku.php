<?php

namespace App\Filament\Admin\Resources\Bukus\Pages;

use App\Filament\Admin\Resources\Bukus\BukuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBuku extends EditRecord
{
    protected static string $resource = BukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
