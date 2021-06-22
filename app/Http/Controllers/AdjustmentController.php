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
        return Adjustment::all();
    }
    public function add(request $request){
        try {
            DB::beginTransaction();
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
            foreach ($adjustment["product_adjustments"] as $item) {
                $addAdjustment->product_adjustment()->create([
                    "product_id"=>$item["id"],
                    "adjustment_id"=>$addAdjustment->id,
                    "product_variants_id"=>  $item["product_variant_selected"]["id"]??null,
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
                
                $product_warehouse=Product_warehouse::where('product_id',$item["id"])->where('warehouse_id',$adjustment["warehouse_id"])->first();
                if($item["action"] == '-'){
                    $product_warehouse_qty_total= $product_warehouse->qty -= $item["qty"];
                    
                }
                elseif($item["action"] == '+'){
                    $product_warehouse_qty_total= $product_warehouse->qty += $item["qty"];
                    
                }
                $product_warehouse->update(["qty"=>$product_warehouse_qty_total]);
            }
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
