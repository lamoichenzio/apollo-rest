<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MatrixQuestion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'position',
        'mandatory',
        'type'
    ];

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    public function elements()
    {
        return $this->hasMany(MatrixQuestionElement::class);
    }

    public function options()
    {
        return $this->morphMany(QuestionOption::class, 'question');
    }

    public function path()
    {
        return route('matrixQuestion.show', [$this->questionGroup->survey, $this->questionGroup, $this]);
    }

    public function delete()
    {
        DB::transaction(function () {
            parent::delete();
            QuestionOption::where([
                ['question_id', $this->id],
                ['question_type', MatrixQuestion::class]
            ])->delete();
        });
    }
}
