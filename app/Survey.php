<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['name', 'description', 'secret', 'start_date', 'end_date'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questionGroups()
    {
        return $this->hasMany(QuestionGroup::class);
    }

    public function path()
    {
        return route('survey.show', $this);
    }

    public function invitationPool()
    {
        return $this->hasOne(InvitationPool::class);
    }
}
