<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_indetification extends Model
{
    public function users(){
        return $this->hasMany(user::class);
    }
}
