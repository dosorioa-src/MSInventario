<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function product_variant(){
        return $this->hasMany(Product_variant::class);
    }
    public function warehouse(){
        return $this->belongsToMany(Warehouse::class)->withPivot('id', 'qty', 'price');
    }
    public function product_warehouse(){
        return $this->hasMany(Product_warehouse::class);
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function scopeSearch($query,$value){
        if ($value) {
            return $query->Where(DB::raw("CONCAT(products.name, ' ', products.code)"),'like',"%$value%");
        }
    }

    public function scopeSearchNameOrCode($query,$filtro){
        if (!empty($filtro)) {
            return $query->where(DB::raw("CONCAT(name, ' ',code)"),'like',"%$filtro%");
        }  
    }

    public function scopeSearchCategory($query,$filtroC){
        if (!empty($filtroC) && $filtroC!="Todos") {
            return $query->where('categorie_id','=',"$filtroC");
        }  
    }

    public function scopeSearchBrand($query,$filtroB){
        if (!empty($filtroB) && $filtroB!="Todos") {
            return $query->where('brand_id','=',"$filtroB");
        }  
    }

    public function scopeSearchAlertStock($query,$filtro){
        if (!empty($filtro)) {
            return $query->where(DB::raw("CONCAT(name, ' ',code)"),'like',"%$filtro%");
        }  
    }
    

    

    protected $guarded = [];
}
