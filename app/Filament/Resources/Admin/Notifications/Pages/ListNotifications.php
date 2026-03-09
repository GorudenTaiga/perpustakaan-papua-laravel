<?php

namespace App\Filament\Resources\Admin\Notifications\Pages;

use App\Filament\Resources\Admin\Notifications\NotificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNotifications extends ListRecords
{
    protected static string $resource = NotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Kirim Notifikasi'),
        ];
    }
}
