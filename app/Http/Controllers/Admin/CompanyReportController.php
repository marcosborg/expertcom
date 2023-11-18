<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvdeMonth;
use App\Models\TvdeWeek;
use App\Models\TvdeYear;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\Reports;

class CompanyReportController extends Controller
{

    use Reports;

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

        $results = $this->getWeekReport($company_id, $tvde_week_id);

        return view('admin.companyReports.index')->with([
            'company_id' => $company_id,
            'tvde_years' => $tvde_years,
            'tvde_year_id' => $tvde_year_id,
            'tvde_months' => $tvde_months,
            'tvde_month_id' => $tvde_month_id,
            'tvde_weeks' => $tvde_weeks,
            'tvde_week_id' => $tvde_week_id,
            'drivers' => $results['drivers'],
            'totals' => $results['totals']
        ]);

    }

}
