<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    public function product_sale()
    {
        return $this->hasMany(Product_sale::class);
    }

    public function taxe()
    {
        return $this->belongsTo(Taxe::class);
    }

    public function scopeNumReferencia ($query, $filtroA) {
        if (!empty($filtroA)) {
            return $query->where('reference_no','like',"%$filtroA%");
        }
    }
    public function scopeOrigen ($query, $filtroB) {
        if (!empty($filtroB) && $filtroB!="Todos") {
            return $query->where('origin','=',"$filtroB");
        }
    }
    public function scopeEstadoVenta ($query, $filtroC) {
        if (!empty($filtroC) && $filtroC!="Todos") {
            return $query->where('sale_status','=',"$filtroC");
        }
    }
    public function scopeEstadoPago ($query, $filtroD) {
        if (!empty($filtroD) && $filtroD!="Todos") {
            return $query->where('payment_status','=',"$filtroD");
        }
    }
}
