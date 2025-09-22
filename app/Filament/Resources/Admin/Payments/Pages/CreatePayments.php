<?php

namespace App\Filament\Resources\Admin\Payments\Pages;

use App\Filament\Resources\Admin\Payments\PaymentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayments extends CreateRecord
{
    protected static string $resource = PaymentsResource::class;
}
