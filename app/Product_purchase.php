<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_purchase extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_variant()
    {
        return $this->belongsTo(Product_variant::class);
    }

    protected $guarded = [];
}
