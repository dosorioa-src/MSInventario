<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function loadSelect()
    {
        return Supplier::all();
    }

    public function load(Request $request)
    {
        $filtro = $request->buscador;
        return Supplier::select('id', 'name', 'company_name', 'rut_number', 'email', 'phone_number', 'address', 'is_active')
                        ->where('is_deleted', false)
                        ->search($filtro)
                        ->paginate(10);
    }

    public function add(request $request)
    {
        Supplier::create($request->All());
    }

    public function edit(request $request)
    {
        Supplier::where('id', $request->id)
            ->update($request->All());
    }

    public function delete(request $request)
    {
        Supplier::where('id', $request->id)
            ->update(['is_deleted' => true]);
    }
}
