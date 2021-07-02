<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_variant extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsToOne(Product::class);
    }

    public function product_sales()
    {
        return $this->hasOne(product_sales::class);
    }

}
