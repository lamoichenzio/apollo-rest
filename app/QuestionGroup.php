<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model
{
    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function path()
    {
        return route('questionGroup.show', $this);
    }

}
