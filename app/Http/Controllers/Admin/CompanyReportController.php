<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adjustment;
use App\Models\Card;
use App\Models\CombustionTransaction;
use App\Models\CompanyExpense;
use App\Models\ContractTypeRank;
use App\Models\Driver;
use App\Models\Electric;
use App\Models\ElectricTransaction;
use App\Models\TvdeActivity;
use App\Models\TvdeMonth;
use App\Models\TvdeWeek;
use App\Models\TvdeYear;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyReportController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('company_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company_id = session()->get('company_id') ?? $company_id = session()->get('company_id');

        // START FILTER

        $tvde_year_id = session()->get('tvde_year_id') ? session()->get('tvde_year_id') : $tvde_year_id = TvdeYear::orderBy('name')->first()->id;
        if (session()->has('tvde_month_id')) {
            $tvde_month_id = session()->get('tvde_month_id');
        } else {
            $tvde_month = TvdeMonth::orderBy('number', 'desc')
                ->whereHas('weeks', function ($week) use ($company_id) {
                    $week->whereHas('tvdeActivities', function ($tvdeActivity) use ($company_id) {
                        $tvdeActivity->where('company_id', $company_id);
                    });
                })
                ->where('year_id', $tvde_year_id)
                ->first();
            if ($tvde_month) {
                $tvde_month_id = $tvde_month->id;
            } else {
                $tvde_month_id = 0;
            }
        }
        if (session()->has('tvde_week_id')) {
            $tvde_week_id = session()->get('tvde_week_id');
        } else {
            $tvde_week = TvdeWeek::orderBy('number', 'desc')->where('tvde_month_id', $tvde_month_id)->first();
            if ($tvde_week) {
                $tvde_week_id = $tvde_week->id;
                session()->put('tvde_week_id', $tvde_week->id);
            } else {
                $tvde_week_id = 1;
            }
        }

        $tvde_years = TvdeYear::orderBy('name')
            ->whereHas('months', function ($month) use ($company_id) {
                $month->whereHas('weeks', function ($week) use ($company_id) {
                    $week->whereHas('tvdeActivities', function ($tvdeActivity) use ($company_id) {
                        $tvdeActivity->where('company_id', $company_id);
                    });
                });
            })
            ->get();
        $tvde_months = TvdeMonth::orderBy('number', 'asc')
            ->whereHas('weeks', function ($week) use ($company_id) {
                $week->whereHas('tvdeActivities', function ($tvdeActivity) use ($company_id) {
                    $tvdeActivity->where('company_id', $company_id);
                });
            })
            ->where('year_id', $tvde_year_id)->get();

        $tvde_weeks = TvdeWeek::orderBy('number', 'asc')
            ->whereHas('tvdeActivities', function ($tvdeActivity) use ($company_id) {
                $tvdeActivity->where('company_id', $company_id);
            })
            ->where('tvde_month_id', $tvde_month_id)->get();

        // END FILTER

        $tvde_week = TvdeWeek::find($tvde_week_id);

        $drivers = Driver::where('company_id', $company_id)
            ->where('state_id', 1)
            ->orderBy('name')
            ->get()
            ->load([
                'contract_vat',
                'card',
                'electric'
            ]);

        $total_uber = [];
        $total_bolt = [];
        $total_operators = [];
        $total_earnings_after_discount = [];
        $total_tips_after_discount = [];
        $total_fuel_transactions = [];
        $total_adjustments = [];
        $total_fleet_management = [];
        $total_drivers = [];

        foreach ($drivers as $driver) {
            $uber_activities = TvdeActivity::where([
                'company_id' => $company_id,
                'tvde_operator_id' => 1,
                'tvde_week_id' => $tvde_week_id,
                'driver_code' => $driver->uber_uuid
            ])
                ->get();

            $uber_total_earnings = $uber_activities->sum('earnings_two');
            $uber_tips = $uber_activities->sum('earnings_one');
            $uber_earnings = $uber_total_earnings - $uber_tips;

            $bolt_activities = TvdeActivity::where([
                'company_id' => $company_id,
                'tvde_operator_id' => 2,
                'tvde_week_id' => $tvde_week_id,
                'driver_code' => $driver->bolt_name
            ])
                ->get();

            $bolt_total_earnings = $bolt_activities->sum('earnings_two');
            $bolt_tips = $bolt_activities->sum('earnings_one');
            $bolt_earnings = $bolt_total_earnings - $bolt_tips;

            if ($bolt_total_earnings > 0 || $uber_total_earnings > 0) {

                //EARNINGS

                $uber = collect([
                    'total_earnings' => $uber_total_earnings,
                    'tips' => $uber_tips,
                    'earnings' => $uber_earnings
                ]);

                $bolt = collect([
                    'total_earnings' => $bolt_total_earnings,
                    'tips' => $bolt_tips,
                    'earnings' => $bolt_earnings
                ]);

                $total_earnings = $bolt_total_earnings + $uber_total_earnings;
                $total_earnings_no_tips = $uber_earnings + $bolt_earnings;
                $total_tips = $uber_tips + $bolt_tips;

                //DISCOUNT

                $contract_type_rank = ContractTypeRank::where([
                    'contract_type_id' => $driver->contract_type_id
                ])
                    ->where('from', '<=', $total_earnings_no_tips)
                    ->where('to', '>=', $total_earnings_no_tips)
                    ->first();

                if ($contract_type_rank) {
                    $percent = $contract_type_rank->percent;
                } else {
                    $percent = 0;
                }

                $earnings_after_discount = ($total_earnings_no_tips * $percent) / 100;

                $tips_after_discount = ($total_tips * (100 - $driver->contract_vat->tips)) / 100;

                //FUEL

                $fuel_transactions = 0;

                if ($driver->electric) {
                    $electric_transactions = ElectricTransaction::where([
                        'tvde_week_id' => $tvde_week_id,
                        'card' => $driver->electric->code
                    ])
                        ->sum('total');

                    if ($electric_transactions > 0) {
                        $fuel_transactions = $electric_transactions;
                    }
                }

                if ($driver->card) {
                    $combustion_transactions = CombustionTransaction::where([
                        'tvde_week_id' => $tvde_week_id,
                        'card' => $driver->card->code
                    ])
                        ->sum('total');

                    if ($combustion_transactions > 0) {
                        $fuel_transactions = $combustion_transactions;
                    }
                }

                $driver->fuel = $fuel_transactions;

                $total_fuel_transactions[] = $fuel_transactions;

                //ADJUSTMENTS
                $adjustments = Adjustment::whereHas('drivers', function ($query) use ($driver) {
                    $query->where('id', $driver->id);
                })
                    ->where('company_id', $company_id)
                    ->where(function ($query) use ($tvde_week) {
                        $query->where('start_date', '<=', $tvde_week->start_date)
                            ->orWhereNull('start_date');
                    })
                    ->where(function ($query) use ($tvde_week) {
                        $query->where('end_date', '>=', $tvde_week->end_date)
                            ->orWhereNull('end_date');
                    })
                    ->get();

                $refunds = [];
                $deducts = [];
                $fleet_management = [];

                foreach ($adjustments as $adjustment) {
                    if ($adjustment->type == 'deduct') {
                        if ($adjustment->fleet_management) {
                            $fleet_management[] = $adjustment->amount;
                        } else {
                            $deducts[] = $adjustment->amount;
                        }
                    } else {
                        if ($adjustment->fleet_management) {
                            $fleet_management[] = (- $adjustment->amount);
                        } else {
                            $refunds[] = $adjustment->amount;
                        }
                    }
                }

                $refunds = array_sum($refunds);
                $deducts = array_sum($deducts);
                $adjustments = $refunds - $deducts;

                $total_adjustments[] = $adjustments;

                $fleet_management = array_sum($fleet_management);

                $total_fleet_management[] = $fleet_management;

                $earnings = collect([
                    'uber' => $uber,
                    'bolt' => $bolt,
                    'total' => $total_earnings,
                    'total_tips' => $total_tips,
                    'percent' => $contract_type_rank->percent ?? 0,
                    'tips_percent' => $driver->contract_vat->tips,
                    'total_no_tips' => $total_earnings_no_tips,
                    'earnings_after_discount' => $earnings_after_discount,
                    'tips_after_discount' => $tips_after_discount,
                ]);

                $driver->earnings = $earnings;
                $driver->refunds = $refunds;
                $driver->adjustments = $adjustments;
                $driver->fleet_management = $fleet_management;

                $driver->total = $earnings_after_discount + $tips_after_discount - $fuel_transactions + $adjustments - $fleet_management;

                $total_uber[] = $uber_total_earnings;
                $total_bolt[] = $bolt_total_earnings;
                $total_operators[] = $total_earnings;
                $total_earnings_after_discount[] = $earnings_after_discount;
                $total_tips_after_discount[] = $tips_after_discount;
                $total_drivers[] = $driver->total;

            }

        }

        $totals = collect([
            'total_uber' => array_sum($total_uber),
            'total_bolt' => array_sum($total_bolt),
            'total_operators' => array_sum($total_operators),
            'total_earnings_after_discount' => array_sum($total_earnings_after_discount),
            'total_tips_after_discount' => array_sum($total_tips_after_discount),
            'total_fuel_transactions' => array_sum($total_fuel_transactions),
            'total_adjustments' => array_sum($total_adjustments),
            'total_fleet_management' => array_sum($total_fleet_management),
            'total_drivers' => array_sum($total_drivers),
        ]);

        return view('admin.companyReports.index', compact([
            'company_id',
            'tvde_years',
            'tvde_year_id',
            'tvde_months',
            'tvde_month_id',
            'tvde_weeks',
            'tvde_week_id',
            'drivers',
            'totals'
        ]));

    }

}
