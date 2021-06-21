<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_variant extends Model
{
    public function product(){
        return $this->belongsToOne(Product::class);
    }
    protected  $guarded=[];
}
