<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    protected $fillable = ['email'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function singleAnswers()
    {
        return $this->hasMany(SingleAnswer::class);
    }

    public function multiAnswers()
    {
        return $this->hasMany(MultiAnswer::class);
    }

    public function singleChoiceMatrixAnswers()
    {
        return $this->hasMany(SingleMatrixAnswer::class);
    }

    public function multiChoiceMatrixAnswers()
    {
        return $this->hasMany(MultiMatrixAnswer::class);
    }
}