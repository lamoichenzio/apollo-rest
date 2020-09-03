<?php

namespace App\questions;

use App\QuestionGroup;
use Illuminate\Database\Eloquent\Model;

class InputQuestion extends Model
{
    protected $fillable = ['title', 'description', 'mandatory', 'type'];

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }
}
