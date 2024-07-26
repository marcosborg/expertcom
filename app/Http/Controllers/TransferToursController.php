<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransferTour;

class TransferToursController extends Controller
{
    public function index()
    {

        $transfer_tours = TransferTour::all();

        return view('website.transfer_tours.index', compact('transfer_tours'));
    }
}
