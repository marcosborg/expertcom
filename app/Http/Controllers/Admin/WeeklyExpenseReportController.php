<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Reports;
use App\Models\CompanyExpense;
use App\Models\Driver;
use App\Models\TvdeWeek;
use App\Models\CompanyPark;
use App\Models\Company;
use App\Models\Consultancy;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CurrentAccount;
use App\Models\TvdeActivity;

class WeeklyExpenseReportController extends Controller
{

    use Reports;

    public function index()
    {
        abort_if(Gate::denies('weekly_expense_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->hasRole('Empresas Associadas')) {
            $user = auth()->user()->load('company');
            $company_id = $user->company->id;
            session()->put('company_id', $company_id);
        }

        $filter = $this->filter();
        $company_id = $filter['company_id'];
        $tvde_week_id = $filter['tvde_week_id'];
        $tvde_week = $filter['tvde_week'];
        $tvde_years = $filter['tvde_years'];
        $tvde_year_id = $filter['tvde_year_id'];
        $tvde_months = $filter['tvde_months'];
        $tvde_month_id = $filter['tvde_month_id'];
        $tvde_weeks = $filter['tvde_weeks'];

        //COMPANY EXPENSES

        $now = Carbon::now()->format('Y-m-d');

        $company_expenses = CompanyExpense::where([
            'company_id' => $company_id,
        ])
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get();

        $company_expenses = $company_expenses->map(function ($expense) {
            $expense->total = $expense->qty * $expense->weekly_value;
            return $expense;
        });

        $total_company_expenses = [];

        foreach ($company_expenses as $company_expense) {
            $total_company_expenses[] = $company_expense->total;
        }

        $total_company_expenses = array_sum($total_company_expenses);

        $company_park = CompanyPark::where('tvde_week_id', $tvde_week_id)
            ->where('company_id', $company_id)
            ->sum('value');

        $consultancy = Consultancy::where('company_id', $company_id)
            ->where('start_date', '<=', $tvde_week->start_date)
            ->where('end_date', '>=', $tvde_week->end_date)
            ->first();

        $totals = $this->getWeekReport($company_id, $tvde_week_id)['totals'];

        $company = Company::find($company_id);

        $total_consultancy = 0;

        if ($consultancy && !$company->main) {

            $total_consultancy = ($totals['total_operators'] * $consultancy->value) / 100;

        }

        //GET EARNINGS FROM OTHER COMPANIES

        $fleet_adjusments = 0;
        $fleet_consultancies = 0;
        $fleet_company_parks = 0;
        $fleet_earnings = 0;

        if ($company && $company->main) {

            $current_accounts = CurrentAccount::where([
                'tvde_week_id' => $tvde_week_id
            ])->get();
            $fleet_adjusments = [];
            foreach ($current_accounts as $current_account) {
                $data = json_decode($current_account->data);
                foreach ($data->adjustments as $fleet_adjusment) {
                    if ($fleet_adjusment->fleet_management) {
                        $fleet_adjusments[] = $fleet_adjusment->amount;
                    }
                }
            }

            $fleet_adjusments = array_sum($fleet_adjusments);

            $companies = Company::whereHas('tvde_activities', function ($tvde_activity) use ($tvde_week_id) {
                $tvde_activity->where('tvde_week_id', $tvde_week_id);
            })
                ->get();

            $fleet_consultancies = [];

            foreach ($companies as $company) {
                $fleet_consultancy = Consultancy::where('company_id', $company->id)
                    ->where('start_date', '<=', $tvde_week->start_date)
                    ->where('end_date', '>=', $tvde_week->end_date)
                    ->first();
                $earnings = TvdeActivity::where([
                    'company_id' => $company->id,
                    'tvde_week_id' => $tvde_week_id,
                ])
                    ->sum('earnings_two');

                if ($fleet_consultancy && $fleet_consultancy->value && $earnings) {
                    $fleet_consultancies[] = ($earnings * $fleet_consultancy->value) / 100;
                }
            }

            $fleet_consultancies = array_sum($fleet_consultancies);

            $fleet_company_parks = CompanyPark::where([
                'tvde_week_id' => $tvde_week->id,
                'fleet_management' => true
            ])->sum('value');

            $fleet_earnings = $fleet_adjusments + $fleet_consultancies + $fleet_company_parks;
        }

        ////////////////////////////////

        $final_total = $total_company_expenses - $totals['total_company_adjustments'] + $company_park + $totals['total_drivers'] + $total_consultancy;
        $final_company_expenses = $total_company_expenses - $totals['total_company_adjustments'] + $company_park - $total_consultancy;

        $profit = $totals['total_operators'] - $final_total + $fleet_earnings + $fleet_earnings;

        if ($totals['total_operators'] > 0) {
            $roi = (($totals['total_operators'] - $final_total + $fleet_earnings) / $totals['total_operators']) * 100;
        } else {
            $roi = 0;
        }

        return view('admin.weeklyExpenseReports.index', compact([
            'company_id',
            'tvde_years',
            'tvde_year_id',
            'tvde_months',
            'tvde_month_id',
            'tvde_weeks',
            'tvde_week_id',
            'company_expenses',
            'total_company_expenses',
            'totals',
            'company_park',
            'final_total',
            'final_company_expenses',
            'profit',
            'roi',
            'total_consultancy',
            'fleet_adjusments',
            'fleet_consultancies',
            'fleet_company_parks',
            'fleet_earnings'
        ]));
    }

    public function pdf(Request $request)
    {
        $company_id = session()->get('company_id') ?? $company_id = session()->get('company_id');
        $tvde_week_id = session()->get('tvde_week_id');

        $drivers = Driver::where('company_id', $company_id)->get();

        $tvde_week = TvdeWeek::find($tvde_week_id);

        //COMPANY EXPENSES

        $now = Carbon::now()->format('Y-m-d');

        $company_expenses = CompanyExpense::where([
            'company_id' => $company_id,
        ])
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get();

        $company_expenses = $company_expenses->map(function ($expense) {
            $expense->total = $expense->qty * $expense->weekly_value;
            return $expense;
        });

        $total_company_expenses = [];

        foreach ($company_expenses as $company_expense) {
            $total_company_expenses[] = $company_expense->total;
        }

        $total_company_expenses = array_sum($total_company_expenses);

        $company_park = CompanyPark::where('tvde_week_id', $tvde_week_id)
            ->where('company_id', $company_id)
            ->sum('value');

        $consultancy = Consultancy::where('company_id', $company_id)
            ->where('start_date', '<=', $tvde_week->start_date)
            ->where('end_date', '>=', $tvde_week->end_date)
            ->first();

        $totals = $this->getWeekReport($company_id, $tvde_week_id)['totals'];

        $company = Company::find($company_id);

        $total_consultancy = 0;

        if ($consultancy && !$company->main) {

            $total_consultancy = ($totals['total_operators'] * $consultancy->value) / 100;

        }

        $final_total = $total_company_expenses - $totals['total_company_adjustments'] + $company_park + $totals['total_drivers'] + $total_consultancy;
        $final_company_expenses = $total_company_expenses - $totals['total_company_adjustments'] + $company_park - $total_consultancy;
        $profit = $totals['total_operators'] - $final_total;

        if ($totals['total_operators'] > 0) {
            $roi = (($totals['total_operators'] - $final_total) / $totals['total_operators']) * 100;
        } else {
            $roi = 0;
        }

        //HEADER
        $main_company = Company::where('main', true)->first();
        //

        //GRÁFICOS
        $chart1 = 'https://quickchart.io/chart/render/zm-8d666b59-11bf-49f1-8455-a264899a3611?data1=' . round($totals['total_operators']) . ',' . round($final_total, 2) . ',' . round($profit) . '';
        //$chart2 = 'https://quickchart.io/chart/render/sf-9970a21b-53f3-4f4f-b4e9-ea355f70f7ab?data1=' . round($total_company_expenses) . ',' . round(-$totals['total_company_adjustments']) . ',' . round($company_park) . ',' . round($total_consultancy) . ',' . round($totals['total_drivers']) . '';
        //

        /*
        
        return view('admin.weeklyExpenseReports.pdf', compact([
            'company_id',
            'tvde_week_id',
            'company_expenses',
            'totals',
            'company_park',
            'final_total',
            'final_company_expenses',
            'profit',
            'roi',
            'total_consultancy',
            'main_company',
            'company',
            'tvde_week',
            'chart1',            
        ]));

        */

        $pdf = Pdf::loadView('admin.weeklyExpenseReports.pdf', [
            'company_id' => $company_id,
            'tvde_week_id' => $tvde_week_id,
            'company_expenses' => $company_expenses,
            'totals' => $totals,
            'company_park' => $company_park,
            'final_total' => $final_total,
            'final_company_expenses' => $final_company_expenses,
            'profit' => $profit,
            'roi' => $roi,
            'total_consultancy' => $total_consultancy,
            'main_company' => $main_company,
            'company' => $company,
            'tvde_week' => $tvde_week,
            'chart1' => $chart1,
        ])->setOption([
                    'isRemoteEnabled' => true,
                ]);


        if ($request->download) {

            $filename = strtolower(str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-]/', '', $company->name . '-' . $tvde_week->start_date))) . '.pdf';

            return $pdf->download($filename);
        } else {
            return $pdf->stream();
        }

    }

}
