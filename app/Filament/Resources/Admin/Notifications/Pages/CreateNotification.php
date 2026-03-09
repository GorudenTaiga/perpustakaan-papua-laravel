<?php

namespace App\Filament\Resources\Admin\Notifications\Pages;

use App\Filament\Resources\Admin\Notifications\NotificationResource;
use App\Models\Member;
use App\Models\Notification;
use App\Services\WebPushService;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Resources\Pages\CreateRecord;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $sendToAll = (bool) ($data['send_to_all'] ?? false);
        unset($data['send_to_all']);

        if (empty($data['member_id'])) {
            unset($data['member_id']);
        }

        if ($sendToAll) {
            $members = Member::pluck('membership_number');

            $now = now();
            $notifications = $members->map(fn ($memberId) => [
                'member_id' => $memberId,
                'type'       => $data['type'],
                'title'      => $data['title'],
                'message'    => $data['message'],
                'created_at' => $now,
                'updated_at' => $now,
            ])->toArray();

            if (!empty($notifications)) {
                Notification::insert($notifications);

                // Web Push to all subscribed members
                try {
                    app(WebPushService::class)->sendToAll(
                        $data['title'],
                        $data['message']
                    );
                } catch (\Throwable) {
                    // push failure must not block the operation
                }
            }

            FilamentNotification::make()
                ->title('Notifikasi terkirim!')
                ->body("Notifikasi berhasil dikirim ke {$members->count()} anggota.")
                ->success()
                ->send();

            return Notification::latest()->first();
        }

        // Single member
        $notification = Notification::create($data);

        try {
            app(WebPushService::class)->sendToMember(
                $data['member_id'],
                $data['title'],
                $data['message']
            );
        } catch (\Throwable) {}

        return $notification;
    }
}
