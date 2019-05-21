<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Courier;
class CourierController extends Controller
{
    public function getAll(){
        return Courier::all();
    }
}
