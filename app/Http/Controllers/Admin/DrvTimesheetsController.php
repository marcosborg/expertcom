<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDrvTimesheetRequest;
use App\Http\Requests\StoreDrvTimesheetRequest;
use App\Http\Requests\UpdateDrvTimesheetRequest;
use App\Models\Driver;
use App\Models\DrvTimesheet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DrvTimesheetsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('drv_timesheet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DrvTimesheet::with(['driver'])->select(sprintf('%s.*', (new DrvTimesheet)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'drv_timesheet_show';
                $editGate      = 'drv_timesheet_edit';
                $deleteGate    = 'drv_timesheet_delete';
                $crudRoutePart = 'drv-timesheets';

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
            $table->addColumn('driver_name', function ($row) {
                return $row->driver ? $row->driver->name : '';
            });

            $table->editColumn('total_drive_seconds', function ($row) {
                return $row->total_drive_seconds ? $row->total_drive_seconds : '';
            });
            $table->editColumn('total_pause_seconds', function ($row) {
                return $row->total_pause_seconds ? $row->total_pause_seconds : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? DrvTimesheet::STATUS_RADIO[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'driver']);

            return $table->make(true);
        }

        return view('admin.drvTimesheets.index');
    }

    public function create()
    {
        abort_if(Gate::denies('drv_timesheet_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.drvTimesheets.create', compact('drivers'));
    }

    public function store(StoreDrvTimesheetRequest $request)
    {
        $drvTimesheet = DrvTimesheet::create($request->all());

        return redirect()->route('admin.drv-timesheets.index');
    }

    public function edit(DrvTimesheet $drvTimesheet)
    {
        abort_if(Gate::denies('drv_timesheet_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drvTimesheet->load('driver');

        return view('admin.drvTimesheets.edit', compact('drivers', 'drvTimesheet'));
    }

    public function update(UpdateDrvTimesheetRequest $request, DrvTimesheet $drvTimesheet)
    {
        $drvTimesheet->update($request->all());

        return redirect()->route('admin.drv-timesheets.index');
    }

    public function show(DrvTimesheet $drvTimesheet)
    {
        abort_if(Gate::denies('drv_timesheet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvTimesheet->load('driver');

        return view('admin.drvTimesheets.show', compact('drvTimesheet'));
    }

    public function destroy(DrvTimesheet $drvTimesheet)
    {
        abort_if(Gate::denies('drv_timesheet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvTimesheet->delete();

        return back();
    }

    public function massDestroy(MassDestroyDrvTimesheetRequest $request)
    {
        $drvTimesheets = DrvTimesheet::find(request('ids'));

        foreach ($drvTimesheets as $drvTimesheet) {
            $drvTimesheet->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
