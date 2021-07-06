<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{   
    public function index(){
        $data = Brand::where('is_deleted',false)->get();
        return $data;
    }

    public function load(Request $request){
        $filtro = $request->buscador;
        return Brand::where('is_deleted',false)
                    ->search($filtro)
                    ->paginate(10);
    }

    public function add(request $request){
        
        $brand=$request->document;
        $brand=json_decode($brand, true);
        $addBrand=Brand::create([
            "title"=> $brand["title"],
        ]);
        if ($request->hasFile('file')) {
            foreach($request->files as $file)
            {
                $name = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/images/brand', $name);
            } 

            Brand::where('id', $addBrand->id)
            ->update(["image"=>$name]);
        }else{
            Brand::where('id', $addBrand->id)
            ->update(["image"=>'no_image.png']);
        }
        
    }

    public function edit(request $request){
        $brand=$request->document;
        $brand=json_decode($brand, true);
        $addBrand=Brand::find($brand["id"])->update([
            "title"=> $brand["title"],
        ]);
        if ($request->hasFile('file')) {
            foreach($request->files as $file)
            {
                $name = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/images/brand', $name);
            } 
            Brand::where('id', $brand["id"])
            ->update(["image"=>$name]);
        }else{
            Brand::where('id', $brand["id"])
            ->update(["image"=>'no_image.png']);
        }
    }

    public function delete(request $request){
        Brand::where('id', $request->id)
            ->update(['is_deleted' => true, 'is_active'=>false]);
    }
}
