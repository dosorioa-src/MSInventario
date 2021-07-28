<?php

namespace App\Http\Controllers;

use App\Product;
use App\Temporale;
use App\Warehouse;
use App\Publication;
use App\Product_variant;
use App\Product_warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function search(request $request){
        return Product::search($request->value)->where('is_deleted','=',false)->with('product_variant')->get(['products.id','products.name','products.price','products.cost','code','products.is_warehouse', 'products.qty']);
    }
    public function load(Request $request){
        $filtro = $request->buscador;
        $filtroC = $request->buscadorC;
        $filtroB = $request->buscadorB;
        return Product::with('categorie')->with('brand')->with('unit')->with('product_variant')->with('warehouse')
                        ->where('is_deleted','=',false)
                        ->searchNameOrCode($filtro)
                        ->searchCategory($filtroC)
                        ->searchBrand($filtroB)
                        ->orderBy('id', 'desc')
                        ->paginate(10);
    }
    public function add(request $request){
        /* try {
        DB::beginTransaction(); */
        $product=$request->document;
        $product=json_decode($product, true);
        $addProduct=Product::create([
            "name"=>$product["name"],
            "brand_id"=> $product["brand_id"],
            "categorie_id"=> $product["categorie_id"],
            "code"=> $product["code"],
            "cost"=> $product["cost"],
            "weight"=> $product["weight"],
            "product_details"=> $product["product_details"],
            "featured"=> $product["featured"],
            "is_variant"=> $product["is_variant"],
            "is_warehouse"=> 1,
            "is_diffPrice"=> $product["is_diffPrice"],
            "price"=> $product["price"],
            "purchase_unit_id"=> $product["purchase_unit_id"],
            "sale_unit_id"=> $product["sale_unit_id"],
            "tax_id"=> $product["tax_id"],
            "tax_method"=> $product["tax_method"],
            "type"=> $product["type"],
            "unit_id"=> $product["unit_id"],
            "alert_quantity"=> $product["alert_quantity"],
        ]);
        if ($request->hasFile('file')) {
            foreach($request->files as $file)
            {
                foreach ($file as $key => $img ) {
                    $name = time().'-'.$img->getClientOriginalName();
                    $img->move(public_path().'/images/product', $name);
                    $names[] = $name; 
                }
            }
            Product::where('id', $addProduct->id)
            ->update(["image"=>implode(",", $names)]);
        }else{
                Product::where('id', $addProduct->id)
                ->update(["image"=>'no_image.png']);
        }
        
        
        if ($product["is_variant"]==true) {
            foreach ($product["product_variant"] as $item) {
                $addProduct->product_variant()->create($item);
            }
        }

        foreach ($product["warehouse"] as $item ) {
            $addProduct->product_warehouse()->create([
                "warehouse_id"=> $item["id"],
            ]);
        }
        /* DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        } */
    }

    public function edit(request $request){
        
        try {
            DB::beginTransaction();
            $names=[];
            $lastImages=[];
            $newImages='';
            $product=$request->document;
            $product=json_decode($product, true);
            $addProduct=Product::where('id', $product["id"])
            ->update([
                "name"=>$product["name"],
                "brand_id"=> $product["brand_id"],
                "categorie_id"=> $product["categorie_id"],
                "code"=> $product["code"],
                "cost"=> $product["cost"],
                "weight"=> $product["weight"],
                "product_details"=> $product["product_details"],
                "featured"=> $product["featured"],
                "is_variant"=> $product["is_variant"],
                "is_warehouse"=> $product["is_warehouse"],
                "price"=> $product["price"],
                "purchase_unit_id"=> $product["purchase_unit_id"],
                "sale_unit_id"=> $product["sale_unit_id"],
                "tax_id"=> $product["tax_id"],
                "tax_method"=> $product["tax_method"],
                "type"=> $product["type"],
                "unit_id"=> $product["unit_id"],
                "alert_quantity"=> $product["alert_quantity"],
            ]); 
            
            if ($request->hasFile('file')) {
                foreach($request->files as $file)
                {
                    foreach ($file as $key => $img ) {
                        $name = time().'-'.$img->getClientOriginalName();
                        $img->move(public_path().'/images/product', $name);
                        $names[] = $name; 
                    }
                } 
                $newImages=implode(",",$names);
                Product::where('id', $product["id"])
                ->update(["image"=>($product["image"]=='no_image.png') ? $newImages : $newImages.','.$product["image"]
            ]);
            }else{
                if(!$product["image"]){
                    echo "llegue";
                    Product::where('id', $product["id"])
                    ->update(["image"=>'no_image.png']);
                }else{
                    Product::where('id', $product["id"])
                    ->update(["image"=>$product["image"]]);
                }
                
            }
            
            if ($product["is_variant"]==true) {

                $product_variants_exist = Product_variant::where('product_id', $product["id"])->get()->pluck('id')->toArray();
                $product_variants = $product["product_variant"] ?? [];
                $product_variants_update = [];
                
                foreach ($product_variants as $product_variant)
                {
                    if(isset($product_variant['id']))
                    {
                        Product_variant::find($product_variant['id'])->update($product_variant);
                        $product_variants_update[] = $product_variant['id'];
                    }else{
                        $newVariant = array_merge($product_variant,["product_id"=>$product["id"]]);
                        Product_variant::create($newVariant); 
                    }                
                }

                $productVariantsDelete = array_diff($product_variants_exist, $product_variants_update);         
                foreach($productVariantsDelete as $productVariantId){
                        Product_variant::where('id',$productVariantId)->delete();;
                }


            }
            if ($product["is_warehouse"]==true) {
                foreach ($product["warehouse"] as $item) {
                    Product_warehouse::where('id', $item["pivot"]["id"])->update([
                        "price"=>$item["pivot"]["price"],
                        "warehouse_id"=> $item["id"],
                    ]);
                }
                
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    
    public function delete(request $request){
        Product::where('id', $request->id)
        ->update(['is_deleted' => true]);
    }
}
