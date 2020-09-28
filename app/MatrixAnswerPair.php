<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrixAnswerPair extends Model
{
    protected $fillable = ['answer', 'element_id'];

    public function element()
    {
        return $this->belongsTo(MatrixQuestionElement::class);
    }

    public function matrixAnswer()
    {
        return $this->belongsTo(SingleMatrixAnswer::class);
    }
}
