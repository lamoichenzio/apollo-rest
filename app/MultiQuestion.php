<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MultiQuestion extends Model
{
    protected $fillable = [
        'title',
        'position',
        'mandatory',
        'type',
        'other'
    ];

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    public function options()
    {
        return $this->morphMany(QuestionOption::class, 'question');
    }

    public function path()
    {
        return route('multiQuestion.show',
            [
                $this->questionGroup->survey,
                $this->questionGroup,
                $this
            ]);
    }

    public function delete()
    {
        DB::transaction(function () {
            $del = parent::delete();
            if ($del) {
                $this->deleteOptions();
            }
        });
    }

    public function deleteOptions()
    {
        QuestionOption::where([
            ['question_id', $this->id],
            ['question_type', MultiQuestion::class]
        ])->delete();
    }
}
