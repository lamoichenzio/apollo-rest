<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrixAnswerPair extends Model
{
    protected $fillable = ['answer'];

    public function element()
    {
        return $this->belongsTo(MatrixQuestionElement::class);
    }

    public function matrixAnswer()
    {
        return $this->belongsTo(SingleMatrixAnswer::class);
    }
}
