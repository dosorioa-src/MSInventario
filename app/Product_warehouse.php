<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_warehouse extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }
    protected  $guarded=[];
    protected $table = 'product_warehouse';
}
