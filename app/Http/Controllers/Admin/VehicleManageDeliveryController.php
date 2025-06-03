<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVehicleManageDeliveryRequest;
use App\Http\Requests\StoreVehicleManageDeliveryRequest;
use App\Http\Requests\UpdateVehicleManageDeliveryRequest;
use App\Models\Driver;
use App\Models\User;
use App\Models\VehicleItem;
use App\Models\VehicleManageDelivery;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleManageDeliveryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_manage_delivery_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleManageDelivery::with(['vehicle_item', 'user', 'driver'])->select(sprintf('%s.*', (new VehicleManageDelivery)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_manage_delivery_show';
                $editGate      = 'vehicle_manage_delivery_edit';
                $deleteGate    = 'vehicle_manage_delivery_delete';
                $crudRoutePart = 'vehicle-manage-deliveries';

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
            $table->addColumn('vehicle_item_license_plate', function ($row) {
                return $row->vehicle_item ? $row->vehicle_item->license_plate : '';
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('driver_name', function ($row) {
                return $row->driver ? $row->driver->name : '';
            });

            $table->editColumn('de_bateria_de_saida', function ($row) {
                return $row->de_bateria_de_saida ? $row->de_bateria_de_saida : '';
            });
            $table->editColumn('km_atual', function ($row) {
                return $row->km_atual ? $row->km_atual : '';
            });
            $table->editColumn('signature_collector_data', function ($row) {
                return $row->signature_collector_data ? $row->signature_collector_data : '';
            });
            $table->editColumn('signature_driver_data', function ($row) {
                return $row->signature_driver_data ? $row->signature_driver_data : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'vehicle_item', 'user', 'driver']);

            return $table->make(true);
        }

        $vehicle_items = VehicleItem::get();
        $users         = User::get();
        $drivers       = Driver::get();

        return view('admin.vehicleManageDeliveries.index', compact('vehicle_items', 'users', 'drivers'));
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_manage_delivery_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleManageDeliveries.create', compact('drivers', 'users', 'vehicle_items'));
    }

    public function store(StoreVehicleManageDeliveryRequest $request)
    {
        $vehicleManageDelivery = VehicleManageDelivery::create($request->all());

        return redirect()->route('admin.vehicle-manage-deliveries.edit', [$vehicleManageDelivery->id]);
    }

    public function edit(VehicleManageDelivery $vehicleManageDelivery)
    {
        abort_if(Gate::denies('vehicle_manage_delivery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleManageDelivery->load('vehicle_item', 'user', 'driver');

        return view('admin.vehicleManageDeliveries.edit', compact('drivers', 'users', 'vehicleManageDelivery', 'vehicle_items'));
    }

    public function update(UpdateVehicleManageDeliveryRequest $request, VehicleManageDelivery $vehicleManageDelivery)
    {
        $vehicleManageDelivery->update($request->all());

        return redirect()->route('admin.vehicle-manage-deliveries.index');
    }

    public function show(VehicleManageDelivery $vehicleManageDelivery)
    {
        abort_if(Gate::denies('vehicle_manage_delivery_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleManageDelivery->load('vehicle_item', 'user', 'driver');

        return view('admin.vehicleManageDeliveries.show', compact('vehicleManageDelivery'));
    }

    public function destroy(VehicleManageDelivery $vehicleManageDelivery)
    {
        abort_if(Gate::denies('vehicle_manage_delivery_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleManageDelivery->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleManageDeliveryRequest $request)
    {
        $vehicleManageDeliveries = VehicleManageDelivery::find(request('ids'));

        foreach ($vehicleManageDeliveries as $vehicleManageDelivery) {
            $vehicleManageDelivery->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
