<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWeeklyExpenseRequest;
use App\Http\Requests\StoreWeeklyExpenseRequest;
use App\Http\Requests\UpdateWeeklyExpenseRequest;
use App\Models\Company;
use App\Models\TvdeWeek;
use App\Models\WeeklyExpense;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WeeklyExpenseController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('weekly_expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WeeklyExpense::with(['company', 'tvde_week'])->select(sprintf('%s.*', (new WeeklyExpense)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'weekly_expense_show';
                $editGate      = 'weekly_expense_edit';
                $deleteGate    = 'weekly_expense_delete';
                $crudRoutePart = 'weekly-expenses';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('company_name', function ($row) {
                return $row->company ? $row->company->name : '';
            });

            $table->addColumn('tvde_week_start_date', function ($row) {
                return $row->tvde_week ? $row->tvde_week->start_date : '';
            });

            $table->editColumn('expenses', function ($row) {
                return $row->expenses ? $row->expenses : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'company', 'tvde_week']);

            return $table->make(true);
        }

        return view('admin.weeklyExpenses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('weekly_expense_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tvde_weeks = TvdeWeek::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.weeklyExpenses.create', compact('companies', 'tvde_weeks'));
    }

    public function store(StoreWeeklyExpenseRequest $request)
    {
        $weeklyExpense = WeeklyExpense::create($request->all());

        return redirect()->route('admin.weekly-expenses.index');
    }

    public function edit(WeeklyExpense $weeklyExpense)
    {
        abort_if(Gate::denies('weekly_expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tvde_weeks = TvdeWeek::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $weeklyExpense->load('company', 'tvde_week');

        return view('admin.weeklyExpenses.edit', compact('companies', 'tvde_weeks', 'weeklyExpense'));
    }

    public function update(UpdateWeeklyExpenseRequest $request, WeeklyExpense $weeklyExpense)
    {
        $weeklyExpense->update($request->all());

        return redirect()->route('admin.weekly-expenses.index');
    }

    public function show(WeeklyExpense $weeklyExpense)
    {
        abort_if(Gate::denies('weekly_expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weeklyExpense->load('company', 'tvde_week');

        return view('admin.weeklyExpenses.show', compact('weeklyExpense'));
    }

    public function destroy(WeeklyExpense $weeklyExpense)
    {
        abort_if(Gate::denies('weekly_expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weeklyExpense->delete();

        return back();
    }

    public function massDestroy(MassDestroyWeeklyExpenseRequest $request)
    {
        $weeklyExpenses = WeeklyExpense::find(request('ids'));

        foreach ($weeklyExpenses as $weeklyExpense) {
            $weeklyExpense->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
