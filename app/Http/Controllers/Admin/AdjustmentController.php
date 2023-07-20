<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAdjustmentRequest;
use App\Http\Requests\StoreAdjustmentRequest;
use App\Http\Requests\UpdateAdjustmentRequest;
use App\Models\Adjustment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdjustmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('adjustment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adjustments = Adjustment::all();

        return view('admin.adjustments.index', compact('adjustments'));
    }

    public function create()
    {
        abort_if(Gate::denies('adjustment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adjustments.create');
    }

    public function store(StoreAdjustmentRequest $request)
    {
        $adjustment = Adjustment::create($request->all());

        return redirect()->route('admin.adjustments.index');
    }

    public function edit(Adjustment $adjustment)
    {
        abort_if(Gate::denies('adjustment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adjustments.edit', compact('adjustment'));
    }

    public function update(UpdateAdjustmentRequest $request, Adjustment $adjustment)
    {
        $adjustment->update($request->all());

        return redirect()->route('admin.adjustments.index');
    }

    public function show(Adjustment $adjustment)
    {
        abort_if(Gate::denies('adjustment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adjustments.show', compact('adjustment'));
    }

    public function destroy(Adjustment $adjustment)
    {
        abort_if(Gate::denies('adjustment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adjustment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdjustmentRequest $request)
    {
        $adjustments = Adjustment::find(request('ids'));

        foreach ($adjustments as $adjustment) {
            $adjustment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
