<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVehicleDamageCheckinRequest;
use App\Http\Requests\StoreVehicleDamageCheckinRequest;
use App\Http\Requests\UpdateVehicleDamageCheckinRequest;
use App\Models\VehicleDamageCheckin;
use App\Models\VehicleManageCheckin;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleDamageCheckinController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vehicle_damage_checkin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDamageCheckins = VehicleDamageCheckin::with(['vehicle_manage_checkin'])->get();

        return view('admin.vehicleDamageCheckins.index', compact('vehicleDamageCheckins'));
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_damage_checkin_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicle_manage_checkins = VehicleManageCheckin::pluck('data_e_horario', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleDamageCheckins.create', compact('vehicle_manage_checkins'));
    }

    public function store(StoreVehicleDamageCheckinRequest $request)
    {
        $vehicleDamageCheckin = VehicleDamageCheckin::create($request->all());

        return redirect()->route('admin.vehicle-damage-checkins.index');
    }

    public function edit(VehicleDamageCheckin $vehicleDamageCheckin)
    {
        abort_if(Gate::denies('vehicle_damage_checkin_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicle_manage_checkins = VehicleManageCheckin::pluck('data_e_horario', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleDamageCheckin->load('vehicle_manage_checkin');

        return view('admin.vehicleDamageCheckins.edit', compact('vehicleDamageCheckin', 'vehicle_manage_checkins'));
    }

    public function update(UpdateVehicleDamageCheckinRequest $request, VehicleDamageCheckin $vehicleDamageCheckin)
    {
        $vehicleDamageCheckin->update($request->all());

        return redirect()->route('admin.vehicle-damage-checkins.index');
    }

    public function show(VehicleDamageCheckin $vehicleDamageCheckin)
    {
        abort_if(Gate::denies('vehicle_damage_checkin_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDamageCheckin->load('vehicle_manage_checkin');

        return view('admin.vehicleDamageCheckins.show', compact('vehicleDamageCheckin'));
    }

    public function destroy(VehicleDamageCheckin $vehicleDamageCheckin)
    {
        abort_if(Gate::denies('vehicle_damage_checkin_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDamageCheckin->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleDamageCheckinRequest $request)
    {
        $vehicleDamageCheckins = VehicleDamageCheckin::find(request('ids'));

        foreach ($vehicleDamageCheckins as $vehicleDamageCheckin) {
            $vehicleDamageCheckin->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
