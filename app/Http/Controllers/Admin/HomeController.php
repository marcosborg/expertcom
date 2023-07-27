<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLaunch;
use App\Models\Adjustment;
use App\Models\ContractTypeRank;
use App\Models\Driver;
use App\Models\TvdeActivity;
use App\Models\TvdeWeek;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {

        $tvde_week_id = 2;
        $driver_id = 1;
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

        $tvde_weeks = TvdeWeek::all();
        $drivers = Driver::all();

        $tvde_week = TvdeWeek::find($tvde_week_id);

        $driver = Driver::find($driver_id)
            ->load([
                'contract_type',
                'contract_vat'
            ]);

        $adjustments = Adjustment::whereHas('drivers', function ($query) use ($driver_id) {
            $query->where('id', $driver_id);
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

        $total_earnings_bolt = number_format($bolt_activities->sum('earnings_two'), 2);
        $total_tips_bolt = number_format($bolt_activities->sum('earnings_one'), 2);
        $total_earnings_uber = number_format($uber_activities->sum('earnings_two'), 2);
        $total_tips_uber = number_format($uber_activities->sum('earnings_one'), 2);
        $total_tips = $total_tips_uber + $total_tips_bolt;
        $total = $total_earnings_bolt + $total_earnings_uber;

        //CHECK PERCENT
        $contract_type_ranks = ContractTypeRank::where('contract_type_id', $driver->contract_type_id)->get();
        $contract_type_rank = $contract_type_ranks[0];
        foreach ($contract_type_ranks as $value) {
            if ($value->from <= $total && $value->to >= $total) {
                $contract_type_rank = $value;
            }
        }
        //

        $total_bolt = number_format($total_earnings_bolt * ($contract_type_rank->percent / 100), 2);
        $total_uber = number_format($total_earnings_uber * ($contract_type_rank->percent / 100), 2);

        $bolt_tip_percent = 100 - $driver->contract_vat->tips;
        $uber_tip_percent = 100 - $driver->contract_vat->tips;

        $bolt_tip_after_vat = number_format($total_tips_bolt * ($bolt_tip_percent / 100), 2);
        $uber_tip_after_vat = number_format($total_tips_uber * ($uber_tip_percent / 100), 2);

        $total_tip_after_vat = $bolt_tip_after_vat + $uber_tip_after_vat;

        return view('home', compact([
            'tvde_weeks',
            'drivers',
            'adjustments',
            'tvde_week',
            'total_earnings_bolt',
            'total_tips_bolt',
            'total_earnings_uber',
            'total_tips_uber',
            'total_tips',
            'driver',
            'contract_type_rank',
            'total_bolt',
            'total_uber',
            'bolt_tip_percent',
            'uber_tip_percent',
            'bolt_tip_after_vat',
            'uber_tip_after_vat',
            'total_tip_after_vat'
        ]));
    }

    public function selectCompany($company_id)
    {
        session()->put('company_id', $company_id);
    }
}