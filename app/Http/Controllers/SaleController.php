<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Product;
use Carbon\Carbon;
use App\Product_sale;
use App\Product_purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function load(Request $request){
        
        if ($request->from == "" AND $request->to != "") {
            $to = new Carbon($request->to, 'America/Lima');
            $to->tz = date_default_timezone_get();

            return Sale::whereDate('created_at', '<=', $to)
                        ->with('product_sale')
                        ->with('taxe')
                        ->with('product_sale.product')
                        ->with('product_sale.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->origen($request->filtroB)
                        ->estadoVenta($request->filtroC)
                        ->estadoPago($request->filtroD)
                        ->orderBy('sales.id','desc')
                        ->paginate(7);

        } elseif ($request->from != "" AND $request->to == "") {
            $from = new Carbon($request->from, 'America/Lima'); 
            $from->tz = date_default_timezone_get();

            return Sale::whereDate('created_at', '>=', $from)
                        ->with('product_sale')
                        ->with('taxe')
                        ->with('product_sale.product')
                        ->with('product_sale.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->origen($request->filtroB)
                        ->estadoVenta($request->filtroC)
                        ->estadoPago($request->filtroD)
                        ->orderBy('sales.id','desc')
                        ->paginate(7);

        } elseif ($request->from == "" AND $request->to == "") {

            return Sale::with('product_sale')
                        ->with('taxe')
                        ->with('product_sale.product')
                        ->with('product_sale.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->origen($request->filtroB)
                        ->estadoVenta($request->filtroC)
                        ->estadoPago($request->filtroD)
                        ->orderBy('sales.id','desc')
                        ->paginate(7);

        } elseif ($request->from != "" AND $request->to != "") {
            $from = new Carbon($request->from, 'America/Lima'); 
            $from->tz = date_default_timezone_get();
            $to = new Carbon($request->to, 'America/Lima');
            $to->tz = date_default_timezone_get();
            $to->addDay();

            return Sale::whereBetween('created_at', [$from, $to])
                        ->with('product_sale')
                        ->with('taxe')
                        ->with('product_sale.product')
                        ->with('product_sale.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->origen($request->filtroB)
                        ->estadoVenta($request->filtroC)
                        ->estadoPago($request->filtroD)
                        ->orderBy('sales.id','desc')
                        ->paginate(7);

        }

    }

    public function add(request $request){
        try {
        DB::beginTransaction();
        $sale=$request->document;
        $sale=json_decode($sale, true);
            
        $addSale=Sale::create([
            "client"=>$sale["client"],
            "origin"=> $sale["origin"],
            "origin_sale_code"=> $sale["origin_sale_code"],
            "taxe_id"=> $sale["taxe"]["id"],
            "item" => $sale["item"],
            "total_qty"=> $sale["total_qty"],
            "order_discount"=> $sale["order_discount"],
            "total_price"=> $sale["total_price"],
            "order_tax"=> $sale["order_tax"],
            "shipping_cost"=> $sale["shipping_cost"],
            "grand_total"=> $sale["grand_total"],
            "sale_status"=> $sale["sale_status"],
            "payment_status"=> $sale["payment_status"],
            /* "paid_amount"=> $sale["paid_amount"], */
            "sale_note"=> $sale["sale_note"],
            "staff_note"=> $sale["staff_note"],
        ]);
        if ($request->hasFile('file')) {
            foreach($request->files as $file)
            {
                $name = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/files/sale', $name);
            }
            Sale::where('id', $addSale->id)
            ->update(["document"=>$name]);
        }

        foreach ($sale["product_sale"] as $item) {
           $product_variant_id = isset($item["product_variant_selected"]) ?  $item["product_variant_selected"]["id"]:null;
           $additional_price = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_price"]:0;
           $additional_cost = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_cost"]:0;
            $addSale->product_sale()->create([
                "product_id"=>$item["id"],
                "sale_id"=>$addSale->id,
                "product_variant_id"=>  $product_variant_id,
                "qty"=>$item["qty"],
                "unit_price"=>$item["price"]+ $additional_price,
                "cost" => $item["cost"]+ $additional_cost,
                /* "discount"=>$item["discount"], */
                "subtotal"=>$item["subtotal"],
            ]);
        }
        DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }


    }

    public function edit(request $request){
        $sale=$request->document;
        $sale=json_decode($sale, true);
        
        $addSale=Sale::find($sale["id"])
        ->update([
            "client"=>$sale["client"],
            "origin"=> $sale["origin"],
            "origin_sale_code"=> $sale["origin_sale_code"],
            "taxe_id"=> $sale["taxe"]["id"],
            "item" => $sale["item"],
            "total_qty"=> $sale["total_qty"],
            "order_discount"=> $sale["order_discount"],
            "total_price"=> $sale["total_price"],
            "order_tax"=> $sale["order_tax"],
            "shipping_cost"=> $sale["shipping_cost"],
            "grand_total"=> $sale["grand_total"],
            "sale_status"=> $sale["sale_status"],
            "payment_status"=> $sale["payment_status"],
            /* "paid_amount"=> $sale["paid_amount"], */
            "sale_note"=> $sale["sale_note"],
            "staff_note"=> $sale["staff_note"],
        ]); 
        if ($request->hasFile('file')) {
            foreach($request->files as $file)
            {
                $name = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/files/sale', $name);
            } 

            sale::find($sale["id"])
            ->update(["document"=>$name]);
        }else{
            sale::find($sale["id"])
            ->update(["document"=>$sale["document"]??null]);
        } 

        $product_sale_exist = Product_sale::where('sale_id', $sale["id"])->get()->pluck('id')->toArray();
        $product_sale_updated=[];
        foreach ($sale["product_sale"] as $item) {
            if (isset($item["sale_id"])) {
                $product_sale_updated[] = $item["id"];

                $product_variant_id = isset($item["product_variant"]) ?  $item["product_variant"]["id"]:null;
                $additional_price = isset($item["product_variant"]) ? $item["product_variant"]["additional_price"]:0;
                $additional_cost = isset($item["product_variant"]) ? $item["product_variant"]["additional_cost"]:0;
                
                Product_sale::where('id',$item["id"])->update([
                    "product_id"=>$item["product_id"],
                    "sale_id"=>$sale["id"],
                    "product_variant_id"=>  $product_variant_id,
                    "qty"=>$item["qty"],
                    "unit_price"=>$item["product"]["price"] + $additional_price,
                    "cost" => $item["product"]["cost"] + $additional_cost,
                    /* "discount"=>$item["discount"], */
                    "subtotal"=>$item["subtotal"],
                ]);
                }else{
                    //se crea un nuevo product_adjustment
                    $product_variant_id = isset($item["product_variant_selected"]) ?  $item["product_variant_selected"]["id"]:null;
                    $additional_price = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_price"]:0;
                    $additional_cost = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_cost"]:0;
                    Product_sale::create([
                        "product_id"=>$item["id"],
                        "sale_id"=>$sale["id"],
                        "product_variant_id"=>  $product_variant_id,
                        "qty"=>$item["qty"],
                        "unit_price"=>$item["price"]+ $additional_price,
                        "cost" => $item["cost"]+ $additional_cost,
                        /* "discount"=>$item["discount"], */
                        "subtotal"=>$item["subtotal"],
                    ]);
                }
        } 
        //si no existe se borra
        $productSaleDelete = array_diff($product_sale_exist, $product_sale_updated);         
        foreach($productSaleDelete as $productSaleId){
            Product_sale::where('id',$productSaleId)->delete();
        }
    }

    public function delete(request $request){
        Sale::where('id', $request->id)
        ->update(['is_deleted' => true]);
    }

    public function updateCost(){
        $purchase = DB::select("SELECT * FROM product_purchases WHERE qty <> used ORDER BY created_at ASC limit 1");
        $adjustment = DB::select("SELECT * FROM product_adjustments WHERE qty <> used AND ACTION='+' ORDER BY created_at ASC limit 1");
        if ($purchase[0]->created_at < $adjustment[0]->created_at) {
            Product::where('id', $purchase[0]->product_id)
            ->update(['cost' => $purchase[0]->cost]);
            
        }else{
            Product::where('id', $adjustment[0]->product_id)
            ->update(['cost' => $adjustment[0]->cost]);
        }

        
    }
}
