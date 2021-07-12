<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Product_purchase;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function load(Request $request){
        
        if ($request->from == "" AND $request->to != "") {
            $to = new Carbon($request->to, 'America/Lima');
            $to->tz = date_default_timezone_get();

            return Purchase::whereDate('created_at', '<=', $to)
                        ->with('product_purchase')->with('taxe')->with('supplier')->with('product_purchase.product')->with('product_purchase.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->proveedor($request->filtroB)
                        ->estadoPago($request->filtroC)
                        ->orderBy('Purchases.id','desc')
                        ->paginate(7);

        } elseif ($request->from != "" AND $request->to == "") {
            $from = new Carbon($request->from, 'America/Lima'); 
            $from->tz = date_default_timezone_get();

            return Purchase::whereDate('created_at', '>=', $from)
                        ->with('product_purchase')->with('taxe')->with('supplier')->with('product_purchase.product')->with('product_purchase.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->proveedor($request->filtroB)
                        ->estadoPago($request->filtroC)
                        ->orderBy('Purchases.id','desc')
                        ->paginate(7);


        } elseif ($request->from == "" AND $request->to == "") {

            return Purchase::with('product_purchase')
                        ->with('taxe')->with('supplier')->with('product_purchase.product')->with('product_purchase.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->proveedor($request->filtroB)
                        ->estadoPago($request->filtroC)
                        ->orderBy('Purchases.id','desc')
                        ->paginate(7);

        } elseif ($request->from != "" AND $request->to != "") {
            $from = new Carbon($request->from, 'America/Lima'); 
            $from->tz = date_default_timezone_get();
            $to = new Carbon($request->to, 'America/Lima');
            $to->tz = date_default_timezone_get();
            $to->addDay();

            return Purchase::whereBetween('created_at', [$from, $to])
                        ->with('product_purchase')->with('taxe')->with('supplier')->with('product_purchase.product')->with('product_purchase.product_variant')
                        ->where('is_deleted', false)
                        ->numReferencia($request->filtroA)
                        ->proveedor($request->filtroB)
                        ->estadoPago($request->filtroC)
                        ->orderBy('Purchases.id','desc')
                        ->paginate(7);
            
        }

    }

    public function add(request $request){
        /* try {
        DB::beginTransaction(); */
        $purchase=$request->document;
        $purchase=json_decode($purchase, true);

        $addPurchase=Purchase::create([
            "supplier_id"=>$purchase["supplier_id"],
            "item"=> $purchase["item"],
            "total_qty"=> $purchase["total_qty"],
            "taxe_id"=> $purchase["taxe"]["id"],
            "item" => $purchase["item"],
            "total_qty"=> $purchase["total_qty"],
            "total_tax"=> $purchase["total_tax"],
            "total_cost"=> $purchase["total_cost"],
            "order_tax"=> $purchase["order_tax"],
            "order_discount"=> $purchase["order_discount"],
            "shipping_cost"=> $purchase["shipping_cost"],
            /* "paid_amount"=> $purchase["paid_amount"], */
            "grand_total"=> $purchase["grand_total"],
            "status"=> $purchase["status"],
            "payment_status"=> $purchase["payment_status"],
            "note"=> $purchase["note"],
        ]);
        if ($request->hasFile('file')) {
            foreach($request->files as $file)
            {
                $name = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/files/purchase', $name);
            }
            Purchase::where('id', $addPurchase->id)
            ->update(["document"=>$name]);
        }

        foreach ($purchase["product_purchase"] as $item) {
           $product_variant_id = isset($item["product_variant_selected"]) ?  $item["product_variant_selected"]["id"]:null;
           $additional_price = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_price"]:0;
           $additional_cost = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_cost"]:0;
            $addPurchase->product_purchase()->create([
                "product_id"=>$item["id"],
                "purchase_id"=>$addPurchase->id,
                "product_variant_id"=>  $product_variant_id,
                "qty"=>$item["qty"],
                "cost" => $item["cost"]+ $additional_cost,
                //"discount"=>$item["discount"],
                "subtotal"=>$item["subtotal"],
            ]);
        }
        /* DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        } */
    }

    public function edit(request $request){

        $purchase=$request->document;
        $purchase=json_decode($purchase, true);
        
        $addPurchase=Purchase::find($purchase["id"])
        ->update([
            "supplier_id"=>$purchase["supplier_id"],
            "item"=> $purchase["item"],
            "total_qty"=> $purchase["total_qty"],
            "taxe_id"=> $purchase["taxe"]["id"],
            "item" => $purchase["item"],
            "total_qty"=> $purchase["total_qty"],
            "total_tax"=> $purchase["total_tax"],
            "total_cost"=> $purchase["total_cost"],
            "order_tax"=> $purchase["order_tax"],
            "order_discount"=> $purchase["order_discount"],
            "shipping_cost"=> $purchase["shipping_cost"],
            /* "paid_amount"=> $purchase["paid_amount"], */
            "grand_total"=> $purchase["grand_total"],
            "status"=> $purchase["status"],
            "payment_status"=> $purchase["payment_status"],
            "note"=> $purchase["note"],
        ]); 
        if ($request->hasFile('file')) {
            foreach($request->files as $file)
            {
                $name = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/files/purchase', $name);
            } 

            purchase::find($purchase["id"])
            ->update(["document"=>$name]);
        }else{
            purchase::find($purchase["id"])
            ->update(["document"=>$purchase["document"]??null]);
        } 

        $product_purchase_exist = Product_purchase::where('purchase_id', $purchase["id"])->get()->pluck('id')->toArray();
        $product_purchase_updated=[];
        foreach ($purchase["product_purchase"] as $item) {
            if (isset($item["purchase_id"])) {
                $product_purchase_updated[] = $item["id"];

                $product_variant_id = isset($item["product_variant_selected"]) ?  $item["product_variant_selected"]["id"]:null;
                $additional_price = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_price"]:0;
                $additional_cost = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_cost"]:0;
                
                Product_purchase::where('id',$item["id"])->update([
                    "product_id"=>$item["product_id"],
                    "purchase_id"=>$item["purchase_id"],
                    "product_variant_id"=>  $item["product_variant_id"],
                    "qty"=>$item["qty"],
                    "cost" => $item["cost"]+ $additional_cost,
                    //"discount"=>$item["discount"],
                    "subtotal"=>$item["subtotal"],
                ]);
                
                }else{
                    //se crea un nuevo product_adjustment
                    $product_variant_id = isset($item["product_variant_selected"]) ?  $item["product_variant_selected"]["id"]:null;
                    $additional_price = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_price"]:0;
                    $additional_cost = isset($item["product_variant_selected"]) ? $item["product_variant_selected"]["additional_cost"]:0;

                    Product_purchase::create([
                        "product_id"=>$item["id"],
                        "purchase_id"=>$purchase["id"],
                        "product_variant_id"=>  $product_variant_id,
                        "qty"=>$item["qty"],
                        "cost" => $item["cost"]+ $additional_cost,
                        //"discount"=>$item["discount"],
                        "subtotal"=>$item["subtotal"],
                    ]);
                }
        } 
        //si no existe se borra
        $productPurchaseDelete = array_diff($product_purchase_exist, $product_purchase_updated);         
        foreach($productPurchaseDelete as $productPurchaseId){
            Product_purchase::where('id',$productPurchaseId)->delete();
        }
    }

    public function delete(request $request){
        Purchase::where('id', $request->id)
        ->update(['is_deleted' => true]);
    }
}
