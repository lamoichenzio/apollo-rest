<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiAnswer extends Model
{
    protected $fillable = ['multi_question_id'];

    public function surveyAnswer()
    {
        return $this->belongsTo(SurveyAnswer::class);
    }

    public function question()
    {
        return $this->belongsTo(MultiQuestion::class);
    }

    public function answers()
    {
        return $this->morphMany(MultiAnswerElement::class, 'answer_group');
    }
}
