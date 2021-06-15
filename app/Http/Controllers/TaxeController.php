<?php

namespace App\Http\Controllers;

use App\Taxe;
use Illuminate\Http\Request;

class TaxeController extends Controller
{
    public function load(){
        return Taxe::all();
    }
}
