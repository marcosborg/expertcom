<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurrentAccount;
use App\Models\DriversBalance;
use App\Models\TvdeYear;
use App\Models\TvdeMonth;
use App\Models\TvdeWeek;

class PanelController extends Controller
{

    public function index(Request $request)
    {

        $user = auth()->user()->load([
            'driver.contract_type',
            'driver.contract_vat'
        ]);

        $driver = $user->driver[0];

        $filter = $this->filter($driver);

        $company_id = $filter['company_id'];
        $tvde_week_id = $filter['tvde_week_id'];
        $tvde_years = $filter['tvde_years'];
        $tvde_year_id = $filter['tvde_year_id'];
        $tvde_months = $filter['tvde_months'];
        $tvde_month_id = $filter['tvde_month_id'];
        $tvde_weeks = $filter['tvde_weeks'];
        $tvde_week_id = $filter['tvde_week_id'];

        if ($request->tvde_week_id) {
            $tvde_week_id = $request->tvde_week_id;
            $tvde_week = TvdeWeek::find($tvde_week_id)->load('tvde_month.year');
            $tvde_month_id = $tvde_week->tvde_month_id;
            $tvde_year_id = $tvde_week->tvde_month->year->id;
        }

        if ($request->tvde_month_id) {
            $tvde_month_id = $request->tvde_month_id;
            $tvde_month = TvdeMonth::find($tvde_month_id)->load('year', 'weeks');
            $tvde_year_id = $tvde_month->year_id;
            $tvde_weeks = TvdeWeek::where('tvde_month_id', $request->tvde_month_id)->get();
            $tvde_week_id = 0;
        }

        if ($request->tvde_year_id) {
            $tvde_year_id = $request->tvde_year_id;
            $tvde_months = TvdeMonth::where('year_id', $tvde_year_id)->get();
            $tvde_month_id = 0;
            $tvde_weeks = [];
            $tvde_week_id = 0;
        }

        $results = CurrentAccount::where([
            'tvde_week_id' => $tvde_week_id,
            'driver_id' => $driver->id
        ])->first();

        if ($results) {
            $results = json_decode($results->data);
        }

        $driver_balance = DriversBalance::where([
            'driver_id' => $driver->id,
            'tvde_week_id' => $tvde_week_id
        ])->first();

        return [
            'company_id' => $company_id,
            'tvde_year_id' => $tvde_year_id,
            'tvde_years' => $tvde_years,
            'tvde_months' => $tvde_months,
            'tvde_month_id' => $tvde_month_id,
            'tvde_weeks' => $tvde_weeks,
            'tvde_week_id' => $tvde_week_id,
            'tvde_month_id' => $tvde_month_id,
            'tvde_year_id' => $tvde_year_id,
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
            'electric_expenses' => $results ? $results->electric_expenses : 0,
            'combustion_expenses' => $results ? $results->combustion_expenses : 0,
            'combustion_racio' => $results ? $results->combustion_racio : 0,
            'electric_racio' => $results ? $results->electric_racio : 0,
            'total_earnings_after_vat' => $results ? $results->total_earnings_after_vat : 0,
            'txt_admin' => $results ? $results->txt_admin : 0,
            'driver_balance' => $driver_balance,
        ];
    }

    private function filter($driver)
    {
        $company_id = $driver->company_id;

        // Encontrar a última semana lançada com atividades para a empresa
        $lastWeek = TvdeWeek::whereHas('tvdeActivities', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })
            ->orderBy('start_date', 'desc')
            ->first();

        if ($lastWeek) {
            $tvde_week_id = $lastWeek->id;
            $tvde_month_id = $lastWeek->tvde_month_id;
            $tvde_month = $lastWeek->tvde_month;
            $tvde_year_id = $tvde_month ? $tvde_month->year_id : 0;
        } else {
            // fallback: não há semanas registadas → pega o ano e mês mais recentes disponíveis
            $latestMonth = TvdeMonth::orderBy('number', 'desc')->first();
            $tvde_month_id = $latestMonth ? $latestMonth->id : 0;
            $tvde_year_id = $latestMonth ? $latestMonth->year_id : 0;
            $tvde_week_id = 1; // ou null, dependendo do que fizer sentido no teu código
        }

        // Carregar listas para filtros, como no teu método original:
        $tvde_years = TvdeYear::orderBy('name')
            ->whereHas('months.weeks.tvdeActivities', function ($q) use ($company_id) {
                $q->where('company_id', $company_id);
            })
            ->get();

        $tvde_months = TvdeMonth::orderBy('number', 'asc')
            ->where('year_id', $tvde_year_id)
            ->whereHas('weeks.tvdeActivities', function ($q) use ($company_id) {
                $q->where('company_id', $company_id);
            })
            ->get();

        $tvde_weeks = TvdeWeek::orderBy('number', 'asc')
            ->where('tvde_month_id', $tvde_month_id)
            ->whereHas('tvdeActivities', function ($q) use ($company_id) {
                $q->where('company_id', $company_id);
            })
            ->get();

        $tvde_week = TvdeWeek::find($tvde_week_id);

        return [
            'company_id' => $company_id,
            'tvde_year_id' => $tvde_year_id,
            'tvde_years' => $tvde_years,
            'tvde_week_id' => $tvde_week_id,
            'tvde_week' => $tvde_week,
            'tvde_months' => $tvde_months,
            'tvde_month_id' => $tvde_month_id,
            'tvde_weeks' => $tvde_weeks,
        ];
    }
}
