<?php

namespace App\Filament\Resources\Admin\PaymentsResource\Pages;

use App\Filament\Resources\Admin\PaymentsResource;
use Filament\Resources\Pages\ManageRecords;

class ManagePayments extends ManageRecords
{
    protected static string $resource = PaymentsResource::class;
}