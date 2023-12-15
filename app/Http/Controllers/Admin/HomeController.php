<?php

namespace App\Http\Controllers\Admin;

use App\Models\Driver;
use App\Models\TvdeActivity;
use App\Http\Controllers\Traits\Reports;
use App\Models\CurrentAccount;
use App\Models\DriversBalance;

class HomeController
{

    use Reports;

    public function index()
    {

        if (auth()->user()->hasRole('Driver') && auth()->user()->driver->count() > 0) {
            $user = auth()->user()->load('driver');
            session()->put('driver_id', $user->driver[0]->id);
            session()->put('company_id', $user->driver[0]->company_id);
        }

        $driver_id = session()->get('driver_id') ? session()->get('driver_id') : $driver_id = 0;

        $filter = $this->filter();
        $company_id = $filter['company_id'];
        $tvde_week_id = $filter['tvde_week_id'];
        $tvde_week = $filter['tvde_week'];
        $tvde_years = $filter['tvde_years'];
        $tvde_year_id = $filter['tvde_year_id'];
        $tvde_months = $filter['tvde_months'];
        $tvde_month_id = $filter['tvde_month_id'];
        $tvde_weeks = $filter['tvde_weeks'];

        $drivers = Driver::where('company_id', $company_id)
            ->where('state_id', 1)
            ->get();
            
        if ($driver_id != 0) {
            $driver = Driver::find($driver_id)->load([
                'contract_type',
                'contract_vat'
            ]);
        } else {
            $driver = null;
        }

        $results = CurrentAccount::where([
            'tvde_week_id' => $tvde_week_id,
            'driver_id' => $driver_id
        ])->first();

        if ($results) {
            $results = json_decode($results->data);
        }

        //GRAFICOS

        $team_earnings = collect();

        foreach ($drivers as $key => $d) {
            $team_driver_bolt_earnings = TvdeActivity::where([
                'tvde_week_id' => $tvde_week_id,
                'tvde_operator_id' => 2,
                'driver_code' => $d->bolt_name
            ])
                ->get()->sum('earnings_two');

            $team_driver_uber_earnings = TvdeActivity::where([
                'tvde_week_id' => $tvde_week_id,
                'tvde_operator_id' => 1,
                'driver_code' => $d->uber_uuid
            ])
                ->get()->sum('earnings_two');

            $team_driver_earnings = $team_driver_bolt_earnings + $team_driver_uber_earnings;
            if ($driver) {
                $entry = collect([
                    'driver' => $driver->uber_uuid == $d->uber_uuid || $driver->bolt_name == $d->bolt_name ? $driver->name : 'Motorista ' . $key + 1,
                    'earnings' => sprintf("%.2f", $team_driver_earnings),
                    'own' => $driver->uber_uuid == $d->uber_uuid || $driver->bolt_name == $d->bolt_name
                ]);
                $team_earnings->add($entry);
            }
        }

        $driver_balance = DriversBalance::where([
            'driver_id' => $driver_id,
            'tvde_week_id' => $tvde_week_id
        ])->first();

        return view('home')->with([
            'company_id' => $company_id,
            'tvde_year_id' => $tvde_year_id,
            'tvde_years' => $tvde_years,
            'tvde_months' => $tvde_months,
            'tvde_month_id' => $tvde_month_id,
            'tvde_weeks' => $tvde_weeks,
            'tvde_week_id' => $tvde_week_id,
            'drivers' => $drivers,
            'driver_id' => $results ? $results->driver_id : 0,
            'total_earnings_uber' => $results ? $results->total_earnings_uber : 0,
            'contract_type_rank' => $results ? $results->contract_type_rank : 0,
            'total_uber' => $results ? $results->total_uber : 0,
            'total_earnings_bolt' => $results ? $results->total_earnings_bolt : 0,
            'total_bolt' => $results ? $results->total_bolt : 0,
            'total_tips_uber' => $results ? $results->total_tips_uber : 0,
            'uber_tip_percent' => $results ? $results->uber_tip_percent : 0,
            'uber_tip_after_vat' => $results ? $results->uber_tip_after_vat : 0,
            'total_tips_bolt' => $results ? $results->total_tips_bolt : 0,
            'bolt_tip_percent' => $results ? $results->bolt_tip_percent : 0,
            'bolt_tip_after_vat' => $results ? $results->bolt_tip_after_vat : 0,
            'total_tips' => $results ? $results->total_tips : 0,
            'total_tip_after_vat' => $results ? $results->total_tip_after_vat : 0,
            'adjustments' => $results ? $results->adjustments : 0,
            'total_earnings' => $results ? $results->total_earnings : 0,
            'total_earnings_no_tip' => $results ? $results->total_earnings_no_tip : 0,
            'total' => $results ? $results->total : 0,
            'total_after_vat' => $results ? $results->total_after_vat : 0,
            'gross_credits' => $results ? $results->gross_credits : 0,
            'gross_debts' => $results ? $results->gross_debts : 0,
            'final_total' => $results ? $results->final_total : 0,
            'driver' => $results ? $results->driver : null,
            'team_earnings' => $team_earnings,
            'electric_expenses' => $results ? $results->electric_expenses : 0,
            'combustion_expenses' => $results ? $results->combustion_expenses : 0,
            'combustion_racio' => $results ? $results->combustion_racio : 0,
            'electric_racio' => $results ? $results->electric_racio : 0,
            'total_earnings_after_vat' => $results ? $results->total_earnings_after_vat : 0,
            'txt_admin' => $results ? $results->txt_admin : 0,
            'driver_balance' => $driver_balance
        ]);
    }

    public function selectCompany($company_id)
    {
        session()->forget('driver_id');
        session()->put('company_id', $company_id);
    }
}