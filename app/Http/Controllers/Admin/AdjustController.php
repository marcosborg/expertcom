<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAdjustRequest;
use App\Http\Requests\StoreAdjustRequest;
use App\Http\Requests\UpdateAdjustRequest;
use App\Models\Adjust;
use App\Models\Adjustment;
use App\Models\Driver;
use App\Models\TvdeWeek;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdjustController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('adjust_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adjusts = Adjust::with(['tvde_week', 'driver', 'adjustment'])->get();

        return view('admin.adjusts.index', compact('adjusts'));
    }

    public function create()
    {
        abort_if(Gate::denies('adjust_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tvde_weeks = TvdeWeek::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $adjustments = Adjustment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.adjusts.create', compact('adjustments', 'drivers', 'tvde_weeks'));
    }

    public function store(StoreAdjustRequest $request)
    {
        $adjust = Adjust::create($request->all());

        return redirect()->route('admin.adjusts.index');
    }

    public function edit(Adjust $adjust)
    {
        abort_if(Gate::denies('adjust_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tvde_weeks = TvdeWeek::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $adjustments = Adjustment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $adjust->load('tvde_week', 'driver', 'adjustment');

        return view('admin.adjusts.edit', compact('adjust', 'adjustments', 'drivers', 'tvde_weeks'));
    }

    public function update(UpdateAdjustRequest $request, Adjust $adjust)
    {
        $adjust->update($request->all());

        return redirect()->route('admin.adjusts.index');
    }

    public function show(Adjust $adjust)
    {
        abort_if(Gate::denies('adjust_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adjust->load('tvde_week', 'driver', 'adjustment');

        return view('admin.adjusts.show', compact('adjust'));
    }

    public function destroy(Adjust $adjust)
    {
        abort_if(Gate::denies('adjust_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adjust->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdjustRequest $request)
    {
        $adjusts = Adjust::find(request('ids'));

        foreach ($adjusts as $adjust) {
            $adjust->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
