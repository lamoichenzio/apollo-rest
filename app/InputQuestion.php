<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class InputQuestion extends Model
{
    use HybridRelations;

    protected $fillable = ['title', 'mandatory', 'type', 'position'];

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    public function path()
    {
        return route('inputQuestion.show',
            ['survey' => $this->questionGroup->survey,
                'question_group' => $this->questionGroup,
                'question' => $this
            ]
        );
    }

    public function answers()
    {
        return $this->morphMany(SingleAnswer::class, 'question');
    }

    public function icon()
    {
        return $this->hasOne(ImageFile::class);
    }
}
