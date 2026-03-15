<?php

namespace App\Filament\Admin\Resources\Bukus\Pages;

use App\Filament\Admin\Resources\Bukus\BukuResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateBuku extends CreateRecord
{
    protected static string $resource = BukuResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uuid'] = Str::uuid()->toString();
        return $data;
    }

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
