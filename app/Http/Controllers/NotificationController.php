<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function bell(){
        $alertQuantity= Product::where('qty','<=','alert_quantity')->count();

        /* $totalAlert=$alertQuantity;
        return response()->json([
            "notifications"=>[
               array("message" =>'Tienes '.$alertQuantity.' productos por debajo stock minimo',),
               //array("message"=>$totalAlert)
            ],
            "totalNotifications" => $totalAlert
        ]); */

        return view('layouts.simple.master', compact('alertQuantity'));
    }
}
