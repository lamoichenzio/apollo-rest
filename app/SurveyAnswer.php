<?php

namespace App;

use App\Http\Resources\answers\MultiAnswerResource;
use App\Http\Resources\answers\MultiMatrixAnswerResource;
use App\Http\Resources\answers\SingleAnswerResource;
use App\Http\Resources\answers\SingleMatrixAnswerResource;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    protected $fillable = ['email'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers()
    {
        $singleAnswers = SingleAnswerResource::collection($this->singleAnswers)->collection;
        $multiAnswers = MultiAnswerResource::collection($this->multiAnswers)->collection;
        $singleMatrixAnswers = SingleMatrixAnswerResource::collection($this->singleChoiceMatrixAnswers)->collection;
        $multiMatrixAnswers = MultiMatrixAnswerResource::collection($this->multiChoiceMatrixAnswers)->collection;
        $answers = collect([$singleAnswers, $multiAnswers, $singleMatrixAnswers, $multiMatrixAnswers])->collapse();
        return $answers->sortBy(function ($answer) {
            if (get_class($answer) == SingleAnswerResource::class) {
                return $answer->question->position;
            }
            if (get_class($answer) == MultiAnswerResource::class) {
                return $answer->multiQuestion->position;
            }
            return $answer->matrixQuestion->position;
        })->all();
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