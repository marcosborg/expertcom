<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVehicleManageCheckinRequest;
use App\Http\Requests\StoreVehicleManageCheckinRequest;
use App\Http\Requests\UpdateVehicleManageCheckinRequest;
use App\Models\Company;
use App\Models\Driver;
use App\Models\User;
use App\Models\VehicleItem;
use App\Models\VehicleManageCheckin;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\VehicleManageEntry;
use App\Models\VehicleDamageCheckin;
use App\Notifications\DamageNotification;

class VehicleManageCheckinController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_manage_checkin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleManageCheckin::with(['user', 'vehicle_item', 'driver'])->select(sprintf('%s.*', (new VehicleManageCheckin)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_manage_checkin_show';
                $editGate      = 'vehicle_manage_checkin_edit';
                $deleteGate    = 'vehicle_manage_checkin_delete';
                $crudRoutePart = 'vehicle-manage-checkins';

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

            $table->addColumn('driver_name', function ($row) {
                return $row->driver ? $row->driver->name : '';
            });

            $table->editColumn('bateria_a_chegada', function ($row) {
                return $row->bateria_a_chegada ? $row->bateria_a_chegada : '';
            });
            $table->editColumn('km_atual', function ($row) {
                return $row->km_atual ? $row->km_atual : '';
            });
            $table->editColumn('tratado', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->tratado ? 'checked' : null) . '>';
            });
            $table->editColumn('reparado', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->reparado ? 'checked' : null) . '>';
            });
            $table->editColumn('signature_collector_data', function ($row) {
                return $row->signature_collector_data ? 'Sim' : '';
            });
            $table->editColumn('signature_driver_data', function ($row) {
                return $row->signature_driver_data ? 'Sim' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'vehicle_item', 'driver', 'tratado', 'reparado']);

            return $table->make(true);
        }

        $users         = User::get();
        $vehicle_items = VehicleItem::get();
        $drivers       = Driver::get();

        return view('admin.vehicleManageCheckins.index', compact('users', 'vehicle_items', 'drivers'));
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_manage_checkin_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleManageCheckins.create', compact('drivers', 'users', 'vehicle_items'));
    }

    public function store(StoreVehicleManageCheckinRequest $request)
    {
        $vehicleManageCheckin = VehicleManageCheckin::create($request->all());

        return redirect()->route('admin.vehicle-manage-checkins.edit', [$vehicleManageCheckin->id]);
    }

    public function edit(VehicleManageCheckin $vehicleManageCheckin)
    {
        abort_if(Gate::denies('vehicle_manage_checkin_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_items = VehicleItem::pluck('license_plate', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drivers = Driver::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleManageCheckin->load('user', 'vehicle_item', 'driver');

        $vehicleManageEntry = VehicleManageEntry::where('vehicle_item_id', $vehicleManageCheckin->vehicle_item_id)->orderBy('id', 'desc')->first();

        //PROCURA O ÚLTIMO VEHICLE DAMAGE CHECKIN
        $vehicle_damage_checkin = VehicleDamageCheckin::whereHas('vehicle_manage_checkin', function ($query) use ($vehicleManageCheckin) {
            $query->where('vehicle_item_id', $vehicleManageCheckin->vehicle_item_id);
        })->orderBy('id', 'desc')->first();

        if($vehicle_damage_checkin) {
            $vehicle_damage_checkin->load('vehicle_manage_checkin');
        }

        return view('admin.vehicleManageCheckins.edit', compact('drivers', 'users', 'vehicleManageCheckin', 'vehicle_items', 'vehicleManageEntry', 'vehicle_damage_checkin'));
    }

    public function update(UpdateVehicleManageCheckinRequest $request, VehicleManageCheckin $vehicleManageCheckin)
    {
        $vehicleManageCheckin->update($request->all());

        $damage = false;

        if (count($vehicleManageCheckin->frente_do_veiculo_teto_photos) > 0) {
            foreach ($vehicleManageCheckin->frente_do_veiculo_teto_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_teto_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->frente_do_veiculo_teto_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_teto_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_teto_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->frente_do_veiculo_parabrisa_photos) > 0) {
            foreach ($vehicleManageCheckin->frente_do_veiculo_parabrisa_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_parabrisa_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->frente_do_veiculo_parabrisa_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_parabrisa_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_parabrisa_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->frente_do_veiculo_capo_photos) > 0) {
            foreach ($vehicleManageCheckin->frente_do_veiculo_capo_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_capo_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->frente_do_veiculo_capo_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_capo_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_capo_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->frente_do_veiculo_parachoque_photos) > 0) {
            foreach ($vehicleManageCheckin->frente_do_veiculo_parachoque_photos as $media) {
                if (! in_array($media->file_name, $request->input('frente_do_veiculo_parachoque_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->frente_do_veiculo_parachoque_photos->pluck('file_name')->toArray();
        foreach ($request->input('frente_do_veiculo_parachoque_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('frente_do_veiculo_parachoque_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_esquerda_paralama_diant_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_esquerda_paralama_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_paralama_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_esquerda_paralama_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_paralama_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_paralama_diant_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_esquerda_retrovisor_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_esquerda_retrovisor_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_retrovisor_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_esquerda_retrovisor_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_retrovisor_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_retrovisor_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_esquerda_porta_diant_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_esquerda_porta_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_porta_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_esquerda_porta_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_porta_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_porta_diant_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_esquerda_porta_tras_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_esquerda_porta_tras_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_porta_tras_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_esquerda_porta_tras_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_porta_tras_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_porta_tras_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_esquerda_lateral_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_esquerda_lateral_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_esquerda_lateral_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_esquerda_lateral_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_esquerda_lateral_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_esquerda_lateral_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_tampa_traseira_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_tampa_traseira_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_tampa_traseira_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_tampa_traseira_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_tampa_traseira_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_tampa_traseira_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_lanternas_dir_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_lanternas_dir_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_lanternas_dir_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_lanternas_dir_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_lanternas_dir_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_lanternas_dir_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_lanterna_esq_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_lanterna_esq_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_lanterna_esq_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_lanterna_esq_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_lanterna_esq_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_lanterna_esq_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_parachoque_tras_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_parachoque_tras_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_parachoque_tras_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_parachoque_tras_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_parachoque_tras_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_parachoque_tras_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_estepe_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_estepe_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_estepe_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_estepe_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_estepe_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_estepe_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_macaco_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_macaco_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_macaco_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_macaco_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_macaco_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_macaco_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_chave_de_roda_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_chave_de_roda_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_chave_de_roda_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_chave_de_roda_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_chave_de_roda_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_chave_de_roda_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->traseira_triangulo_photos) > 0) {
            foreach ($vehicleManageCheckin->traseira_triangulo_photos as $media) {
                if (! in_array($media->file_name, $request->input('traseira_triangulo_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->traseira_triangulo_photos->pluck('file_name')->toArray();
        foreach ($request->input('traseira_triangulo_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('traseira_triangulo_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_direita_lateral_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_direita_lateral_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_lateral_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_direita_lateral_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_lateral_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_lateral_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_direita_porta_tras_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_direita_porta_tras_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_porta_tras_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_direita_porta_tras_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_porta_tras_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_porta_tras_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_direita_porta_diant_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_direita_porta_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_porta_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_direita_porta_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_porta_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_porta_diant_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_direita_retrovisor_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_direita_retrovisor_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_retrovisor_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_direita_retrovisor_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_retrovisor_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_retrovisor_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->lateral_direita_paralama_diant_photos) > 0) {
            foreach ($vehicleManageCheckin->lateral_direita_paralama_diant_photos as $media) {
                if (! in_array($media->file_name, $request->input('lateral_direita_paralama_diant_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->lateral_direita_paralama_diant_photos->pluck('file_name')->toArray();
        foreach ($request->input('lateral_direita_paralama_diant_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('lateral_direita_paralama_diant_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->cinzeiro_photos) > 0) {
            foreach ($vehicleManageCheckin->cinzeiro_photos as $media) {
                if (! in_array($media->file_name, $request->input('cinzeiro_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->cinzeiro_photos->pluck('file_name')->toArray();
        foreach ($request->input('cinzeiro_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('cinzeiro_photos');
            }
            $damage = true;
        }

        if (count($vehicleManageCheckin->telemovel_photos) > 0) {
            foreach ($vehicleManageCheckin->telemovel_photos as $media) {
                if (! in_array($media->file_name, $request->input('telemovel_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleManageCheckin->telemovel_photos->pluck('file_name')->toArray();
        foreach ($request->input('telemovel_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleManageCheckin->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('telemovel_photos');
            }
            $damage = true;
        }

        if ($damage == true) {
            $vehicle_damage_checkin = VehicleDamageCheckin::where('vehicle_manage_checkin_id', $vehicleManageCheckin->id)->first();
            if (!$vehicle_damage_checkin) {
                //AVISAR
                $this->notifyOfDamage($vehicleManageCheckin->driver_id, $vehicleManageCheckin->vehicle_item_id);
                $vehicle_damage_checkin = new VehicleDamageCheckin();
                $vehicle_damage_checkin->vehicle_manage_checkin_id = $vehicleManageCheckin->id;
                $vehicle_damage_checkin->driver_warning = 1;
                $vehicle_damage_checkin->company_warning = 1;
                $vehicle_damage_checkin->admin_warning = 1;
                $vehicle_damage_checkin->save();
            }
        }

        return redirect()->route('admin.vehicle-manage-checkins.index');
    }

    private function notifyOfDamage($driver_id, $vehicle_item_id)
    {
        $admin = User::find(799);
        $driver = User::find(Driver::find($driver_id)->user_id);
        $vehicle_item = VehicleItem::find($vehicle_item_id);
        $company = Company::find($vehicle_item->company_id)->load('user')->user;

        $message = "O veículo com a matrícula " . $vehicle_item->license_plate . " tem danos que precisam ser verificados.";

        $admin->notify(new DamageNotification($message));
        $company->notify(new DamageNotification($message));
        $driver->notify(new DamageNotification($message));
    }

    public function show(VehicleManageCheckin $vehicleManageCheckin)
    {
        abort_if(Gate::denies('vehicle_manage_checkin_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleManageCheckin->load('user', 'vehicle_item', 'driver');

        return view('admin.vehicleManageCheckins.show', compact('vehicleManageCheckin'));
    }

    public function destroy(VehicleManageCheckin $vehicleManageCheckin)
    {
        abort_if(Gate::denies('vehicle_manage_checkin_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleManageCheckin->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleManageCheckinRequest $request)
    {
        $vehicleManageCheckins = VehicleManageCheckin::find(request('ids'));

        foreach ($vehicleManageCheckins as $vehicleManageCheckin) {
            $vehicleManageCheckin->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('vehicle_manage_checkin_create') && Gate::denies('vehicle_manage_checkin_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new VehicleManageCheckin();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
