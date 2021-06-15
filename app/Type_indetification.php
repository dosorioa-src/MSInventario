<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_indetification extends Model
{
    public function User(){
        return $this->hasMany(User::class);
    }
}
