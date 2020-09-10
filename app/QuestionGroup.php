<?php

namespace App;


use App\Helpers\DataHelper;
use App\Http\Resources\questions\InputQuestionResource;
use App\Http\Resources\questions\MultiQuestionResource;
use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model
{
    protected $fillable = ['title', 'description'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function path()
    {
        return route('questionGroup.show', [$this->survey, $this]);
    }

    public function questions()
    {
        $inputQuestions = InputQuestionResource::collection($this->inputQuestions)->collection;
        $multiQuestions = MultiQuestionResource::collection($this->multiQuestions)->collection;
        $questions = collect([$inputQuestions, $multiQuestions]);
        return DataHelper::listDataResponse($questions->collapse()->sortBy('position')->all());
    }

    public function inputQuestions()
    {
        return $this->hasMany(InputQuestion::class);
    }

    public function multiQuestions()
    {
        return $this->hasMany(MultiQuestion::class);
    }
}
