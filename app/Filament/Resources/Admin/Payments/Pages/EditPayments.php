<?php

namespace App\Filament\Resources\Admin\Payments\Pages;

use App\Filament\Resources\Admin\Payments\PaymentsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPayments extends EditRecord
{
    protected static string $resource = PaymentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
