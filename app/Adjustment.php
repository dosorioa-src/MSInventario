<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    public function product_adjustment(){
        return $this->hasMany(Product_adjustment::class);
    }
    protected $guarded = [];
}
