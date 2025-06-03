<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVehicleManageEntryRequest;
use App\Http\Requests\StoreVehicleManageEntryRequest;
use App\Http\Requests\UpdateVehicleManageEntryRequest;
use App\Models\User;
use App\Models\VehicleItem;
use App\Models\VehicleManageEntry;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleManageEntryController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_manage_entry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleManageEntry::with(['user', 'vehicle_item'])->select(sprintf('%s.*', (new VehicleManageEntry)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_manage_entry_show';
                $editGate      = 'vehicle_manage_entry_edit';
                $deleteGate    = 'vehicle_manage_entry_delete';
                $crudRoutePart = 'vehicle-manage-entries';

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

            $table->addColumn('vehicle_item_license_plate', function ($row) {
                return $row->vehicle_item ? $row->vehicle_item->license_plate : '';
            });

            $table->editColumn('bateria_a_chegada', function ($row) {
                return $row->bateria_a_chegada ? $row->bateria_a_chegada : '';
            });
            $table->editColumn('km_atual', function ($row) {
                return $row->km_atual ? $row->km_atual : '';
            });
            $table->editColumn('signature_collector_data', function ($row) {
                return $row->signature_collector_data ? 'Sim' : 'Não';
            });
            $table->editColumn('signature_driver_data', function ($row) {
                return $row->signature_driver_data ? 'Sim' : 'Não';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'vehicle_item']);

            return $table->make(true);
        }

        $users         = User::get();
        $vehicle_items = VehicleItem::get();

        return view('admin.vehicleManageEntries.index', compact('users', 'vehicle_items'));
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_manage_entry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleManageEntries.create', compact('users', 'vehicle_items'));
    }

    public function store(StoreVehicleManageEntryRequest $request)
    {
        $vehicleManageEntry = VehicleManageEntry::create($request->all());

        return redirect()->route('admin.vehicle-manage-entries.edit', $vehicleManageEntry->id);
    }

    public function edit(VehicleManageEntry $vehicleManageEntry)
    {
        abort_if(Gate::denies('vehicle_manage_entry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleManageEntry->load('user', 'vehicle_item');

        return view('admin.vehicleManageEntries.edit', compact('users', 'vehicleManageEntry', 'vehicle_items'));
    }

    public function update(UpdateVehicleManageEntryRequest $request, VehicleManageEntry $vehicleManageEntry)
    {
        $vehicleManageEntry->update($request->all());

        if (count($vehicleManageEntry->frente_do_veiculo_teto_photos) > 0) {
            foreach ($vehicleManageEntry->frente_do_veiculo_teto_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_teto_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->frente_do_veiculo_teto_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_teto_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_teto_photos');
            }
        }

        if (count($vehicleManageEntry->frente_do_veiculo_parabrisa_photos) > 0) {
            foreach ($vehicleManageEntry->frente_do_veiculo_parabrisa_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_parabrisa_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->frente_do_veiculo_parabrisa_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_parabrisa_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_parabrisa_photos');
            }
        }

        if (count($vehicleManageEntry->frente_do_veiculo_capo_photos) > 0) {
            foreach ($vehicleManageEntry->frente_do_veiculo_capo_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_capo_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->frente_do_veiculo_capo_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_capo_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_capo_photos');
            }
        }

        if (count($vehicleManageEntry->frente_do_veiculo_parachoque_photos) > 0) {
            foreach ($vehicleManageEntry->frente_do_veiculo_parachoque_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_parachoque_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->frente_do_veiculo_parachoque_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_parachoque_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_parachoque_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_esquerda_paralama_diant_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_esquerda_paralama_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_paralama_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_esquerda_paralama_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_paralama_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_paralama_diant_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_esquerda_retrovisor_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_esquerda_retrovisor_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_retrovisor_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_esquerda_retrovisor_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_retrovisor_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_retrovisor_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_esquerda_porta_diant_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_esquerda_porta_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_porta_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_esquerda_porta_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_porta_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_porta_diant_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_esquerda_porta_tras_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_esquerda_porta_tras_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_porta_tras_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_esquerda_porta_tras_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_porta_tras_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_porta_tras_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_esquerda_lateral_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_esquerda_lateral_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_lateral_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_esquerda_lateral_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_lateral_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_lateral_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_tampa_traseira_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_tampa_traseira_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_tampa_traseira_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_tampa_traseira_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_tampa_traseira_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_tampa_traseira_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_lanternas_dir_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_lanternas_dir_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_lanternas_dir_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_lanternas_dir_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_lanternas_dir_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_lanternas_dir_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_lanterna_esq_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_lanterna_esq_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_lanterna_esq_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_lanterna_esq_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_lanterna_esq_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_lanterna_esq_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_parachoque_tras_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_parachoque_tras_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_parachoque_tras_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_parachoque_tras_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_parachoque_tras_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_parachoque_tras_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_estepe_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_estepe_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_estepe_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_estepe_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_estepe_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_estepe_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_macaco_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_macaco_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_macaco_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_macaco_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_macaco_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_macaco_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_chave_de_roda_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_chave_de_roda_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_chave_de_roda_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_chave_de_roda_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_chave_de_roda_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_chave_de_roda_photos');
            }
        }

        if (count($vehicleManageEntry->traseira_triangulo_photos) > 0) {
            foreach ($vehicleManageEntry->traseira_triangulo_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_triangulo_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->traseira_triangulo_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_triangulo_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_triangulo_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_direita_lateral_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_direita_lateral_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_lateral_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_direita_lateral_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_lateral_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_lateral_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_direita_porta_tras_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_direita_porta_tras_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_porta_tras_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_direita_porta_tras_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_porta_tras_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_porta_tras_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_direita_porta_diant_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_direita_porta_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_porta_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_direita_porta_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_porta_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_porta_diant_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_direita_retrovisor_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_direita_retrovisor_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_retrovisor_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_direita_retrovisor_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_retrovisor_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_retrovisor_photos');
            }
        }

        if (count($vehicleManageEntry->lateral_direita_paralama_diant_photos) > 0) {
            foreach ($vehicleManageEntry->lateral_direita_paralama_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_paralama_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->lateral_direita_paralama_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_paralama_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_paralama_diant_photos');
            }
        }

        if (count($vehicleManageEntry->cinzeiro_photos) > 0) {
            foreach ($vehicleManageEntry->cinzeiro_photos as $media) {
                if (! in_array($media->file_name, $request->input('cinzeiro_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->cinzeiro_photos->pluck('file_name')->toArray();
        foreach ($request->input('cinzeiro_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('cinzeiro_photos');
            }
        }

        if (count($vehicleManageEntry->telemovel_photos) > 0) {
            foreach ($vehicleManageEntry->telemovel_photos as $media) {
                if (! in_array($media->file_name, $request->input('telemovel_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageEntry->telemovel_photos->pluck('file_name')->toArray();
        foreach ($request->input('telemovel_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageEntry->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('telemovel_photos');
            }
        }

        return redirect()->route('admin.vehicle-manage-entries.index');
    }

    public function show(VehicleManageEntry $vehicleManageEntry)
    {
        abort_if(Gate::denies('vehicle_manage_entry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleManageEntry->load('user', 'vehicle_item');

        return view('admin.vehicleManageEntries.show', compact('vehicleManageEntry'));
    }

    public function destroy(VehicleManageEntry $vehicleManageEntry)
    {
        abort_if(Gate::denies('vehicle_manage_entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleManageEntry->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleManageEntryRequest $request)
    {
        $vehicleManageEntries = VehicleManageEntry::find(request('ids'));

        foreach ($vehicleManageEntries as $vehicleManageEntry) {
            $vehicleManageEntry->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('vehicle_manage_entry_create') && Gate::denies('vehicle_manage_entry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new VehicleManageEntry();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
