<?php

namespace App\Http\Controllers;

use App\Product;
use App\Purchase;
use Carbon\Carbon;
use App\Product_adjustment;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function load(request $request){

        $dataKardex=Product::search($request->searchValue)->with('product_adjustment')->with('product_purchase')->with('product_sale')->first();
        $kardex=[];
        $count=0;
        $saldo=0;
        
        if ($dataKardex) {
            foreach ($dataKardex->product_sale as $key => $value) {
                $value->type = "Venta";
                $kardex[]=$value;
            }
            foreach ($dataKardex->product_adjustment as $key => $value) {
                if ($value->action == "+") {
                    $value->type = "Ajuste +";
                }elseif ($value->action == "-"){
                    $value->type = "Ajuste -";
                }
                
                $kardex[]=$value;
            }
            foreach ($dataKardex->product_purchase as $key => $value) {
                $value->type = "Compra";
                $kardex[]=$value;
            }



            $from = new Carbon($request->from, 'America/Lima');
            $from->tz = date_default_timezone_get();

            $to = new Carbon($request->to, 'America/Lima');
            $to->tz = date_default_timezone_get();
            $to->addDay();
            $collection = collect($kardex);
            
            $filtered = $collection->where('created_at', '>=' , $from)->where('created_at', '<=' , $to);
            
            $dataKardex->kardex= $filtered->sortBy('created_at')->values();

            
            /* $dataKardex->kardex=collect($kardex)->sortBy('created_at')->values(); */
            foreach ($dataKardex->kardex as $key => $value) {
                if ($value->type=="Compra" or $value->type=="Ajuste +") {
                    $value->existence=$count+=$value->qty;
                    $value->saldo= $saldo+=$value->qty* $value->cost;
                    
                }elseif ($value->type=="Venta" or $value->type=="Ajuste -"){
                    $value->existence=$count-=$value->qty;
                    $value->saldo= $saldo-=$value->qty* $value->cost;
                }
                
            }
        }
        
        
        return $dataKardex;
    }
}
