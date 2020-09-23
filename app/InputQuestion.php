<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputQuestion extends Model
{
    protected $fillable = ['title', 'description', 'mandatory', 'type', 'position'];

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    public function path()
    {
        return route('inputQuestion.show',
            ['survey' => $this->questionGroup->survey,
                'question_group' => $this->questionGroup,
                'question' => $this
            ]
        );
    }

    public function answers()
    {
        return $this->morphMany(SingleAnswer::class, 'question');
    }
}
