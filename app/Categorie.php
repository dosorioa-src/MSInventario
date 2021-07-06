<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public function Product()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query,$filtro){
        if (!empty($filtro)) {
            return $query->where('name','like',"%$filtro%")
                         ->orWhere('id','like',"%$filtro%");
        }   
    }

    protected $guarded = [];
}
