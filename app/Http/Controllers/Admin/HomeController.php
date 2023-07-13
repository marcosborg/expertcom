<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLaunch;
use App\Models\Driver;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {
        return view('home');
    }

    public function selectCompany($company_id)
    {
        session()->put('company_id', $company_id);
    }
}