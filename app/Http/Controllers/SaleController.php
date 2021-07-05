<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function load(){
        return Sale::with('product_sale')->paginate(10);
    }
}
