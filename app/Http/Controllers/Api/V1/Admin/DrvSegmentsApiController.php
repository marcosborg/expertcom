<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDrvSegmentRequest;
use App\Http\Requests\UpdateDrvSegmentRequest;
use App\Http\Resources\Admin\DrvSegmentResource;
use App\Models\DrvSegment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DrvSegmentsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('drv_segment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DrvSegmentResource(DrvSegment::with(['session'])->get());
    }

    public function store(StoreDrvSegmentRequest $request)
    {
        $drvSegment = DrvSegment::create($request->all());

        return (new DrvSegmentResource($drvSegment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DrvSegment $drvSegment)
    {
        abort_if(Gate::denies('drv_segment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DrvSegmentResource($drvSegment->load(['session']));
    }

    public function update(UpdateDrvSegmentRequest $request, DrvSegment $drvSegment)
    {
        $drvSegment->update($request->all());

        return (new DrvSegmentResource($drvSegment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DrvSegment $drvSegment)
    {
        abort_if(Gate::denies('drv_segment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvSegment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
