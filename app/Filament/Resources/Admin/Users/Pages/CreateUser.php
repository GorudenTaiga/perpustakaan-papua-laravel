<?php

namespace App\Filament\Resources\Admin\Users\Pages;

use App\Filament\Resources\Admin\Users\UserResource;
use App\Models\Member;
use BcMath\Number;
use Filament\Resources\Pages\CreateRecord;
use Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate() {
        $user = $this->record;
        if ($user->role == 'member') {
            Member::create([
                'users_id' => $user->id,
                'membership_number' => strtotime($user->created_at),
            ]);
        }
    }
}