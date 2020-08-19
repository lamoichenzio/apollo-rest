<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class ImageFile extends Model
{
    protected $connection = "mongodb";
    protected $collection = "Files";
    protected $fillable = ['name', 'data'];

    public function path()
    {
        return route('image.show', $this);
    }

}
