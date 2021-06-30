<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    public function product_adjustment(){
        return $this->hasMany(Product_adjustment::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
    protected $guarded = [];
}
