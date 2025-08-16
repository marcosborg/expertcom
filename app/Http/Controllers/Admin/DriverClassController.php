<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDriverClassRequest;
use App\Http\Requests\StoreDriverClassRequest;
use App\Http\Requests\UpdateDriverClassRequest;
use App\Models\DriverClass;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DriverClassController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('driver_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $driverClasses = DriverClass::all();

        return view('admin.driverClasses.index', compact('driverClasses'));
    }

    public function create()
    {
        abort_if(Gate::denies('driver_class_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.driverClasses.create');
    }

    public function store(StoreDriverClassRequest $request)
    {
        $driverClass = DriverClass::create($request->all());

        return redirect()->route('admin.driver-classes.index');
    }

    public function edit(DriverClass $driverClass)
    {
        abort_if(Gate::denies('driver_class_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.driverClasses.edit', compact('driverClass'));
    }

    public function update(UpdateDriverClassRequest $request, DriverClass $driverClass)
    {
        $driverClass->update($request->all());

        return redirect()->route('admin.driver-classes.index');
    }

    public function show(DriverClass $driverClass)
    {
        abort_if(Gate::denies('driver_class_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.driverClasses.show', compact('driverClass'));
    }

    public function destroy(DriverClass $driverClass)
    {
        abort_if(Gate::denies('driver_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $driverClass->delete();

        return back();
    }

    public function massDestroy(MassDestroyDriverClassRequest $request)
    {
        $driverClasses = DriverClass::find(request('ids'));

        foreach ($driverClasses as $driverClass) {
            $driverClass->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}