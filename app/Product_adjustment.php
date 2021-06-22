<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_adjustment extends Model
{
    public function adjustment(){
        return $this->belongsTo(Adjustment::class);
    }
    protected $guarded = [];
}
