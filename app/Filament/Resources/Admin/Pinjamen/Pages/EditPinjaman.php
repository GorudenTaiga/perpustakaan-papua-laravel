<?php

namespace App\Filament\Resources\Admin\Pinjamen\Pages;

use App\Filament\Resources\Admin\Pinjamen\PinjamanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPinjaman extends EditRecord
{
    protected static string $resource = PinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
