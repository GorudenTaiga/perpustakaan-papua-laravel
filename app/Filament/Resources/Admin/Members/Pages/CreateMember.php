<?php

namespace App\Filament\Resources\Admin\Members\Pages;

use App\Filament\Resources\Admin\Members\MemberResource;
use App\Models\User;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;
    
    protected function afterCreate() {
        $member = $this->record;
        $user = User::create([
            'name' => $member->name,
            'password' => $member->password,
            'email' => $member->email
        ]);
        if ($user) {
            $member->users_id = $user->id;
        }
    }
}