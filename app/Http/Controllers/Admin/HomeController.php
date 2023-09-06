<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        return view('home');
    }

    public function selectCompany($company_id)
    {
        session()->forget('driver_id');
        session()->put('company_id', $company_id);
    }
}