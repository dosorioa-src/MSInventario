<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_adjustment extends Model
{
    public function adjustment(){
        return $this->belongsTo(Adjustment::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function product_variant(){
        return $this->belongsTo(Product_variant::class);
    }
    protected $guarded = [];
}
