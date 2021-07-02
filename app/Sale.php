<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    public function product_sales()
    {
        return $this->hasMany(Product_sale::class);
    }

    public function tax()
    {
        return $this->belongsTo(Taxe::class);
    }
}
