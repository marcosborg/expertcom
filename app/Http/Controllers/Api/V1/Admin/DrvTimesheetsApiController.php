<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDrvTimesheetRequest;
use App\Http\Requests\UpdateDrvTimesheetRequest;
use App\Http\Resources\Admin\DrvTimesheetResource;
use App\Models\DrvTimesheet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DrvTimesheetsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('drv_timesheet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DrvTimesheetResource(DrvTimesheet::with(['driver'])->get());
    }

    public function store(StoreDrvTimesheetRequest $request)
    {
        $drvTimesheet = DrvTimesheet::create($request->all());

        return (new DrvTimesheetResource($drvTimesheet))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DrvTimesheet $drvTimesheet)
    {
        abort_if(Gate::denies('drv_timesheet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DrvTimesheetResource($drvTimesheet->load(['driver']));
    }

    public function update(UpdateDrvTimesheetRequest $request, DrvTimesheet $drvTimesheet)
    {
        $drvTimesheet->update($request->all());

        return (new DrvTimesheetResource($drvTimesheet))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DrvTimesheet $drvTimesheet)
    {
        abort_if(Gate::denies('drv_timesheet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvTimesheet->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
