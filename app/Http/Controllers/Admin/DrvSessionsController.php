<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDrvSessionRequest;
use App\Http\Requests\StoreDrvSessionRequest;
use App\Http\Requests\UpdateDrvSessionRequest;
use App\Models\Driver;
use App\Models\DrvSession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DrvSessionsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('drv_session_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DrvSession::with(['driver'])->select(sprintf('%s.*', (new DrvSession)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'drv_session_show';
                $editGate      = 'drv_session_edit';
                $deleteGate    = 'drv_session_delete';
                $crudRoutePart = 'drv-sessions';

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

            $table->editColumn('status', function ($row) {
                return $row->status ? DrvSession::STATUS_RADIO[$row->status] : '';
            });
            $table->editColumn('total_drive_seconds', function ($row) {
                return $row->total_drive_seconds ? $row->total_drive_seconds : '';
            });
            $table->editColumn('total_pause_seconds', function ($row) {
                return $row->total_pause_seconds ? $row->total_pause_seconds : '';
            });
            $table->editColumn('started_lat', function ($row) {
                return $row->started_lat ? $row->started_lat : '';
            });
            $table->editColumn('started_lng', function ($row) {
                return $row->started_lng ? $row->started_lng : '';
            });
            $table->editColumn('ended_lat', function ($row) {
                return $row->ended_lat ? $row->ended_lat : '';
            });
            $table->editColumn('ended_lng', function ($row) {
                return $row->ended_lng ? $row->ended_lng : '';
            });
            $table->editColumn('source', function ($row) {
                return $row->source ? DrvSession::SOURCE_RADIO[$row->source] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'driver']);

            return $table->make(true);
        }

        return view('admin.drvSessions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('drv_session_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.drvSessions.create', compact('drivers'));
    }

    public function store(StoreDrvSessionRequest $request)
    {
        $drvSession = DrvSession::create($request->all());

        return redirect()->route('admin.drv-sessions.index');
    }

    public function edit(DrvSession $drvSession)
    {
        abort_if(Gate::denies('drv_session_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drvSession->load('driver');

        return view('admin.drvSessions.edit', compact('drivers', 'drvSession'));
    }

    public function update(UpdateDrvSessionRequest $request, DrvSession $drvSession)
    {
        $drvSession->update($request->all());

        return redirect()->route('admin.drv-sessions.index');
    }

    public function show(DrvSession $drvSession)
    {
        abort_if(Gate::denies('drv_session_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvSession->load('driver');

        return view('admin.drvSessions.show', compact('drvSession'));
    }

    public function destroy(DrvSession $drvSession)
    {
        abort_if(Gate::denies('drv_session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvSession->delete();

        return back();
    }

    public function massDestroy(MassDestroyDrvSessionRequest $request)
    {
        $drvSessions = DrvSession::find(request('ids'));

        foreach ($drvSessions as $drvSession) {
            $drvSession->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
