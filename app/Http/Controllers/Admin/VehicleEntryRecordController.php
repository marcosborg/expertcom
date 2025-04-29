<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVehicleEntryRecordRequest;
use App\Http\Requests\StoreVehicleEntryRecordRequest;
use App\Http\Requests\UpdateVehicleEntryRecordRequest;
use App\Models\User;
use App\Models\VehicleEntryRecord;
use App\Models\VehicleItem;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleEntryRecordController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_entry_record_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleEntryRecord::with(['user', 'vehicle'])->select(sprintf('%s.*', (new VehicleEntryRecord)->table));
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

            $table->addColumn('vehicle_license_plate', function ($row) {
                return $row->vehicle ? $row->vehicle->license_plate : '';
            });

            $table->editColumn('battery_enter', function ($row) {
                return $row->battery_enter ? $row->battery_enter : '';
            });
            $table->editColumn('quilometers', function ($row) {
                return $row->quilometers ? $row->quilometers : '';
            });
            $table->editColumn('photos', function ($row) {
                if (! $row->photos) {
                    return '';
                }
                $links = [];
                foreach ($row->photos as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'vehicle', 'photos']);

            return $table->make(true);
        }

        return view('admin.vehicleEntryRecords.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_entry_record_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicles = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleEntryRecords.create', compact('users', 'vehicles'));
    }

    public function store(StoreVehicleEntryRecordRequest $request)
    {
        $vehicleEntryRecord = VehicleEntryRecord::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $vehicleEntryRecord->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $vehicleEntryRecord->id]);
        }

        return redirect()->route('admin.vehicle-entry-records.index');
    }

    public function edit(VehicleEntryRecord $vehicleEntryRecord)
    {
        abort_if(Gate::denies('vehicle_entry_record_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicles = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleEntryRecord->load('user', 'vehicle');

        return view('admin.vehicleEntryRecords.edit', compact('users', 'vehicleEntryRecord', 'vehicles'));
    }

    public function update(UpdateVehicleEntryRecordRequest $request, VehicleEntryRecord $vehicleEntryRecord)
    {
        $vehicleEntryRecord->update($request->all());

        if (count($vehicleEntryRecord->photos) > 0) {
            foreach ($vehicleEntryRecord->photos as $media) {
                if (! in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleEntryRecord->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleEntryRecord->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.vehicle-entry-records.index');
    }

    public function show(VehicleEntryRecord $vehicleEntryRecord)
    {
        abort_if(Gate::denies('vehicle_entry_record_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleEntryRecord->load('user', 'vehicle');

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

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('vehicle_entry_record_create') && Gate::denies('vehicle_entry_record_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new VehicleEntryRecord();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
