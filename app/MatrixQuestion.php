<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
