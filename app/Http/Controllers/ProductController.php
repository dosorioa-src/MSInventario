<?php

namespace App\Http\Controllers;

use App\Product;
use App\Warehouses;
use App\Product_variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function load(){
        return Product::all();
    }

    public function add(request $request){
        $addProduct=Product::create([
            "name"=>$request->name,
            "brand_id"=> $request->brand_id,
            "categorie_id"=> $request->categorie_id,
            "code"=> $request->code,
            "cost"=> $request->cost,
            "product_details"=> $request->product_details,
            "featured"=> $request->featured,
            "is_variant"=> $request->is_variant,
            "is_warehouse"=> $request->is_warehouse,
            "price"=> $request->price,
            "purchase_unit_id"=> $request->purchase_unit_id,
            "sale_unit_id"=> $request->sale_unit_id,
            "tax_id"=> $request->tax_id,
            "tax_method"=> $request->tax_method,
            "type"=> $request->type,
            "unit_id"=> $request->unit_id,
            "alert_quantity"=> $request->alert_quantity,
        ]);
        if ($request->is_variant==true) {
            foreach ($request->variant as $item) {
                $addProduct->product_variant()->create($item);
            }
        }
        if ($request->is_warehouse==true) {
            $warehouse=Warehouses::first();
            $addProduct->product_warehouse()->create([
                "price"=>$request->warehouse["price"],
                "warehouse_id"=> $warehouse->id,//7 es el id del almacen virtual
            ]);
        }
        
    }

    public function edit(request $request){
        Product::where('id', $request->id)
        ->update($request->All());
    }
    
    public function delete(request $request){
        Product::where('id', $request->id)
        ->update(['is_deleted' => true]);
    }
}
