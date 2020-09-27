<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiMatrixAnswerPair extends Model
{
    protected $fillable = ['element_id'];

    public function multiMatrixAnswer()
    {
        return $this->belongsTo(MultiMatrixAnswer::class);
    }

    public function element()
    {
        return $this->belongsTo(MatrixQuestionElement::class);
    }

    public function answers()
    {
        return $this->morphMany(MultiAnswerElement::class, 'answer_group');
    }
}
