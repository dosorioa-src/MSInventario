<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Product;
use Illuminate\Http\Request;

class CategorieController extends Controller
{   
    public function index(){
        $data = Categorie::where('is_deleted', false)->where('is_active','=',1)->get();
        return $data;
    }

    public function load(Request $request)
    {
        $filtro = $request->buscador;
        $data = Categorie::with('product')
        ->where('is_deleted', false)
        ->search($filtro)
        ->paginate(10);


        foreach ($data as $key => $item) {
            
            $item->id = $item->id;
            $item->parent_id = $item->parent_id;
            $item->name = $item->name;
            $item->parent = ($item->parent_id) ? Categorie::find($item->parent_id)->name : "N/A";
            $item->total_products = $item->product->where('is_deleted','==', false)->count($item->product);
            $item->stock = $item->product->where('is_deleted','==', false)->sum('qty');
            $item->sum_price = $item->product->where('is_deleted','==', false)->sum('price');
            $item->sum_cost =$item->product->where('is_deleted','==', false)->sum('cost');

            $item->is_active = $item->is_active;
        }

        return $data;
    }

    public function add(request $request)
    {
        Categorie::create($request->All());
    }

    public function edit(request $request)
    {
        Categorie::where('id', $request->id)
            ->update($request->All());
    }

    public function delete(request $request)
    {
        Categorie::where('id', $request->id)
            ->update(['is_deleted' => true]);
    }
}
