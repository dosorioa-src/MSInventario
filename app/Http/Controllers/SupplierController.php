<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function load()
    {
        return Supplier::all();
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
