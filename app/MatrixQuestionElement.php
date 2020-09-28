<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrixQuestionElement extends Model
{
    protected $fillable = ['title'];

    public function matrixQuestion()
    {
        return $this->belongsTo(MatrixQuestion::class);
    }
}
