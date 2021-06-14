<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function Role_has_permission(){
        return $this->hasMany(Role_has_permission::class);
    }
}
