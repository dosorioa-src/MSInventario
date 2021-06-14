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
        $json_data[]='';
        /* foreach ($data as $item) {
            $collection = collect($item->parent_id);
            echo $collection->search($item->id);
            echo $parent = ($item->parent_id) ? Categorie::find($item->parent_id)->name: "N/A" ;
            echo count($item->product);
            echo $item->name;
            echo $item->is_active;
            echo $valor_precio = $item->product->sum('price')." ";
            echo $valor_costo = $item->product->sum('cost')."<br>";
        } */

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
