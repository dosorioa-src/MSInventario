<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{   
    protected $guarded = [];

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

    public function scopeNumReferencia ($query, $filtroA) {
        if (!empty($filtroA)) {
            return $query->where('reference_no','like',"%$filtroA%");
        }
    }
    public function scopeProveedor ($query, $filtroB) {
        if (!empty($filtroB) && $filtroB!="Todos") {
            return $query->where('warehouse_id','=',"$filtroB");
        }
    }
    public function scopeEstadoPago ($query, $filtroC) {
        if (!empty($filtroC) && $filtroC!="Todos") {
            return $query->where('payment_status','=',"$filtroC");
        }
    }
}
