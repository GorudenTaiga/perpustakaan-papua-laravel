<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $fillable = ['member_id', 'endpoint', 'p256dh', 'auth'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'membership_number');
    }
}
