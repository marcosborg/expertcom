<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyExpense;
use App\Models\TvdeWeek;
use App\Models\WeeklyExpense;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WeeklyExpenseInputController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('weekly_expense_input_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (session()->has('company_id') && session()->get('company_id') != 0) {
            $company_id = session()->get('company_id');
        } else {
            $company_id = 0;
        }

        if (session()->has('tvde_week_id')) {
            $tvde_week_id = session()->get('tvde_week_id');
        } else {
            $tvde_week_id = 0;
        }

        $tvde_weeks = TvdeWeek::all();

        $company_expenses = CompanyExpense::where([
            'company_id' => $company_id
        ])
            ->get();

        $weekly_expense = WeeklyExpense::where([
            'company_id' => $company_id,
            'tvde_week_id' => $tvde_week_id
        ])->first();

        return view(
            'admin.weeklyExpenseInputs.index',
            compact(
                'company_id',
                'company_expenses',
                'tvde_week_id',
                'tvde_weeks',
                'weekly_expense'
            )
        );
    }

}