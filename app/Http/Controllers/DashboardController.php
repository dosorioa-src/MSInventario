<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function load(){
        $consulta1 = round(Sale::sum('grand_total'), 2);//Ganancias
        $consulta2 = Sale::count();//#Ventas
        $consulta3 = Product::count();//#Productos
        $consulta4 = Sale::distinct('client')->count();//#Clientes

        $now = Carbon::now('America/Bogota');
        $now->tz = date_default_timezone_get();

        $consulta5 = round(Sale::whereDate('created_at','=', $now)->sum('grand_total'), 2);//Venta Hoy
        $consulta6 = round(Sale::whereMonth('created_at','=', $now)->sum('grand_total'), 2);//Venta Mes

        $startWeek = Carbon::now('America/Bogota')->startOfWeek();
        $startWeek->tz = date_default_timezone_get();
        $consulta7 = round(Sale::whereBetween('created_at', [$startWeek,$now])->sum('grand_total'), 2);//Venta Semanal 

        $consulta8 = round(Sale::whereYear('created_at','=', $now)->sum('grand_total'), 2);//Venta Anual

        $consulta9 = Sale::whereBetween('created_at', [$startWeek,$now])->count();//#Pedidos Nuevos Semanal
        $consulta10 = Sale::where('sale_status', '=', 1)->count();//#Pedidos Pendientes
        $consulta11 = Sale::where('sale_status', '=', 2)->count();//#Pedidos Finalizados
        $consulta12 = Sale::where('sale_status', '=', 3)->count();//#Pedidos Cancelados

        $data = array(
            'ganancias' =>  $consulta1,
            'ventas'    =>  $consulta2,
            'productos' =>  $consulta3,
            'clientes'  =>  $consulta4,
            'vhoy'      =>  $consulta5,
            'vmes'      =>  $consulta6,
            'vsemana'   =>  $consulta7,
            'vanual'    =>  $consulta8,
            'nsemana'   =>  $consulta9,
            'npendientes' => $consulta10,
            'nfinalizados' => $consulta11,
            'ncancelados' => $consulta12,
            );

        //Tasa de abastecimiento de pedidos
        $npsc = Sale::where('sale_status', '=', 2)->count();
        $ntp = Sale::count();
        $tap = ($npsc/$ntp)*100;
        $tap = round($tap, 2);

        //indice de rotación de stock
        $dataKardex=Product::with('product_adjustment')->with('product_purchase')->with('product_sale')->first();
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


            $ini='2021-07-01';
            $fin='2021-07-31';
            $from = new Carbon($ini, 'America/Lima');
            $from->tz = date_default_timezone_get();

            $to = new Carbon($fin, 'America/Lima');
            $to->tz = date_default_timezone_get();
            $to->addDay();
            $collection = collect($kardex);
            
            $filtered = $collection->where('created_at', '>=' , $from)->where('created_at', '<=' , $to);
            
            $dataKardex->kardex= $filtered->sortBy('created_at')->values();

            
            /* $dataKardex->kardex=collect($kardex)->sortBy('created_at')->values(); */
            $initialStock=0;
            $finalStock=0;
            $salesTotal=0;
            foreach ($dataKardex->kardex as $key => $value) {
                if ($value->type=="Compra" or $value->type=="Ajuste +") {
                    $value->existence=$count+=$value->qty;
                    $value->saldo= $saldo+=$value->qty* $value->cost;
                    
                }elseif ($value->type=="Venta" or $value->type=="Ajuste -"){
                    $value->existence=$count-=$value->qty;
                    $value->saldo= $saldo-=$value->qty* $value->cost;
                }
                if ($value->type=="Venta"){
                    $salesTotal+=$value->qty* $value->cost;
                }

                if ($key === 0) {
                    $initialStock=$value->saldo;
                }
                $finalStock=$value->saldo;
            }
        }
        
        $stockPromedio=($initialStock+$finalStock)/2;
        $indiceRotacion=$salesTotal/$stockPromedio;
        
        return $indiceRotacion;
    }
}
