<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = "Surveys";
    protected $fillable = ['name', 'description', 'icon', 'start_date', 'end_date'];

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
}
