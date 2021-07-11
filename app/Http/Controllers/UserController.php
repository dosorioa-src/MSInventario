<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function load(Request $request){
        $filtro = $request->buscador;
        $filtroS = $request->buscadorS;
        return User::select('id', 'name', 'email', 'role_id', 'phone','type_indetification_id','number_identification','photo','is_active')
                    ->where('is_deleted',false)
                    ->search($filtro)
                    ->searchStatus($filtroS)
                    ->paginate(10);
    }

    public function add(request $request){
        $request->merge([
            'password' => Hash::make($request->password),
        ]);
        User::create($request->All());
    }

    public function delete(request $request){
        User::where('id', $request->id)
        ->update(['is_deleted' => true]);
    }

    public function edit(request $request){
        if ($request->password) {
            $request->merge([
                'password' => Hash::make($request->password),
            ]);
        }
        User::where('id', $request->id)
        ->update($request->All());
    }
}
