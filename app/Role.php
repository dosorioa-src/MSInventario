<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function User(){
        return $this->hasMany(User::class);
    }

    public function Role_has_permission(){
        return $this->hasMany(Role_has_permission::class);
    }

    
}
