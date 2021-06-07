<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users(){
        return $this->hasMany(User::class);
    }

    public function role_has_permissions(){
        return $this->hasMany(Role_has_permission::class);
    }

    
}
