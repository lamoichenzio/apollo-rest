<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleAnswer extends Model
{

    protected $fillable = ['answer'];

    public function question()
    {
        $this->morphTo();
    }
}
