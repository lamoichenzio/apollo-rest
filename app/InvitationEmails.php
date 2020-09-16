<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitationEmails extends Model
{
    protected $fillable = ['email'];

    public function invitationPool()
    {
        return $this->belongsTo(InvitationPool::class);
    }
}
