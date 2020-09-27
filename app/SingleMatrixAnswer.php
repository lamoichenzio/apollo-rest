<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleMatrixAnswer extends Model
{
    protected $fillable = ['matrix_question_id'];

    public function surveyAnswers()
    {
        return $this->belongsTo(SurveyAnswer::class);
    }

    public function question()
    {
        return $this->belongsTo(MatrixQuestion::class);
    }

    public function pairs()
    {
        return $this->hasMany(MatrixAnswerPair::class);
    }
}
