<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adjustment;
use App\Models\ContractTypeRank;
use App\Models\Driver;
use App\Models\TvdeActivity;
use App\Models\TvdeMonth;
use App\Models\TvdeWeek;
use App\Models\TvdeYear;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class FinancialStatementController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('financial_statement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //MANAGE SESSION

        $company_id = session()->get('company_id') ?? $company_id = session()->get('company_id');
        $tvde_year_id = session()->get('tvde_year_id') ? session()->get('tvde_year_id') : $tvde_year_id = TvdeYear::orderBy('name')->first()->id;
        $tvde_month_id = session()->get('tvde_month_id') ? session()->get('tvde_month_id') : $tvde_month_id = TvdeMonth::orderBy('number', 'desc')->where('year_id', $tvde_year_id)->first()->id;
        $tvde_week_id = session()->get('tvde_week_id') ? session()->get('tvde_week_id') : $tvde_week_id = TvdeWeek::orderBy('number', 'desc')->where('tvde_month_id', $tvde_month_id)->first()->id;
        $driver_id = session()->get('driver_id') ? session()->get('driver_id') : $driver_id = 0;

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

        $drivers = Driver::where('company_id', $company_id)->get();
        if ($driver_id != 0) {
            $driver = Driver::find($driver_id)->load([
                'contract_type',
                'contract_vat'
            ]);
        } else {
            $driver = null;
        }

        $tvde_week = TvdeWeek::find($tvde_week_id);

        if ($driver_id == 0) {
            $bolt_activities = TvdeActivity::where([
                'tvde_week_id' => $tvde_week_id,
                'tvde_operator_id' => 1,
                'company_id' => $company_id,
            ])
                ->get();

            $uber_activities = TvdeActivity::where([
                'tvde_week_id' => $tvde_week_id,
                'tvde_operator_id' => 2,
                'company_id' => $company_id,
            ])
                ->get();
        } else {
            $bolt_activities = TvdeActivity::where([
                'tvde_week_id' => $tvde_week_id,
                'tvde_operator_id' => 1,
                'driver_code' => $driver->bolt_name
            ])
                ->get();

            $uber_activities = TvdeActivity::where([
                'tvde_week_id' => $tvde_week_id,
                'tvde_operator_id' => 2,
                'driver_code' => $driver->uber_uuid
            ])
                ->get();
        }

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
            ->get();

        $refund = 0;
        $deduct = 0;
        foreach ($adjustments as $adjustment) {
            switch ($adjustment->type) {
                case 'refund':
                    $refund = $refund + $adjustment->amount;
                    break;
                case 'deduct':
                    $deduct = $deduct + $adjustment->amount;
                    break;
            }
        }

        $total_earnings_bolt = number_format($bolt_activities->sum('earnings_two'), 2);
        $total_tips_bolt = number_format($bolt_activities->sum('earnings_one'), 2);
        $total_earnings_uber = number_format($uber_activities->sum('earnings_two'), 2);
        $total_tips_uber = number_format($uber_activities->sum('earnings_one'), 2);
        $total_tips = $total_tips_uber + $total_tips_bolt;
        $total_earnings = $total_earnings_bolt + $total_earnings_uber;

        //CHECK PERCENT
        $contract_type_ranks = ContractTypeRank::where('contract_type_id', $driver->contract_type_id)->get();
        $contract_type_rank = $contract_type_ranks[0];
        foreach ($contract_type_ranks as $value) {
            if ($value->from <= $total_earnings && $value->to >= $total_earnings) {
                $contract_type_rank = $value;
            }
        }
        //

        $total_bolt = number_format($total_earnings_bolt * ($contract_type_rank->percent / 100), 2);
        $total_uber = number_format($total_earnings_uber * ($contract_type_rank->percent / 100), 2);

        $total_earnings_after_vat = $total_bolt + $total_uber;

        $bolt_tip_percent = 100 - $driver->contract_vat->tips;
        $uber_tip_percent = 100 - $driver->contract_vat->tips;

        $bolt_tip_after_vat = number_format($total_tips_bolt * ($bolt_tip_percent / 100), 2);
        $uber_tip_after_vat = number_format($total_tips_uber * ($uber_tip_percent / 100), 2);

        $total_tip_after_vat = $bolt_tip_after_vat + $uber_tip_after_vat;

        $total = $total_earnings + $total_tips;
        $total_after_vat = $total_earnings_after_vat + $total_tip_after_vat;

        $gross_credits = $total + $refund;
        $gross_debts = ($total_earnings - $total_after_vat) + ($total_tips - $total_tip_after_vat) + $deduct;
        $final_total = $gross_credits - $gross_debts;

        return view('admin.financialStatements.index', compact([
            'company_id',
            'tvde_year_id',
            'tvde_years',
            'tvde_months',
            'tvde_month_id',
            'tvde_weeks',
            'tvde_week_id',
            'drivers',
            'driver_id',
            'bolt_activities',
            'uber_activities',
            'total_earnings_uber',
            'contract_type_rank',
            'total_uber',
            'total_earnings_bolt',
            'total_bolt',
            'total_tips_uber',
            'uber_tip_percent',
            'uber_tip_after_vat',
            'total_tips_bolt',
            'bolt_tip_percent',
            'bolt_tip_after_vat',
            'total_tips',
            'total_tip_after_vat',
            'adjustments',
            'total_earnings',
            'total',
            'total_after_vat',
            'gross_credits',
            'gross_debts',
            'final_total'
        ]));
    }

    public function year($tvde_year_id)
    {
        session()->put('tvde_year_id', $tvde_year_id);
        session()->put('tvde_month_id', TvdeMonth::orderBy('number', 'desc')->where('year_id', session()->get('tvde_year_id'))->first()->id);
        session()->put('tvde_week_id', TvdeWeek::orderBy('number', 'desc')->where('tvde_month_id', session()->get('tvde_month_id'))->first()->id);
        return back();
    }

    public function month($tvde_month_id)
    {
        session()->put('tvde_month_id', $tvde_month_id);
        session()->put('tvde_week_id', TvdeWeek::orderBy('number', 'desc')->where('tvde_month_id', $tvde_month_id)->first()->id);
        return back();
    }

    public function week($tvde_week_id)
    {
        session()->put('tvde_week_id', $tvde_week_id);
        return back();
    }

    public function driver($driver_id)
    {
        session()->put('driver_id', $driver_id);
        return back();
    }

    public function pdf(Request $request)
    {
        abort_if(Gate::denies('financial_statement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pdf = Pdf::loadView('admin.financialStatements.pdf', [

        ])->setOption([
                    'isRemoteEnabled' => true,
                ]);

        if ($request->stream) {
            return $pdf->stream();
        } else {
            return $pdf->download('name_of_file' . '.pdf');
        }

    }

}