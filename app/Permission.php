<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function role_has_permissions(){
        return $this->hasMany(Role_has_permission::class);
    }
}
