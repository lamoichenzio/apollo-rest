<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleAnswer extends Model
{

    protected $fillable = ['answer', 'question_type', 'question_id', 'survey_answer_id'];

    public function question()
    {
        return $this->morphTo();
    }

    public function surveyAnswer()
    {
        return $this->belongsTo(SurveyAnswer::class);
    }
}
