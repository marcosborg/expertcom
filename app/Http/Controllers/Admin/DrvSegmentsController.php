<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDrvSegmentRequest;
use App\Http\Requests\StoreDrvSegmentRequest;
use App\Http\Requests\UpdateDrvSegmentRequest;
use App\Models\DrvSegment;
use App\Models\DrvSession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DrvSegmentsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('drv_segment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DrvSegment::with(['session'])->select(sprintf('%s.*', (new DrvSegment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'drv_segment_show';
                $editGate      = 'drv_segment_edit';
                $deleteGate    = 'drv_segment_delete';
                $crudRoutePart = 'drv-segments';

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
            $table->addColumn('session_started_at', function ($row) {
                return $row->session ? $row->session->started_at : '';
            });

            $table->editColumn('kind', function ($row) {
                return $row->kind ? DrvSegment::KIND_RADIO[$row->kind] : '';
            });

            $table->editColumn('duration_seconds', function ($row) {
                return $row->duration_seconds ? $row->duration_seconds : '';
            });
            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'session']);

            return $table->make(true);
        }

        return view('admin.drvSegments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('drv_segment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = DrvSession::pluck('started_at', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.drvSegments.create', compact('sessions'));
    }

    public function store(StoreDrvSegmentRequest $request)
    {
        $drvSegment = DrvSegment::create($request->all());

        return redirect()->route('admin.drv-segments.index');
    }

    public function edit(DrvSegment $drvSegment)
    {
        abort_if(Gate::denies('drv_segment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = DrvSession::pluck('started_at', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drvSegment->load('session');

        return view('admin.drvSegments.edit', compact('drvSegment', 'sessions'));
    }

    public function update(UpdateDrvSegmentRequest $request, DrvSegment $drvSegment)
    {
        $drvSegment->update($request->all());

        return redirect()->route('admin.drv-segments.index');
    }

    public function show(DrvSegment $drvSegment)
    {
        abort_if(Gate::denies('drv_segment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvSegment->load('session');

        return view('admin.drvSegments.show', compact('drvSegment'));
    }

    public function destroy(DrvSegment $drvSegment)
    {
        abort_if(Gate::denies('drv_segment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvSegment->delete();

        return back();
    }

    public function massDestroy(MassDestroyDrvSegmentRequest $request)
    {
        $drvSegments = DrvSegment::find(request('ids'));

        foreach ($drvSegments as $drvSegment) {
            $drvSegment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
