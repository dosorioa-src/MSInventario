<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function product_variant(){
        return $this->hasMany(Product_variant::class);
    }
    public function product_warehouse(){
        return $this->hasMany(Product_warehouse::class);
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    

    protected $guarded = [];
}
