<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiAnswerElement extends Model
{
    protected $fillable = ['answer'];

    public function answerGroup()
    {
        return $this->morphTo();
    }
}
