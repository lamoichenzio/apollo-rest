<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiMatrixAnswer extends Model
{
    protected $fillable = ['matrix_question_id'];

    public function surveyAnswer()
    {
        return $this->belongsTo(SurveyAnswer::class);
    }

    public function matrixQuestion()
    {
        return $this->belongsTo(MatrixQuestion::class);
    }

    public function answers()
    {
        return $this->hasMany(MultiMatrixAnswerPair::class);
    }
}
