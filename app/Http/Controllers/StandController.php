<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StandCar;

class StandController extends Controller
{
    public function index()
    {
        $stand_cars = StandCar::all();
        return $stand_cars;
    }
}
