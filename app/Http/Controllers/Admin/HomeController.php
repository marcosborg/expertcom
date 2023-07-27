<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLaunch;
use App\Models\TvdeActivity;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {

        $tvde_week_id = 2;
        $driver_id = 4;
        $bolt_tvde_operator_id = 1;
        $uber_tvde_operator_id = 2;

        $bolt_activities = TvdeActivity::where([
            'tvde_week_id' => $tvde_week_id,
            'tvde_operator_id' => $bolt_tvde_operator_id
        ])
            ->get();

        $uber_activities = TvdeActivity::where([
            'tvde_week_id' => $tvde_week_id,
            'tvde_operator_id' => $uber_tvde_operator_id
        ])
            ->get();

        return view('home', compact([
            'bolt_activities',
            'uber_activities'
        ]));
    }

    public function selectCompany($company_id)
    {
        session()->put('company_id', $company_id);
    }
}