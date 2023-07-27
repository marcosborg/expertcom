<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLaunch;
use App\Models\Adjustment;
use App\Models\TvdeActivity;
use App\Models\TvdeWeek;
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

        $tvde_week = TvdeWeek::find($tvde_week_id);

        $adjustments = Adjustment::whereHas('drivers', function ($driver) use ($driver_id) {
            $driver->where('id', $driver_id);
        })
            ->where(function ($query) use ($tvde_week) {
                $query->where('start_date', '<=', $tvde_week->start_date)
                    ->orWhereNull('start_date');
            })
            ->where(function ($query) use ($tvde_week) {
                $query->where('end_date', '>=', $tvde_week->end_date)
                    ->orWhereNull('end_date');
            })
            ->get()->load([
                    'drivers'
                ]);

        return view('home', compact([
            'bolt_activities',
            'uber_activities',
            'adjustments',
            'tvde_week'
        ]));
    }

    public function selectCompany($company_id)
    {
        session()->put('company_id', $company_id);
    }
}