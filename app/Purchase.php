<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function product_purchase(){
        return $this->hasMany(Product_purchase::class);
    }
    public function taxe()
    {
        return $this->belongsTo(Taxe::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    protected $guarded = [];
}
