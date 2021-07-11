<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = [];

    public function scopeSearch($query,$filtro) {
        if (!empty($filtro)) {
            return $query->where('company_name', 'like',"%$filtro%");
        }
    }
}
