<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable =[

        "title", "image", "is_active", "is_deleted"
    ];

    public function scopeSearch($query,$filtro){
        if (!empty($filtro)) {
            return $query->where('title','like',"%$filtro%");
        }   
    }
}
