<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitationPool extends Model
{
    protected $fillable = ['password'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function emails()
    {
        return $this->hasMany(InvitationEmail::class);
    }

    public function path()
    {
        return route('invitationPool.show', [$this->survey, $this]);
    }
}
