<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDrvSessionRequest;
use App\Http\Requests\UpdateDrvSessionRequest;
use App\Http\Resources\Admin\DrvSessionResource;
use App\Models\DrvSession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DrvSessionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('drv_session_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DrvSessionResource(DrvSession::with(['driver'])->get());
    }

    public function store(StoreDrvSessionRequest $request)
    {
        $drvSession = DrvSession::create($request->all());

        return (new DrvSessionResource($drvSession))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DrvSession $drvSession)
    {
        abort_if(Gate::denies('drv_session_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DrvSessionResource($drvSession->load(['driver']));
    }

    public function update(UpdateDrvSessionRequest $request, DrvSession $drvSession)
    {
        $drvSession->update($request->all());

        return (new DrvSessionResource($drvSession))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DrvSession $drvSession)
    {
        abort_if(Gate::denies('drv_session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $drvSession->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
