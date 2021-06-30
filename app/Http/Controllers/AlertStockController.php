<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertStockController extends Controller
{
    public function load(){
        return Product::where('qty','<=','alert_quantity')->paginate(10);
    }
}
