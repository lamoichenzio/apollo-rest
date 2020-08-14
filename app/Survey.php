<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Survey extends Model
{
    protected $collection = "Surveys";
    protected $fillable = ['name', 'description', 'icon', 'start_date', 'end_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function path(){
        return route('survey.show', $this);
    }
}
