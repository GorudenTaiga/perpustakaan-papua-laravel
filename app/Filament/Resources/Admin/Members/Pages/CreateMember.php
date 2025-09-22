<?php

namespace App\Filament\Resources\Admin\Members\Pages;

use App\Filament\Resources\Admin\Members\MemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;
}
