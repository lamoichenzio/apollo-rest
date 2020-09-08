<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiQuestion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'position',
        'mandatory',
        'type',
        'other'
    ];

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function path()
    {
        return route('multiQuestion.show',
            [
                $this->questionGroup->survey,
                $this->questionGroup,
                $this
            ]);
    }
}
