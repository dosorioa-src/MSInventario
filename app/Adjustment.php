<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{   
    protected $guarded = [];

    public function product_adjustment(){
        return $this->hasMany(Product_adjustment::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopeTipoAjuste ($query,$filtroA){ 
        if (!empty($filtroA) && $filtroA!="Todos") {
            $query->WhereHas('product_adjustment', function($query) use ($filtroA){
                $query->where('action', '=',"$filtroA");
            });
        }
    }
    public function scopePorAlmacen ($query,$filtroB){
        if (!empty($filtroB) && $filtroB!="Todos") {
            return $query->where('warehouse_id','=',"$filtroB");
        } 
    }

    
}
