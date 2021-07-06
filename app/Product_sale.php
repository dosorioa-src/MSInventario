<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_sale extends Model
{
    protected $guarded = [];
    protected $table = 'product_sales';

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_variant()
    {
        return $this->belongsTo(Product_variant::class);
    }

}
