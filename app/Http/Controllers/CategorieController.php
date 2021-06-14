<?php

namespace App\Http\Controllers;

use App\Product;
use App\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    public function load(){
        $data = Categorie::with('Product')->get();
        $json_data = [];
        foreach ($data as $item) {
            array_push($json_data,[
                "parent" => ($item->parent_id) ? Categorie::find($item->parent_id)->name: "N/A" ,
                "total_products"=>count($item->product),
                "stock"=>$item->product->sum('qty'),
                "categorie_name"=>$item->name,
                "is_active"=>$item->is_active,
                "sum_price"=> $item->product->sum('price'),
                "sum_cost"=> $item->product->sum('cost'),
            ]);
            
        }

        return $json_data;
    }

    public function add(request $request){
        Categorie::create($request->All());
    }

    public function edit(request $request){
        Categorie::where('id', $request->id)
        ->update($request->All());
    }
    
    public function delete(request $request){
        Categorie::where('id', $request->id)
        ->update(['is_deleted' => true]);
    }
}
