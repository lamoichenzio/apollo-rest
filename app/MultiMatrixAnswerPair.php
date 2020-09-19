<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiMatrixAnswerPair extends Model
{
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
