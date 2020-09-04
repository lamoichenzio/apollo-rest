<?php

namespace App;


use App\Helpers\DataHelper;
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
        $questions = collect([$this->inputQuestions(),]);
        return DataHelper::listDataResponse($questions->sortBy('id'));
    }

    public function inputQuestions()
    {
        return $this->hasMany(InputQuestion::class);
    }
}
