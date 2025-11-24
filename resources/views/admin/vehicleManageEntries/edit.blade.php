@extends('layouts.admin')
@section('content')
@section('styles')
    @parent
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css" rel="stylesheet" />
@endsection
<div class="content">
    <form method="POST" action="{{ route("admin.vehicle-manage-entries.update", [$vehicleManageEntry->id]) }}" enctype="multipart/form-data">

        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('global.edit') }} {{ trans('cruds.vehicleManageEntry.title_singular') }}
                    </div>
                    <div class="panel-body">

                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                            <label class="required" for="user_id">{{ trans('cruds.vehicleManageEntry.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $vehicleManageEntry->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                            <span class="help-block" role="alert">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('vehicle_item') ? 'has-error' : '' }}">
                            <label class="required" for="vehicle_item_id">{{ trans('cruds.vehicleManageEntry.fields.vehicle_item') }}</label>
                            <select class="form-control select2" name="vehicle_item_id" id="vehicle_item_id" required>
                                @foreach($vehicle_items as $id => $entry)
                                <option value="{{ $id }}" {{ (old('vehicle_item_id') ? old('vehicle_item_id') : $vehicleManageEntry->vehicle_item->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vehicle_item'))
                            <span class="help-block" role="alert">{{ $errors->first('vehicle_item') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.vehicle_item_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('data_e_horario') ? 'has-error' : '' }}">
                            <label for="data_e_horario">{{ trans('cruds.vehicleManageEntry.fields.data_e_horario') }}</label>
                            <input class="form-control datetime" type="text" name="data_e_horario" id="data_e_horario" value="{{ old('data_e_horario', $vehicleManageEntry->data_e_horario) }}">
                            @if($errors->has('data_e_horario'))
                            <span class="help-block" role="alert">{{ $errors->first('data_e_horario') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.data_e_horario_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('bateria_a_chegada') ? 'has-error' : '' }}">
                            <label class="required" for="bateria_a_chegada">{{ trans('cruds.vehicleManageEntry.fields.bateria_a_chegada') }}</label>
                            <input class="form-control" type="number" name="bateria_a_chegada" id="bateria_a_chegada" value="{{ old('bateria_a_chegada', $vehicleManageEntry->bateria_a_chegada) }}" step="1" required>
                            @if($errors->has('bateria_a_chegada'))
                            <span class="help-block" role="alert">{{ $errors->first('bateria_a_chegada') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.bateria_a_chegada_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('km_atual') ? 'has-error' : '' }}">
                            <label class="required" for="km_atual">{{ trans('cruds.vehicleManageEntry.fields.km_atual') }}</label>
                            <input class="form-control" type="number" name="km_atual" id="km_atual" value="{{ old('km_atual', $vehicleManageEntry->km_atual) }}" step="1" required>
                            @if($errors->has('km_atual'))
                            <span class="help-block" role="alert">{{ $errors->first('km_atual') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.km_atual_helper') }}</span>
                        </div>
                        <input type="hidden" class="form-control" name="signature_collector_data" id="signature_collector_data" value="{{ old('signature_collector_data', $vehicleManageEntry->signature_collector_data) }}">
                        <input type="hidden" class="form-control" name="signature_driver_data" id="signature_driver_data" value="{{ old('signature_driver_data', $vehicleManageEntry->signature_driver_data) }}">
                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Estado geral da viatura
                    </div>
                    <div class="panel-body">
                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#entries-1" aria-controls="home" role="tab" data-toggle="tab">Frente</a></li>
                                <li role="presentation"><a href="#entries-2" aria-controls="profile" role="tab" data-toggle="tab">Lateral esquerda</a></li>
                                <li role="presentation"><a href="#entries-3" aria-controls="messages" role="tab" data-toggle="tab">Traseira</a></li>
                                <li role="presentation"><a href="#entries-4" aria-controls="settings" role="tab" data-toggle="tab">Lateral direita</a></li>
                                <li role="presentation"><a href="#entries-5" aria-controls="settings" role="tab" data-toggle="tab">Cinzeiro | Diversos</a></li>
                                <li role="presentation"><a href="#entries-6" aria-controls="settings" role="tab" data-toggle="tab">Assinaturas</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" style="margin-top: 20px;">
                                <div role="tabpanel" class="tab-pane active" id="entries-1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="form-group {{ $errors->has('frente_do_veiculo_teto') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="frente_do_veiculo_teto" value="0">
                                                            <input type="checkbox" name="frente_do_veiculo_teto" id="frente_do_veiculo_teto" value="1" {{ $vehicleManageEntry->frente_do_veiculo_teto || old('frente_do_veiculo_teto', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="frente_do_veiculo_teto" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_teto') }}</label>
                                                        </div>
                                                        @if($errors->has('frente_do_veiculo_teto'))
                                                        <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_teto') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_teto_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('frente_do_veiculo_parabrisa') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="frente_do_veiculo_parabrisa" value="0">
                                                            <input type="checkbox" name="frente_do_veiculo_parabrisa" id="frente_do_veiculo_parabrisa" value="1" {{ $vehicleManageEntry->frente_do_veiculo_parabrisa || old('frente_do_veiculo_parabrisa', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="frente_do_veiculo_parabrisa" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parabrisa') }}</label>
                                                        </div>
                                                        @if($errors->has('frente_do_veiculo_parabrisa'))
                                                        <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_parabrisa') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parabrisa_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('frente_do_veiculo_capo') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="frente_do_veiculo_capo" value="0">
                                                            <input type="checkbox" name="frente_do_veiculo_capo" id="frente_do_veiculo_capo" value="1" {{ $vehicleManageEntry->frente_do_veiculo_capo || old('frente_do_veiculo_capo', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="frente_do_veiculo_capo" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_capo') }}</label>
                                                        </div>
                                                        @if($errors->has('frente_do_veiculo_capo'))
                                                        <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_capo') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_capo_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('frente_do_veiculo_parachoque') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="frente_do_veiculo_parachoque" value="0">
                                                            <input type="checkbox" name="frente_do_veiculo_parachoque" id="frente_do_veiculo_parachoque" value="1" {{ $vehicleManageEntry->frente_do_veiculo_parachoque || old('frente_do_veiculo_parachoque', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="frente_do_veiculo_parachoque" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parachoque') }}</label>
                                                        </div>
                                                        @if($errors->has('frente_do_veiculo_parachoque'))
                                                        <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_parachoque') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parachoque_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('frente_do_veiculo_nada_consta') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="frente_do_veiculo_nada_consta" value="0">
                                                            <input type="checkbox" name="frente_do_veiculo_nada_consta" id="frente_do_veiculo_nada_consta" value="1" {{ $vehicleManageEntry->frente_do_veiculo_nada_consta || old('frente_do_veiculo_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="frente_do_veiculo_nada_consta" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_nada_consta') }}</label>
                                                        </div>
                                                        @if($errors->has('frente_do_veiculo_nada_consta'))
                                                        <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_nada_consta') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_nada_consta_helper') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('frente_do_veiculo_obs') ? 'has-error' : '' }}">
                                                <label for="frente_do_veiculo_obs">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_obs') }}</label>
                                                <textarea class="form-control" name="frente_do_veiculo_obs" id="frente_do_veiculo_obs">{{ old('frente_do_veiculo_obs', $vehicleManageEntry->frente_do_veiculo_obs) }}</textarea>
                                                @if($errors->has('frente_do_veiculo_obs'))
                                                <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_obs') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_obs_helper') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('frente_do_veiculo_teto_photos') ? 'has-error' : '' }}">
                                                <label for="frente_do_veiculo_teto_photos">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_teto_photos') }}</label>
                                                <div class="needsclick dropzone" id="frente_do_veiculo_teto_photos-dropzone">
                                                </div>
                                                @if($errors->has('frente_do_veiculo_teto_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_teto_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_teto_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->frente_do_veiculo_teto_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Frente">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('frente_do_veiculo_parabrisa_photos') ? 'has-error' : '' }}">
                                                <label for="frente_do_veiculo_parabrisa_photos">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parabrisa_photos') }}</label>
                                                <div class="needsclick dropzone" id="frente_do_veiculo_parabrisa_photos-dropzone">
                                                </div>
                                                @if($errors->has('frente_do_veiculo_parabrisa_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_parabrisa_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parabrisa_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->frente_do_veiculo_parabrisa_photos as $media) 
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Frente">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('frente_do_veiculo_capo_photos') ? 'has-error' : '' }}">
                                                <label for="frente_do_veiculo_capo_photos">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_capo_photos') }}</label>
                                                <div class="needsclick dropzone" id="frente_do_veiculo_capo_photos-dropzone">
                                                </div>
                                                @if($errors->has('frente_do_veiculo_capo_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_capo_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_capo_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->frente_do_veiculo_capo_photos as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Frente">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('frente_do_veiculo_parachoque_photos') ? 'has-error' : '' }}">
                                                <label for="frente_do_veiculo_parachoque_photos">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parachoque_photos') }}</label>
                                                <div class="needsclick dropzone" id="frente_do_veiculo_parachoque_photos-dropzone">
                                                </div>
                                                @if($errors->has('frente_do_veiculo_parachoque_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('frente_do_veiculo_parachoque_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parachoque_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->frente_do_veiculo_parachoque_photos as $key => $media) 
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Frente">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('chaves_1') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="chaves_1" value="0">
                                                    <input type="checkbox" name="chaves_1" id="chaves_1" value="1" {{ $vehicleManageEntry->chaves_1 || old('chaves_1', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="chaves_1" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.chaves_1') }}</label>
                                                </div>
                                                @if($errors->has('chaves_1'))
                                                <span class="help-block" role="alert">{{ $errors->first('chaves_1') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.chaves_1_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('chaves_2') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="chaves_2" value="0">
                                                    <input type="checkbox" name="chaves_2" id="chaves_2" value="1" {{ $vehicleManageEntry->chaves_2 || old('chaves_2', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="chaves_2" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.chaves_2') }}</label>
                                                </div>
                                                @if($errors->has('chaves_2'))
                                                <span class="help-block" role="alert">{{ $errors->first('chaves_2') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.chaves_2_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('chaves_photos') ? 'has-error' : '' }}">
                                                <label for="chaves_photos">{{ trans('cruds.vehicleManageEntry.fields.chaves_photos') }}</label>
                                                <div class="needsclick dropzone" id="chaves_photos-dropzone">
                                                </div>
                                                @if($errors->has('chaves_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('chaves_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.chaves_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->chaves_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="{{ trans('cruds.vehicleManageEntry.fields.chaves_photos') }}">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="entries-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="form-group {{ $errors->has('lateral_esquerda_paralama_diant') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_esquerda_paralama_diant" value="0">
                                                            <input type="checkbox" name="lateral_esquerda_paralama_diant" id="lateral_esquerda_paralama_diant" value="1" {{ $vehicleManageEntry->lateral_esquerda_paralama_diant || old('lateral_esquerda_paralama_diant', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_esquerda_paralama_diant" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_paralama_diant') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_esquerda_paralama_diant'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_paralama_diant') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_paralama_diant_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_esquerda_retrovisor') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_esquerda_retrovisor" value="0">
                                                            <input type="checkbox" name="lateral_esquerda_retrovisor" id="lateral_esquerda_retrovisor" value="1" {{ $vehicleManageEntry->lateral_esquerda_retrovisor || old('lateral_esquerda_retrovisor', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_esquerda_retrovisor" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_retrovisor') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_esquerda_retrovisor'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_retrovisor') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_retrovisor_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_esquerda_porta_diant') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_esquerda_porta_diant" value="0">
                                                            <input type="checkbox" name="lateral_esquerda_porta_diant" id="lateral_esquerda_porta_diant" value="1" {{ $vehicleManageEntry->lateral_esquerda_porta_diant || old('lateral_esquerda_porta_diant', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_esquerda_porta_diant" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_diant') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_esquerda_porta_diant'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_porta_diant') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_diant_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_esquerda_porta_tras') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_esquerda_porta_tras" value="0">
                                                            <input type="checkbox" name="lateral_esquerda_porta_tras" id="lateral_esquerda_porta_tras" value="1" {{ $vehicleManageEntry->lateral_esquerda_porta_tras || old('lateral_esquerda_porta_tras', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_esquerda_porta_tras" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_tras') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_esquerda_porta_tras'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_porta_tras') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_tras_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_esquerda_lateral') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_esquerda_lateral" value="0">
                                                            <input type="checkbox" name="lateral_esquerda_lateral" id="lateral_esquerda_lateral" value="1" {{ $vehicleManageEntry->lateral_esquerda_lateral || old('lateral_esquerda_lateral', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_esquerda_lateral" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_lateral') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_esquerda_lateral'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_lateral') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_lateral_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_esquerda_nada_consta') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_esquerda_nada_consta" value="0">
                                                            <input type="checkbox" name="lateral_esquerda_nada_consta" id="lateral_esquerda_nada_consta" value="1" {{ $vehicleManageEntry->lateral_esquerda_nada_consta || old('lateral_esquerda_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_esquerda_nada_consta" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_nada_consta') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_esquerda_nada_consta'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_nada_consta') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_nada_consta_helper') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('lateral_esquerda_obs') ? 'has-error' : '' }}">
                                                <label for="lateral_esquerda_obs">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_obs') }}</label>
                                                <textarea class="form-control" name="lateral_esquerda_obs" id="lateral_esquerda_obs">{{ old('lateral_esquerda_obs', $vehicleManageEntry->lateral_esquerda_obs) }}</textarea>
                                                @if($errors->has('lateral_esquerda_obs'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_obs') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_obs_helper') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_esquerda_paralama_diant_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_esquerda_paralama_diant_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_paralama_diant_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_esquerda_paralama_diant_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_esquerda_paralama_diant_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_paralama_diant_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_paralama_diant_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_esquerda_paralama_diant_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral esquerda">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_esquerda_retrovisor_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_esquerda_retrovisor_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_retrovisor_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_esquerda_retrovisor_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_esquerda_retrovisor_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_retrovisor_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_retrovisor_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_esquerda_retrovisor_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral esquerda">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_esquerda_porta_diant_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_esquerda_porta_diant_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_diant_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_esquerda_porta_diant_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_esquerda_porta_diant_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_porta_diant_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_diant_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_esquerda_porta_diant_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral esquerda">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_esquerda_porta_tras_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_esquerda_porta_tras_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_tras_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_esquerda_porta_tras_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_esquerda_porta_tras_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_porta_tras_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_tras_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_esquerda_porta_tras_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral esquerda">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_esquerda_lateral_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_esquerda_lateral_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_lateral_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_esquerda_lateral_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_esquerda_lateral_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_esquerda_lateral_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_lateral_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_esquerda_lateral_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral esquerda">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="entries-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="form-group {{ $errors->has('traseira_mala') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_mala" value="0">
                                                            <input type="checkbox" name="traseira_mala" id="traseira_mala" value="1" {{ $vehicleManageEntry->traseira_mala || old('traseira_mala', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_mala" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_mala') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_mala'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_mala') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_mala_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_farol_dir') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_farol_dir" value="0">
                                                            <input type="checkbox" name="traseira_farol_dir" id="traseira_farol_dir" value="1" {{ $vehicleManageEntry->traseira_farol_dir || old('traseira_farol_dir', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_farol_dir" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_farol_dir') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_farol_dir'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_farol_dir') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_farol_dir_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_farol_esq') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_farol_esq" value="0">
                                                            <input type="checkbox" name="traseira_farol_esq" id="traseira_farol_esq" value="1" {{ $vehicleManageEntry->traseira_farol_esq || old('traseira_farol_esq', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_farol_esq" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_farol_esq') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_farol_esq'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_farol_esq') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_farol_esq_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_parachoque_tras') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_parachoque_tras" value="0">
                                                            <input type="checkbox" name="traseira_parachoque_tras" id="traseira_parachoque_tras" value="1" {{ $vehicleManageEntry->traseira_parachoque_tras || old('traseira_parachoque_tras', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_parachoque_tras" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_parachoque_tras') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_parachoque_tras'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_parachoque_tras') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_parachoque_tras_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_pneu_reserva') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_pneu_reserva" value="0">
                                                            <input type="checkbox" name="traseira_pneu_reserva" id="traseira_pneu_reserva" value="1" {{ $vehicleManageEntry->traseira_pneu_reserva || old('traseira_pneu_reserva', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_pneu_reserva" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_pneu_reserva') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_pneu_reserva'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_pneu_reserva') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_pneu_reserva_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_macaco') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_macaco" value="0">
                                                            <input type="checkbox" name="traseira_macaco" id="traseira_macaco" value="1" {{ $vehicleManageEntry->traseira_macaco || old('traseira_macaco', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_macaco" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_macaco') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_macaco'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_macaco') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_macaco_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_chave_de_roda') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_chave_de_roda" value="0">
                                                            <input type="checkbox" name="traseira_chave_de_roda" id="traseira_chave_de_roda" value="1" {{ $vehicleManageEntry->traseira_chave_de_roda || old('traseira_chave_de_roda', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_chave_de_roda" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_chave_de_roda') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_chave_de_roda'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_chave_de_roda') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_chave_de_roda_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_triangulo') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_triangulo" value="0">
                                                            <input type="checkbox" name="traseira_triangulo" id="traseira_triangulo" value="1" {{ $vehicleManageEntry->traseira_triangulo || old('traseira_triangulo', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_triangulo" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_triangulo') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_triangulo'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_triangulo') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_triangulo_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('traseira_nada_consta') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="traseira_nada_consta" value="0">
                                                            <input type="checkbox" name="traseira_nada_consta" id="traseira_nada_consta" value="1" {{ $vehicleManageEntry->traseira_nada_consta || old('traseira_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="traseira_nada_consta" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.traseira_nada_consta') }}</label>
                                                        </div>
                                                        @if($errors->has('traseira_nada_consta'))
                                                        <span class="help-block" role="alert">{{ $errors->first('traseira_nada_consta') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_nada_consta_helper') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('traseira_obs') ? 'has-error' : '' }}">
                                                <label for="traseira_obs">{{ trans('cruds.vehicleManageEntry.fields.traseira_obs') }}</label>
                                                <textarea class="form-control" name="traseira_obs" id="traseira_obs">{{ old('traseira_obs', $vehicleManageEntry->traseira_obs) }}</textarea>
                                                @if($errors->has('traseira_obs'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_obs') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_obs_helper') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_tampa_traseira_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_tampa_traseira_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_tampa_traseira_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_tampa_traseira_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_tampa_traseira_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_tampa_traseira_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_tampa_traseira_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_tampa_traseira_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_lanternas_dir_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_lanternas_dir_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_lanternas_dir_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_lanternas_dir_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_lanternas_dir_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_lanternas_dir_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_lanternas_dir_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_lanternas_dir_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_lanterna_esq_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_lanterna_esq_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_lanterna_esq_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_lanterna_esq_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_lanterna_esq_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_lanterna_esq_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_lanterna_esq_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_lanterna_esq_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_parachoque_tras_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_parachoque_tras_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_parachoque_tras_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_parachoque_tras_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_parachoque_tras_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_parachoque_tras_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_parachoque_tras_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_parachoque_tras_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_estepe_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_estepe_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_estepe_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_estepe_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_estepe_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_estepe_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_estepe_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_estepe_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_macaco_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_macaco_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_macaco_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_macaco_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_macaco_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_macaco_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_macaco_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_macaco_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_chave_de_roda_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_chave_de_roda_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_chave_de_roda_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_chave_de_roda_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_chave_de_roda_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_chave_de_roda_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_chave_de_roda_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_chave_de_roda_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('traseira_triangulo_photos') ? 'has-error' : '' }}">
                                                <label for="traseira_triangulo_photos">{{ trans('cruds.vehicleManageEntry.fields.traseira_triangulo_photos') }}</label>
                                                <div class="needsclick dropzone" id="traseira_triangulo_photos-dropzone">
                                                </div>
                                                @if($errors->has('traseira_triangulo_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('traseira_triangulo_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.traseira_triangulo_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->traseira_triangulo_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Traseira">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="entries-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="form-group {{ $errors->has('lateral_direita_lateral') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_direita_lateral" value="0">
                                                            <input type="checkbox" name="lateral_direita_lateral" id="lateral_direita_lateral" value="1" {{ $vehicleManageEntry->lateral_direita_lateral || old('lateral_direita_lateral', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_direita_lateral" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_lateral') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_direita_lateral'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_direita_lateral') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_lateral_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_direita_porta_tras') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_direita_porta_tras" value="0">
                                                            <input type="checkbox" name="lateral_direita_porta_tras" id="lateral_direita_porta_tras" value="1" {{ $vehicleManageEntry->lateral_direita_porta_tras || old('lateral_direita_porta_tras', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_direita_porta_tras" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_tras') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_direita_porta_tras'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_direita_porta_tras') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_tras_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_direita_porta_diant') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_direita_porta_diant" value="0">
                                                            <input type="checkbox" name="lateral_direita_porta_diant" id="lateral_direita_porta_diant" value="1" {{ $vehicleManageEntry->lateral_direita_porta_diant || old('lateral_direita_porta_diant', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_direita_porta_diant" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_diant') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_direita_porta_diant'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_direita_porta_diant') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_diant_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_direita_retrovisor') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_direita_retrovisor" value="0">
                                                            <input type="checkbox" name="lateral_direita_retrovisor" id="lateral_direita_retrovisor" value="1" {{ $vehicleManageEntry->lateral_direita_retrovisor || old('lateral_direita_retrovisor', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_direita_retrovisor" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_retrovisor') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_direita_retrovisor'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_direita_retrovisor') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_retrovisor_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_direita_paralama_diant') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_direita_paralama_diant" value="0">
                                                            <input type="checkbox" name="lateral_direita_paralama_diant" id="lateral_direita_paralama_diant" value="1" {{ $vehicleManageEntry->lateral_direita_paralama_diant || old('lateral_direita_paralama_diant', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_direita_paralama_diant" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_paralama_diant') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_direita_paralama_diant'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_direita_paralama_diant') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_paralama_diant_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('lateral_direita_nada_consta') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="lateral_direita_nada_consta" value="0">
                                                            <input type="checkbox" name="lateral_direita_nada_consta" id="lateral_direita_nada_consta" value="1" {{ $vehicleManageEntry->lateral_direita_nada_consta || old('lateral_direita_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="lateral_direita_nada_consta" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_nada_consta') }}</label>
                                                        </div>
                                                        @if($errors->has('lateral_direita_nada_consta'))
                                                        <span class="help-block" role="alert">{{ $errors->first('lateral_direita_nada_consta') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_nada_consta_helper') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('lateral_direita_obs') ? 'has-error' : '' }}">
                                                <label for="lateral_direita_obs">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_obs') }}</label>
                                                <textarea class="form-control" name="lateral_direita_obs" id="lateral_direita_obs">{{ old('lateral_direita_obs', $vehicleManageEntry->lateral_direita_obs) }}</textarea>
                                                @if($errors->has('lateral_direita_obs'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_direita_obs') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_obs_helper') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_direita_lateral_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_direita_lateral_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_lateral_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_direita_lateral_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_direita_lateral_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_direita_lateral_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_lateral_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_direita_lateral_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral direita">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_direita_porta_tras_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_direita_porta_tras_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_tras_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_direita_porta_tras_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_direita_porta_tras_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_direita_porta_tras_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_tras_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_direita_porta_tras_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral direita">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_direita_porta_diant_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_direita_porta_diant_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_diant_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_direita_porta_diant_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_direita_porta_diant_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_direita_porta_diant_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_diant_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_direita_porta_diant_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral direita">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_direita_retrovisor_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_direita_retrovisor_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_retrovisor_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_direita_retrovisor_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_direita_retrovisor_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_direita_retrovisor_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_retrovisor_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_direita_retrovisor_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral direita">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('lateral_direita_paralama_diant_photos') ? 'has-error' : '' }}">
                                                <label for="lateral_direita_paralama_diant_photos">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_paralama_diant_photos') }}</label>
                                                <div class="needsclick dropzone" id="lateral_direita_paralama_diant_photos-dropzone">
                                                </div>
                                                @if($errors->has('lateral_direita_paralama_diant_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('lateral_direita_paralama_diant_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.lateral_direita_paralama_diant_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->lateral_direita_paralama_diant_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Lateral direita">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="entries-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    Cinzeiro / atraso (vestígios de cinza)
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group {{ $errors->has('cinzeiro_sim') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="cinzeiro_sim" value="0">
                                                            <input type="checkbox" name="cinzeiro_sim" id="cinzeiro_sim" value="1" {{ $vehicleManageEntry->cinzeiro_sim || old('cinzeiro_sim', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="cinzeiro_sim" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_sim') }}</label>
                                                        </div>
                                                        @if($errors->has('cinzeiro_sim'))
                                                        <span class="help-block" role="alert">{{ $errors->first('cinzeiro_sim') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_sim_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('cinzeiro_nada_consta') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="cinzeiro_nada_consta" value="0">
                                                            <input type="checkbox" name="cinzeiro_nada_consta" id="cinzeiro_nada_consta" value="1" {{ $vehicleManageEntry->cinzeiro_nada_consta || old('cinzeiro_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="cinzeiro_nada_consta" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_nada_consta') }}</label>
                                                        </div>
                                                        @if($errors->has('cinzeiro_nada_consta'))
                                                        <span class="help-block" role="alert">{{ $errors->first('cinzeiro_nada_consta') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_nada_consta_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('cinzeiro_minutos') ? 'has-error' : '' }}">
                                                        <label for="cinzeiro_minutos">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_minutos') }}</label>
                                                        <input class="form-control" type="number" name="cinzeiro_minutos" id="cinzeiro_minutos" value="{{ old('cinzeiro_minutos', $vehicleManageEntry->cinzeiro_minutos) }}" step="1">
                                                        @if($errors->has('cinzeiro_minutos'))
                                                        <span class="help-block" role="alert">{{ $errors->first('cinzeiro_minutos') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_minutos_helper') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    Telemóvel
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group {{ $errors->has('telemovel_sim') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="telemovel_sim" value="0">
                                                            <input type="checkbox" name="telemovel_sim" id="telemovel_sim" value="1" {{ $vehicleManageEntry->telemovel_sim || old('telemovel_sim', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="telemovel_sim" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.telemovel_sim') }}</label>
                                                        </div>
                                                        @if($errors->has('telemovel_sim'))
                                                        <span class="help-block" role="alert">{{ $errors->first('telemovel_sim') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.telemovel_sim_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('telemovel_nada_consta') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="telemovel_nada_consta" value="0">
                                                            <input type="checkbox" name="telemovel_nada_consta" id="telemovel_nada_consta" value="1" {{ $vehicleManageEntry->telemovel_nada_consta || old('telemovel_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="telemovel_nada_consta" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.telemovel_nada_consta') }}</label>
                                                        </div>
                                                        @if($errors->has('telemovel_nada_consta'))
                                                        <span class="help-block" role="alert">{{ $errors->first('telemovel_nada_consta') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.telemovel_nada_consta_helper') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    Diversos
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group {{ $errors->has('possui_triangulo') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="possui_triangulo" value="0">
                                                            <input type="checkbox" name="possui_triangulo" id="possui_triangulo" value="1" {{ $vehicleManageEntry->possui_triangulo || old('possui_triangulo', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="possui_triangulo" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.possui_triangulo') }}</label>
                                                        </div>
                                                        @if($errors->has('possui_triangulo'))
                                                        <span class="help-block" role="alert">{{ $errors->first('possui_triangulo') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.possui_triangulo_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('possui_extintor') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="possui_extintor" value="0">
                                                            <input type="checkbox" name="possui_extintor" id="possui_extintor" value="1" {{ $vehicleManageEntry->possui_extintor || old('possui_extintor', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="possui_extintor" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.possui_extintor') }}</label>
                                                        </div>
                                                        @if($errors->has('possui_extintor'))
                                                        <span class="help-block" role="alert">{{ $errors->first('possui_extintor') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.possui_extintor_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('colete') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="colete" value="0">
                                                            <input type="checkbox" name="colete" id="colete" value="1" {{ $vehicleManageEntry->colete || old('colete', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="colete" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.colete') }}</label>
                                                        </div>
                                                        @if($errors->has('colete'))
                                                        <span class="help-block" role="alert">{{ $errors->first('colete') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.colete_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('disticos') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="disticos" value="0">
                                                            <input type="checkbox" name="disticos" id="disticos" value="1" {{ $vehicleManageEntry->disticos || old('disticos', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="disticos" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.disticos') }}</label>
                                                        </div>
                                                        @if($errors->has('disticos'))
                                                        <span class="help-block" role="alert">{{ $errors->first('disticos') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.disticos_helper') }}</span>
                                                    </div>
                                                    <div class="form-group {{ $errors->has('via_verde') ? 'has-error' : '' }}">
                                                        <div>
                                                            <input type="hidden" name="via_verde" value="0">
                                                            <input type="checkbox" name="via_verde" id="via_verde" value="1" {{ $vehicleManageEntry->via_verde || old('via_verde', 0) === 1 ? 'checked' : '' }}>
                                                            <label for="via_verde" style="font-weight: 400">{{ trans('cruds.vehicleManageEntry.fields.via_verde') }}</label>
                                                        </div>
                                                        @if($errors->has('via_verde'))
                                                        <span class="help-block" role="alert">{{ $errors->first('via_verde') }}</span>
                                                        @endif
                                                        <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.via_verde_helper') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('cinzeiro_photos') ? 'has-error' : '' }}">
                                                <label for="cinzeiro_photos">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_photos') }}</label>
                                                <div class="needsclick dropzone" id="cinzeiro_photos-dropzone">
                                                </div>
                                                @if($errors->has('cinzeiro_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('cinzeiro_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.cinzeiro_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->cinzeiro_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Cinzeiro | Diversos">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {{ $errors->has('telemovel_photos') ? 'has-error' : '' }}">
                                                <label for="telemovel_photos">{{ trans('cruds.vehicleManageEntry.fields.telemovel_photos') }}</label>
                                                <div class="needsclick dropzone" id="telemovel_photos-dropzone">
                                                </div>
                                                @if($errors->has('telemovel_photos'))
                                                <span class="help-block" role="alert">{{ $errors->first('telemovel_photos') }}</span>
                                                @endif
                                                <span class="help-block">{{ trans('cruds.vehicleManageEntry.fields.telemovel_photos_helper') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>&nbsp;</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach ($vehicleManageEntry->telemovel_photos as $media)
                                                    <a href="{{ $media->getUrl() }}" data-lightbox="galeria" data-title="Cinzeiro | Diversos">
                                                        <img src="{{ $media->getUrl('preview') }}" class="img-thumbnail">
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="entries-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                @if ($vehicleManageEntry->signature_driver_data &&
                                                $vehicleManageEntry->signature_collector_data)
                                                <div class="col-md-12">
                                                    <div class="alert alert-success" role="alert">As assinaturas já foram recolhidas</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="signature-collector">Recolha da viatura:</label><br>
                                                    <img src="{{ $vehicleManageEntry->signature_collector_data }}" alt="Assinatura de quem recolhe a viatura" style="border:1px solid #000; width: 400px; height: 150px;">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="signature-driver">Motorista:</label><br>
                                                    <img src="{{ $vehicleManageEntry->signature_driver_data }}" alt="Assinatura do motorista" style="border:1px solid #000; width: 400px; height: 150px;">
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                    <label for="signature-collector">Recolha da viatura:</label><br>
                                                    <canvas id="signature-collector" width="400" height="150" style="border:1px solid #000;"></canvas><br>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="clearCanvas('signature-collector')">Limpar</button>
                                                    <input type="hidden" name="signature_collector_data" id="signature-collector-data">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="signature-driver">Motorista:</label><br>
                                                    <canvas id="signature-driver" width="400" height="150" style="border:1px solid #000;"></canvas><br>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="clearCanvas('signature-driver')">Limpar</button>
                                                    <input type="hidden" name="signature_driver_data" id="signature-driver-data">
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            @if ($vehicleManageEntry->signature_driver_data &&
                                            $vehicleManageEntry->signature_collector_data)
                                            <button class="btn btn-success" type="submit">
                                                Concluir
                                            </button>
                                            @else
                                            <button class="btn btn-success" type="submit" onclick="return saveSignatures();">
                                                Gravar assinaturas e concluir
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</form>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox.min.js"></script>

<script>
    var uploadedFrenteDoVeiculoTetoPhotosMap = {}
Dropzone.options.frenteDoVeiculoTetoPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_do_veiculo_teto_photos[]" value="' + response.name + '">')
      uploadedFrenteDoVeiculoTetoPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteDoVeiculoTetoPhotosMap[file.name]
      }
      $('form').find('input[name="frente_do_veiculo_teto_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->frente_do_veiculo_teto_photos)
          var files =
            {!! json_encode($vehicleManageEntry->frente_do_veiculo_teto_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="frente_do_veiculo_teto_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedFrenteDoVeiculoParabrisaPhotosMap = {}
Dropzone.options.frenteDoVeiculoParabrisaPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_do_veiculo_parabrisa_photos[]" value="' + response.name + '">')
      uploadedFrenteDoVeiculoParabrisaPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteDoVeiculoParabrisaPhotosMap[file.name]
      }
      $('form').find('input[name="frente_do_veiculo_parabrisa_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->frente_do_veiculo_parabrisa_photos)
          var files =
            {!! json_encode($vehicleManageEntry->frente_do_veiculo_parabrisa_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="frente_do_veiculo_parabrisa_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedFrenteDoVeiculoCapoPhotosMap = {}
Dropzone.options.frenteDoVeiculoCapoPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_do_veiculo_capo_photos[]" value="' + response.name + '">')
      uploadedFrenteDoVeiculoCapoPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteDoVeiculoCapoPhotosMap[file.name]
      }
      $('form').find('input[name="frente_do_veiculo_capo_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->frente_do_veiculo_capo_photos)
          var files =
            {!! json_encode($vehicleManageEntry->frente_do_veiculo_capo_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="frente_do_veiculo_capo_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedFrenteDoVeiculoParachoquePhotosMap = {}
Dropzone.options.frenteDoVeiculoParachoquePhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_do_veiculo_parachoque_photos[]" value="' + response.name + '">')
      uploadedFrenteDoVeiculoParachoquePhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteDoVeiculoParachoquePhotosMap[file.name]
      }
      $('form').find('input[name="frente_do_veiculo_parachoque_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->frente_do_veiculo_parachoque_photos)
          var files =
            {!! json_encode($vehicleManageEntry->frente_do_veiculo_parachoque_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="frente_do_veiculo_parachoque_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedChavesPhotosMap = {}
Dropzone.options.chavesPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="chaves_photos[]" value="' + response.name + '">')
      uploadedChavesPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedChavesPhotosMap[file.name]
      }
      $('form').find('input[name="chaves_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->chaves_photos)
          var files =
            {!! json_encode($vehicleManageEntry->chaves_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="chaves_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralEsquerdaParalamaDiantPhotosMap = {}
Dropzone.options.lateralEsquerdaParalamaDiantPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_paralama_diant_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaParalamaDiantPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralEsquerdaParalamaDiantPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_esquerda_paralama_diant_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_esquerda_paralama_diant_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_esquerda_paralama_diant_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_esquerda_paralama_diant_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralEsquerdaRetrovisorPhotosMap = {}
Dropzone.options.lateralEsquerdaRetrovisorPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_retrovisor_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaRetrovisorPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralEsquerdaRetrovisorPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_esquerda_retrovisor_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_esquerda_retrovisor_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_esquerda_retrovisor_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_esquerda_retrovisor_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralEsquerdaPortaDiantPhotosMap = {}
Dropzone.options.lateralEsquerdaPortaDiantPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_porta_diant_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaPortaDiantPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralEsquerdaPortaDiantPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_esquerda_porta_diant_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_esquerda_porta_diant_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_esquerda_porta_diant_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_esquerda_porta_diant_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralEsquerdaPortaTrasPhotosMap = {}
Dropzone.options.lateralEsquerdaPortaTrasPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_porta_tras_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaPortaTrasPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralEsquerdaPortaTrasPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_esquerda_porta_tras_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_esquerda_porta_tras_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_esquerda_porta_tras_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_esquerda_porta_tras_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralEsquerdaLateralPhotosMap = {}
Dropzone.options.lateralEsquerdaLateralPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_lateral_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaLateralPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralEsquerdaLateralPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_esquerda_lateral_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_esquerda_lateral_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_esquerda_lateral_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_esquerda_lateral_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraTampaTraseiraPhotosMap = {}
Dropzone.options.traseiraTampaTraseiraPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_tampa_traseira_photos[]" value="' + response.name + '">')
      uploadedTraseiraTampaTraseiraPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraTampaTraseiraPhotosMap[file.name]
      }
      $('form').find('input[name="traseira_tampa_traseira_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_tampa_traseira_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_tampa_traseira_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_tampa_traseira_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraLanternasDirPhotosMap = {}
Dropzone.options.traseiraLanternasDirPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_lanternas_dir_photos[]" value="' + response.name + '">')
      uploadedTraseiraLanternasDirPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraLanternasDirPhotosMap[file.name]
      }
      $('form').find('input[name="traseira_lanternas_dir_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_lanternas_dir_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_lanternas_dir_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_lanternas_dir_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraLanternaEsqPhotosMap = {}
Dropzone.options.traseiraLanternaEsqPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_lanterna_esq_photos[]" value="' + response.name + '">')
      uploadedTraseiraLanternaEsqPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraLanternaEsqPhotosMap[file.name]
      }
      $('form').find('input[name="traseira_lanterna_esq_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_lanterna_esq_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_lanterna_esq_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_lanterna_esq_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraParachoqueTrasPhotosMap = {}
Dropzone.options.traseiraParachoqueTrasPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_parachoque_tras_photos[]" value="' + response.name + '">')
      uploadedTraseiraParachoqueTrasPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraParachoqueTrasPhotosMap[file.name]
      }
      $('form').find('input[name="traseira_parachoque_tras_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_parachoque_tras_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_parachoque_tras_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_parachoque_tras_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraEstepePhotosMap = {}
Dropzone.options.traseiraEstepePhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_estepe_photos[]" value="' + response.name + '">')
      uploadedTraseiraEstepePhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraEstepePhotosMap[file.name]
      }
      $('form').find('input[name="traseira_estepe_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_estepe_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_estepe_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_estepe_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraMacacoPhotosMap = {}
Dropzone.options.traseiraMacacoPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_macaco_photos[]" value="' + response.name + '">')
      uploadedTraseiraMacacoPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraMacacoPhotosMap[file.name]
      }
      $('form').find('input[name="traseira_macaco_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_macaco_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_macaco_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_macaco_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraChaveDeRodaPhotosMap = {}
Dropzone.options.traseiraChaveDeRodaPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_chave_de_roda_photos[]" value="' + response.name + '">')
      uploadedTraseiraChaveDeRodaPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraChaveDeRodaPhotosMap[file.name]
      }
      $('form').find('input[name="traseira_chave_de_roda_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_chave_de_roda_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_chave_de_roda_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_chave_de_roda_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTraseiraTrianguloPhotosMap = {}
Dropzone.options.traseiraTrianguloPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_triangulo_photos[]" value="' + response.name + '">')
      uploadedTraseiraTrianguloPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTraseiraTrianguloPhotosMap[file.name]
      }
      $('form').find('input[name="traseira_triangulo_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->traseira_triangulo_photos)
          var files =
            {!! json_encode($vehicleManageEntry->traseira_triangulo_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="traseira_triangulo_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralDireitaLateralPhotosMap = {}
Dropzone.options.lateralDireitaLateralPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_lateral_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaLateralPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralDireitaLateralPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_direita_lateral_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_direita_lateral_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_direita_lateral_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_direita_lateral_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralDireitaPortaTrasPhotosMap = {}
Dropzone.options.lateralDireitaPortaTrasPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_porta_tras_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaPortaTrasPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralDireitaPortaTrasPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_direita_porta_tras_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_direita_porta_tras_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_direita_porta_tras_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_direita_porta_tras_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralDireitaPortaDiantPhotosMap = {}
Dropzone.options.lateralDireitaPortaDiantPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_porta_diant_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaPortaDiantPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralDireitaPortaDiantPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_direita_porta_diant_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_direita_porta_diant_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_direita_porta_diant_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_direita_porta_diant_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralDireitaRetrovisorPhotosMap = {}
Dropzone.options.lateralDireitaRetrovisorPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_retrovisor_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaRetrovisorPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralDireitaRetrovisorPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_direita_retrovisor_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_direita_retrovisor_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_direita_retrovisor_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_direita_retrovisor_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedLateralDireitaParalamaDiantPhotosMap = {}
Dropzone.options.lateralDireitaParalamaDiantPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_paralama_diant_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaParalamaDiantPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralDireitaParalamaDiantPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_direita_paralama_diant_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->lateral_direita_paralama_diant_photos)
          var files =
            {!! json_encode($vehicleManageEntry->lateral_direita_paralama_diant_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="lateral_direita_paralama_diant_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedCinzeiroPhotosMap = {}
Dropzone.options.cinzeiroPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="cinzeiro_photos[]" value="' + response.name + '">')
      uploadedCinzeiroPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedCinzeiroPhotosMap[file.name]
      }
      $('form').find('input[name="cinzeiro_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->cinzeiro_photos)
          var files =
            {!! json_encode($vehicleManageEntry->cinzeiro_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="cinzeiro_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedTelemovelPhotosMap = {}
Dropzone.options.telemovelPhotosDropzone = {
    url: '{{ route('admin.vehicle-manage-entries.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="telemovel_photos[]" value="' + response.name + '">')
      uploadedTelemovelPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedTelemovelPhotosMap[file.name]
      }
      $('form').find('input[name="telemovel_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleManageEntry) && $vehicleManageEntry->telemovel_photos)
          var files =
            {!! json_encode($vehicleManageEntry->telemovel_photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="telemovel_photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
  <script>
    function initCanvas(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    let drawing = false;
    let lastX = 0;
    let lastY = 0;

    // Função para iniciar o desenho com mouse ou toque
    function startDrawing(x, y) {
        drawing = true;
        lastX = x;
        lastY = y;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
    }

    // Função para desenhar com mouse ou toque
    function draw(x, y) {
        if (!drawing) return;
        ctx.lineTo(x, y);
        ctx.stroke();
        lastX = x;
        lastY = y;
    }

    // Função para parar o desenho
    function stopDrawing() {
        drawing = false;
    }

    // Eventos de mouse
    canvas.addEventListener("mousedown", (e) => {
        startDrawing(e.offsetX, e.offsetY);
    });

    canvas.addEventListener("mousemove", (e) => {
        draw(e.offsetX, e.offsetY);
    });

    canvas.addEventListener("mouseup", stopDrawing);
    canvas.addEventListener("mouseout", stopDrawing);

    // Eventos de toque
    canvas.addEventListener("touchstart", (e) => {
        e.preventDefault(); // Impedir o comportamento padrão de rolagem
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        startDrawing(touch.clientX - rect.left, touch.clientY - rect.top);
    });

    canvas.addEventListener("touchmove", (e) => {
        e.preventDefault(); // Impedir o comportamento padrão de rolagem
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        draw(touch.clientX - rect.left, touch.clientY - rect.top);
    });

    canvas.addEventListener("touchend", stopDrawing);
    canvas.addEventListener("touchcancel", stopDrawing); // Android às vezes cancela o toque
}

// Função para limpar o canvas
function clearCanvas(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpa o canvas
}

// Função para verificar se o canvas está vazio
function isCanvasEmpty(canvas) {
    const blank = document.createElement('canvas'); // Cria um canvas temporário
    blank.width = canvas.width;
    blank.height = canvas.height;

    // Compara o conteúdo do canvas com o canvas em branco
    return canvas.toDataURL() === blank.toDataURL();
}

// Função para salvar as assinaturas dos canvases
function saveSignatures() {
    const collectorCanvas = document.getElementById('signature-collector');
    const driverCanvas = document.getElementById('signature-driver');

    // Verifica se os canvas estão vazios
    if (isCanvasEmpty(collectorCanvas)) {
        alert("A assinatura de quem recolhe a viatura está vazia.");
        return false;
    }

    if (isCanvasEmpty(driverCanvas)) {
        alert("A assinatura do motorista está vazia.");
        return false;
    }

    // Se os dois canvas não estiverem vazios, salva as assinaturas
    const collectorDataURL = collectorCanvas.toDataURL();
    const driverDataURL = driverCanvas.toDataURL();

    // Salva a assinatura convertida nos campos hidden
    document.getElementById('signature-collector-data').value = collectorDataURL;
    document.getElementById('signature-driver-data').value = driverDataURL;

    return true; // Permite que o formulário seja submetido
}

// Inicializar os canvases ao carregar a página
window.onload = function() {
    initCanvas('signature-collector');
    initCanvas('signature-driver');
};

</script>
@endsection
