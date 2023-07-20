<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLaunch;
use App\Models\Driver;
use App\Models\TvdeActivity;
use App\Models\TvdeWeek;
use App\Models\TvdeYear;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {

        $years = TvdeYear::all()->load('months.weeks');

        $driver = Driver::find(4);

        $week = TvdeWeek::orderBy('id', 'desc')->first();

        $uber_tvde_activities = TvdeActivity::where([
            'tvde_operator_id' => 2,
            'driver_code' => $driver->uber_uuid,
            'tvde_week_id' => 2
        ])->get();

        $bolt_tvde_activities = TvdeActivity::where([
            'tvde_operator_id' => 1,
            'driver_code' => $driver->bolt_name,
            'tvde_week_id' => 2
        ])->get();

        return view('home', compact('years', 'uber_tvde_activities', 'bolt_tvde_activities', 'driver'));
    }

    public function selectCompany($company_id)
    {
        session()->put('company_id', $company_id);
    }
}