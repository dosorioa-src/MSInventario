<?php

namespace App\Http\Controllers;

use App\Type_indetification;
use Illuminate\Http\Request;

class TypeIndetificationController extends Controller
{
    public function load(){
        return Type_indetification::All();
    }
}
