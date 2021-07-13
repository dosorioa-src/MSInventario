<?php

namespace App;

use Carbon\Carbon;
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

    public function scopeFromTo($query,$from,$to){
        if ($from && $to) {
            $from = new Carbon($from, 'America/Lima');
            $from->tz = date_default_timezone_get();
            $from->addDay();

            $to = new Carbon($to, 'America/Lima');
            $to->tz = date_default_timezone_get();
            $to->addDay();

            return $query->whereBetween('created_at', [$from, $to]);
        }
        
    }

    protected $guarded = [];
}
