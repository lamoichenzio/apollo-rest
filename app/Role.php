<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static function getStandardRole()
    {
        return Role::where(['name' => 'STANDARD'])->firstOrFail();
    }

    public static function getAdminRole()
    {
        return Role::where(['name' => 'ADMIN'])->firstOrFail();
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
