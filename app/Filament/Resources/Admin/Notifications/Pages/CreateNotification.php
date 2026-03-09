<?php

namespace App\Filament\Resources\Admin\Notifications\Pages;

use App\Filament\Resources\Admin\Notifications\NotificationResource;
use App\Models\Member;
use App\Models\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Resources\Pages\CreateRecord;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove the toggle field
        unset($data['send_to_all']);
        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $sendToAll = $this->form->getState()['send_to_all'] ?? false;

        if ($sendToAll) {
            $members = Member::pluck('membership_number');

            $notifications = $members->map(fn ($memberId) => [
                'member_id' => $memberId,
                'type' => $data['type'],
                'title' => $data['title'],
                'message' => $data['message'],
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

            if (!empty($notifications)) {
                Notification::insert($notifications);
            }

            FilamentNotification::make()
                ->title('Notifikasi terkirim!')
                ->body("Notifikasi berhasil dikirim ke {$members->count()} anggota.")
                ->success()
                ->send();

            // Return the last created notification for redirect
            return Notification::latest()->first();
        }

        return Notification::create($data);
    }
}
