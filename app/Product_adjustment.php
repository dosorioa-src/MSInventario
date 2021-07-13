<?php

namespace App;

use Carbon\Carbon;
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

    public function scopeFromTo($query,$from,$to){
        if ($from && $to) {
            $from = new Carbon($from, 'America/Lima');
            $from->tz = date_default_timezone_get();

            $to = new Carbon($to, 'America/Lima');
            $to->tz = date_default_timezone_get();

            return $query->whereDate('created_at', '>=' , $from)->whereDate('created_at', '<=' , $to);
        }
        
    }
    protected $guarded = [];
}
