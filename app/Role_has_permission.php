<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_has_permission extends Model
{
    public function Permission(){
        return $this->belongsTo(Permission::class);
    }

    public function Role(){
        return $this->belongsTo(Role::class);
    }
}
