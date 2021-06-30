<?php

namespace App\Http\Controllers;

use App\Product;
use App\Adjustment;
use App\Product_variant;
use App\Product_warehouse;
use App\Product_adjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustmentController extends Controller
{
    public function load(){
        return Adjustment::with(['warehouse','product_adjustment.product_variant'])->with('product_adjustment.product')->orderBy('adjustments.id','desc')->paginate(10);
    }
    public function add(request $request){
        /* try {
            DB::beginTransaction(); */
            $adjustment=$request->document;
            $adjustment=json_decode($adjustment, true);
            $addAdjustment=Adjustment::create([
                "item"=>$adjustment["item"],
                "note"=> $adjustment["note"],
                "total_qty"=> $adjustment["total_qty"],
                "warehouse_id"=> $adjustment["warehouse_id"],
            ]);
            if ($request->files) {
                foreach($request->files as $file)
                {
                    $name = time().'-'.$file->getClientOriginalName();
                    $file->move(public_path().'/files/adjustment', $name);
                } 

                Adjustment::where('id', $addAdjustment->id)
                ->update(["document"=>$name]);
            }
            foreach ($adjustment["product_adjustment"] as $item) {
                $addAdjustment->product_adjustment()->create([
                    "product_id"=>$item["id"],
                    "adjustment_id"=>$addAdjustment->id,
                    "product_variant_id"=>  $item["product_variant_selected"]["id"]??null,
                    "qty"=>$item["qty"],
                    "action"=>$item["action"],
                ]);

                if (isset($item["product_variant_selected"])) {
                    $product_variant=Product_variant::find($item["product_variant_selected"]["id"]);
                    $product_variant->first();
                    if($item["action"] == '-'){
                       $product_variant_qty_total= $product_variant->qty -= $item["qty"];
                    }
                    elseif($item["action"] == '+'){
                        $product_variant_qty_total= $product_variant->qty += $item["qty"];
                    }

                    $product_variant->update(["qty"=>$product_variant_qty_total]);
                }
                // aqui hay pequeña falla al parecer como no existe qty inicial da error.
                $product_warehouse=Product_warehouse::where('product_id',$item["id"])->where('warehouse_id',$adjustment["warehouse_id"])->first();
                echo $product_warehouse;
                echo $product_warehouse->qty;
                if($item["action"] == '-'){
                    $product_warehouse_qty_total= $product_warehouse->qty -= $item["qty"];
                    
                }
                elseif($item["action"] == '+'){
                    $product_warehouse_qty_total= $product_warehouse->qty += $item["qty"];
                    
                }
                $product_warehouse->update(["qty"=>$product_warehouse_qty_total]);
            }
            
            
            /* DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        } */
    }

    public function edit(request $request){
        /* try {
            DB::beginTransaction(); */
            $adjustment=$request->document;
            $adjustment=json_decode($adjustment, true);
            

            $addAdjustment=Adjustment::find($adjustment["id"])
            ->update([
                "item"=>$adjustment["item"],
                "note"=> $adjustment["note"],
                "total_qty"=> $adjustment["total_qty"],
                "warehouse_id"=> $adjustment["warehouse_id"],
            ]); 
            if ($request->hasFile('file')) {
                foreach($request->files as $file)
                {
                    $name = time().'-'.$file->getClientOriginalName();
                    $file->move(public_path().'/files/adjustment', $name);
                } 

                Adjustment::find($adjustment["id"])
                ->update(["document"=>$name]);
            }else{
                Adjustment::find($adjustment["id"])
                ->update(["document"=>$adjustment["document"]??null]);
            } 

            $product_adjustment_exist = Product_adjustment::where('adjustment_id', $adjustment["id"])->get()->pluck('id')->toArray();
            $product_adjustment_updated=[];
            foreach ($adjustment["product_adjustment"] as $item) {
                if (isset($item["adjustment_id"])) {
                    
                    $product_adjustment_updated[] = $item["id"];
                    //deshaciendo los cambios realizados
                    $productAdjustment=Product_adjustment::find($item["id"]);
                    if ($productAdjustment->action == '+') {
                        if (isset($item["product_variant_id"])) {
                            $productVariant = Product_variant::find($item["product_variant_id"]);
                            $productVariant->qty -= $productAdjustment->qty;
                        }
                        $ProductWarehouse=Product_warehouse::where('product_id',$item["product_id"])->where('warehouse_id',$adjustment["warehouse_id"])->first();
                        $ProductWarehouse->qty -= $productAdjustment->qty;

                    }elseif ($productAdjustment->action == '-') {
                        if (isset($item["product_variant_id"])) {
                          $productVariant = Product_variant::find($item["product_variant_id"]);
                            $productVariant->qty += $productAdjustment->qty;  
                        }
                        $ProductWarehouse=Product_warehouse::where('product_id',$item["product_id"])->where('warehouse_id',$adjustment["warehouse_id"])->first();
                        $ProductWarehouse->qty += $productAdjustment->qty;
                    }
                    if (isset($item["product_variant_id"])) {
                        $productVariant->save();
                    }
                    $ProductWarehouse->save();
                    
                    //aplicando los nuevos cambios
                    if (isset($item["product_variant_id"])) {
                        $product_variant=Product_variant::find($item["product_variant_id"]);
                        $product_variant->first();
                        if($item["action"] == '-'){
                            $item["qty"]-
                        $product_variant_qty_total= $product_variant->qty -= $item["qty"];
                        }
                        elseif($item["action"] == '+'){
                            $product_variant_qty_total= $product_variant->qty += $item["qty"];
                        }

                        $product_variant->update(["qty"=>$product_variant_qty_total]);
                    }
                    Product_adjustment::find($item["id"])->update([
                        "product_id"=>$item["product_id"],
                        "adjustment_id"=>$item["adjustment_id"],
                        "product_variant_id"=>  $item["product_variant_id"]??null,
                        "qty"=>$item["qty"],
                        "action"=>$item["action"],
                    ]);

                    
                    $product_warehouse=Product_warehouse::where('product_id',$item["product_id"])->where('warehouse_id',$adjustment["warehouse_id"])->first();
                    if($item["action"] == '-'){
                        $product_warehouse_qty_total= $product_warehouse->qty -= $item["qty"];
                    }
                    elseif($item["action"] == '+'){
                        $product_warehouse_qty_total= $product_warehouse->qty += $item["qty"];
                    }
                    $product_warehouse->update(["qty"=>$product_warehouse_qty_total]);
                    }else{
                        //se crea un nuevo product_adjustment
                        Product_adjustment::create([
                            "product_id"=>$item["id"],
                            "adjustment_id"=>$adjustment["id"],
                            "product_variant_id"=>  $item["product_variant_selected"]??null,
                            "qty"=>$item["qty"],
                            "action"=>$item["action"],
                        ]);
                    }
            } 
            //si no existe se borra
            $productAdjustmentDelete = array_diff($product_adjustment_exist, $product_adjustment_updated);         
            foreach($productAdjustmentDelete as $productAdjustmentId){
                Product_adjustment::where('id',$productAdjustmentId)->delete();
            }
            /* DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        } */
    }
}
