<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_has_permission extends Model
{
    public function permissions(){
        return $this->belongsTo(Permission::class);
    }

    public function roles(){
        return $this->belongsTo(Role::class);
    }
}
