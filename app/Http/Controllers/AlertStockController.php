<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertStockController extends Controller
{
    public function load(){
        return Product::where('is_active', true)->where('is_deleted', false)->whereColumn('alert_quantity', '>', 'qty')->paginate(10);
    }
}
