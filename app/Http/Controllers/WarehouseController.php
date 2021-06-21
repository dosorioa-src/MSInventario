<?php

namespace App\Http\Controllers;

use App\Warehouse;

class WarehouseController extends Controller
{
    public function load()
    {
        return Warehouse::All();
    }
}
