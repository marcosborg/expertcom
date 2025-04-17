<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyVehicleEntryRecordRequest;
use App\Http\Requests\StoreVehicleEntryRecordRequest;
use App\Http\Requests\UpdateVehicleEntryRecordRequest;
use App\Models\Driver;
use App\Models\User;
use App\Models\VehicleEntryRecord;
use App\Models\VehicleItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleEntryRecordController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_entry_record_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleEntryRecord::with(['user', 'driver', 'vehicle'])->select(sprintf('%s.*', (new VehicleEntryRecord)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_entry_record_show';
                $editGate      = 'vehicle_entry_record_edit';
                $deleteGate    = 'vehicle_entry_record_delete';
                $crudRoutePart = 'vehicle-entry-records';

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

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('driver_name', function ($row) {
                return $row->driver ? $row->driver->name : '';
            });

            $table->addColumn('vehicle_license_plate', function ($row) {
                return $row->vehicle ? $row->vehicle->license_plate : '';
            });

            $table->editColumn('battery_enter', function ($row) {
                return $row->battery_enter ? $row->battery_enter : '';
            });
            $table->editColumn('battery_exit', function ($row) {
                return $row->battery_exit ? $row->battery_exit : '';
            });
            $table->editColumn('quilometers', function ($row) {
                return $row->quilometers ? $row->quilometers : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'driver', 'vehicle']);

            return $table->make(true);
        }

        return view('admin.vehicleEntryRecords.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_entry_record_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicles = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleEntryRecords.create', compact('drivers', 'users', 'vehicles'));
    }

    public function store(StoreVehicleEntryRecordRequest $request)
    {
        $vehicleEntryRecord = VehicleEntryRecord::create($request->all());

        return redirect()->route('admin.vehicle-entry-records.index');
    }

    public function edit(VehicleEntryRecord $vehicleEntryRecord)
    {
        abort_if(Gate::denies('vehicle_entry_record_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicles = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleEntryRecord->load('user', 'driver', 'vehicle');

        return view('admin.vehicleEntryRecords.edit', compact('drivers', 'users', 'vehicleEntryRecord', 'vehicles'));
    }

    public function update(UpdateVehicleEntryRecordRequest $request, VehicleEntryRecord $vehicleEntryRecord)
    {
        $vehicleEntryRecord->update($request->all());

        return redirect()->route('admin.vehicle-entry-records.index');
    }

    public function show(VehicleEntryRecord $vehicleEntryRecord)
    {
        abort_if(Gate::denies('vehicle_entry_record_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleEntryRecord->load('user', 'driver', 'vehicle');

        return view('admin.vehicleEntryRecords.show', compact('vehicleEntryRecord'));
    }

    public function destroy(VehicleEntryRecord $vehicleEntryRecord)
    {
        abort_if(Gate::denies('vehicle_entry_record_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleEntryRecord->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleEntryRecordRequest $request)
    {
        $vehicleEntryRecords = VehicleEntryRecord::find(request('ids'));

        foreach ($vehicleEntryRecords as $vehicleEntryRecord) {
            $vehicleEntryRecord->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
