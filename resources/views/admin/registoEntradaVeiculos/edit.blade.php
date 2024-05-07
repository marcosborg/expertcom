@extends('layouts.admin')
@section('content')
<div class="content">
    <form method="POST" action="{{ route("admin.registo-entrada-veiculos.update", [$registoEntradaVeiculo->id]) }}"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        CHECK LIST
                    </div>
                    <div class="panel-body">
                        @if (auth()->user()->hasRole('tecnico'))
                        <div class="form-group">
                            <label>{{ trans('cruds.registoEntradaVeiculo.fields.data_e_horario') }}</label>
                            <input class="form-control datetime" type="text"
                                value="{{ old('data_e_horario', $registoEntradaVeiculo->data_e_horario) }}" disabled>
                            <input type="hidden" name="data_e_horario" id="data_e_horario"
                                value="{{ old('data_e_horario', $registoEntradaVeiculo->data_e_horario) }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.registoEntradaVeiculo.fields.user') }}</label>
                            <select class="form-control select2" disabled>
                                @foreach($users as $id => $entry)
                                <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $registoEntradaVeiculo->
                                    user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="user_id" id="user_id"
                                value="{{ $registoEntradaVeiculo->user->id }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.registoEntradaVeiculo.fields.driver') }}</label>
                            <select class="form-control select2" disabled>
                                @foreach($drivers as $id => $entry)
                                <option value="{{ $id }}" {{ (old('driver_id') ? old('driver_id') :
                                    $registoEntradaVeiculo->driver->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="driver_id" id="driver_id"
                                value="{{ $registoEntradaVeiculo->driver->id }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.registoEntradaVeiculo.fields.vehicle_item') }}</label>
                            <select class="form-control select2" disabled>
                                @foreach($vehicle_items as $id => $entry)
                                <option value="{{ $id }}" {{ (old('vehicle_item_id') ? old('vehicle_item_id') :
                                    $registoEntradaVeiculo->vehicle_item->id ?? '') == $id ? 'selected' : '' }}>{{
                                    $entry }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="vehicle_item_id" id="vehicle_item_id"
                                value="{{ $registoEntradaVeiculo->vehicle_item->id }}">
                        </div>
                        @else
                        <div class="form-group {{ $errors->has('data_e_horario') ? 'has-error' : '' }}">
                            <label for="data_e_horario">{{ trans('cruds.registoEntradaVeiculo.fields.data_e_horario')
                                }}</label>
                            <input class="form-control datetime" type="text" name="data_e_horario" id="data_e_horario"
                                value="{{ old('data_e_horario', $registoEntradaVeiculo->data_e_horario) }}">
                            @if($errors->has('data_e_horario'))
                            <span class="help-block" role="alert">{{ $errors->first('data_e_horario') }}</span>
                            @endif
                            <span class="help-block">{{
                                trans('cruds.registoEntradaVeiculo.fields.data_e_horario_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                            <label class="required" for="user_id">{{ trans('cruds.registoEntradaVeiculo.fields.user')
                                }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $registoEntradaVeiculo->
                                    user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                            <span class="help-block" role="alert">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.registoEntradaVeiculo.fields.user_helper')
                                }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">
                            <label class="required" for="driver_id">{{
                                trans('cruds.registoEntradaVeiculo.fields.driver') }}</label>
                            <select class="form-control select2" name="driver_id" id="driver_id" required>
                                @foreach($drivers as $id => $entry)
                                <option value="{{ $id }}" {{ (old('driver_id') ? old('driver_id') :
                                    $registoEntradaVeiculo->driver->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('driver'))
                            <span class="help-block" role="alert">{{ $errors->first('driver') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.registoEntradaVeiculo.fields.driver_helper')
                                }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('vehicle_item') ? 'has-error' : '' }}">
                            <label class="required" for="vehicle_item_id">{{
                                trans('cruds.registoEntradaVeiculo.fields.vehicle_item') }}</label>
                            <select class="form-control select2" name="vehicle_item_id" id="vehicle_item_id" required>
                                @foreach($vehicle_items as $id => $entry)
                                <option value="{{ $id }}" {{ (old('vehicle_item_id') ? old('vehicle_item_id') :
                                    $registoEntradaVeiculo->vehicle_item->id ?? '') == $id ? 'selected' : '' }}>{{
                                    $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vehicle_item'))
                            <span class="help-block" role="alert">{{ $errors->first('vehicle_item') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.registoEntradaVeiculo.fields.vehicle_item_helper')
                                }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('bateria_a_chegada') ? 'has-error' : '' }}">
                            <label class="required" for="bateria_a_chegada">{{
                                trans('cruds.registoEntradaVeiculo.fields.bateria_a_chegada') }}</label>
                            <input class="form-control" type="text" name="bateria_a_chegada" id="bateria_a_chegada"
                                value="{{ old('bateria_a_chegada', $registoEntradaVeiculo->bateria_a_chegada) }}"
                                required>
                            @if($errors->has('bateria_a_chegada'))
                            <span class="help-block" role="alert">{{ $errors->first('bateria_a_chegada') }}</span>
                            @endif
                            <span class="help-block">{{
                                trans('cruds.registoEntradaVeiculo.fields.bateria_a_chegada_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('de_bateria_de_saida') ? 'has-error' : '' }}">
                            <label class="required" for="de_bateria_de_saida">{{
                                trans('cruds.registoEntradaVeiculo.fields.de_bateria_de_saida') }}</label>
                            <input class="form-control" type="text" name="de_bateria_de_saida" id="de_bateria_de_saida"
                                value="{{ old('de_bateria_de_saida', $registoEntradaVeiculo->de_bateria_de_saida) }}"
                                required>
                            @if($errors->has('de_bateria_de_saida'))
                            <span class="help-block" role="alert">{{ $errors->first('de_bateria_de_saida') }}</span>
                            @endif
                            <span class="help-block">{{
                                trans('cruds.registoEntradaVeiculo.fields.de_bateria_de_saida_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('km_atual') ? 'has-error' : '' }}">
                            <label class="required" for="km_atual">{{
                                trans('cruds.registoEntradaVeiculo.fields.km_atual') }}</label>
                            <input class="form-control" type="text" name="km_atual" id="km_atual"
                                value="{{ old('km_atual', $registoEntradaVeiculo->km_atual) }}" required>
                            @if($errors->has('km_atual'))
                            <span class="help-block" role="alert">{{ $errors->first('km_atual') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.registoEntradaVeiculo.fields.km_atual_helper')
                                }}</span>
                        </div>
                        @endif
                        <div class="form-group {{ $errors->has('bateria_a_chegada') ? 'has-error' : '' }}">
                            <label class="required" for="bateria_a_chegada">{{
                                trans('cruds.registoEntradaVeiculo.fields.bateria_a_chegada') }}</label>
                            <input class="form-control" type="text" name="bateria_a_chegada" id="bateria_a_chegada"
                                value="{{ old('bateria_a_chegada', $registoEntradaVeiculo->bateria_a_chegada) }}"
                                required>
                            @if($errors->has('bateria_a_chegada'))
                            <span class="help-block" role="alert">{{ $errors->first('bateria_a_chegada') }}</span>
                            @endif
                            <span class="help-block">{{
                                trans('cruds.registoEntradaVeiculo.fields.bateria_a_chegada_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('de_bateria_de_saida') ? 'has-error' : '' }}">
                            <label class="required" for="de_bateria_de_saida">{{
                                trans('cruds.registoEntradaVeiculo.fields.de_bateria_de_saida') }}</label>
                            <input class="form-control" type="text" name="de_bateria_de_saida" id="de_bateria_de_saida"
                                value="{{ old('de_bateria_de_saida', $registoEntradaVeiculo->de_bateria_de_saida) }}"
                                required>
                            @if($errors->has('de_bateria_de_saida'))
                            <span class="help-block" role="alert">{{ $errors->first('de_bateria_de_saida') }}</span>
                            @endif
                            <span class="help-block">{{
                                trans('cruds.registoEntradaVeiculo.fields.de_bateria_de_saida_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('km_atual') ? 'has-error' : '' }}">
                            <label class="required" for="km_atual">{{
                                trans('cruds.registoEntradaVeiculo.fields.km_atual') }}</label>
                            <input class="form-control" type="text" name="km_atual" id="km_atual"
                                value="{{ old('km_atual', $registoEntradaVeiculo->km_atual) }}" required>
                            @if($errors->has('km_atual'))
                            <span class="help-block" role="alert">{{ $errors->first('km_atual') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.registoEntradaVeiculo.fields.km_atual_helper')
                                }}</span>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit" name="save" value="true">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <ul class="nav nav-tabs">
                    <li role="presentation" {{ request()->query('step') == 1 ? 'class=active' : '' }}><a>1º
                            Check de Danos Visiveis do Carro</a></li>
                    <li role="presentation" {{ request()->query('step') == 2 ? 'class=active' : '' }}><a>2º
                            Passo - Checkagem de aspiração(10 minutos)</a></li>
                    <li role="presentation" {{ request()->query('step') == 3 ? 'class=active' : '' }}><a>3º
                            Passo - Documentação</a></li>
                    <li role="presentation" {{ request()->query('step') == 4 ? 'class=active' : '' }}><a>4º
                            Passo - Checkagem de aspiração</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (request()->query('step') == 1)
                        <input type="hidden" name="step" value="1">
                        <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne1">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion1"
                                            href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                            Frente
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingOne1">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('frente_teto') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="frente_teto" value="0">
                                                        <input type="checkbox" name="frente_teto" id="frente_teto"
                                                            value="1" {{ $registoEntradaVeiculo->frente_teto ||
                                                        old('frente_teto', 0) === 1 ?
                                                        'checked' : '' }}>
                                                        <label for="frente_teto" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.frente_teto')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('frente_teto'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_teto')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_teto_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_parabrisa') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="frente_parabrisa" value="0">
                                                        <input type="checkbox" name="frente_parabrisa"
                                                            id="frente_parabrisa" value="1" {{
                                                            $registoEntradaVeiculo->frente_parabrisa ||
                                                        old('frente_parabrisa', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="frente_parabrisa" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.frente_parabrisa')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('frente_parabrisa'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_parabrisa')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_parabrisa_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_capo') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="frente_capo" value="0">
                                                        <input type="checkbox" name="frente_capo" id="frente_capo"
                                                            value="1" {{ $registoEntradaVeiculo->frente_capo ||
                                                        old('frente_capo', 0) === 1 ?
                                                        'checked' : '' }}>
                                                        <label for="frente_capo" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.frente_capo')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('frente_capo'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_capo')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_capo_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_parachoque') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="frente_parachoque" value="0">
                                                        <input type="checkbox" name="frente_parachoque"
                                                            id="frente_parachoque" value="1" {{
                                                            $registoEntradaVeiculo->frente_parachoque ||
                                                        old('frente_parachoque', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="frente_parachoque" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.frente_parachoque')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('frente_parachoque'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_parachoque')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_parachoque_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_nada_consta') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="frente_nada_consta" value="0">
                                                        <input type="checkbox" name="frente_nada_consta"
                                                            id="frente_nada_consta" value="1" {{
                                                            $registoEntradaVeiculo->frente_nada_consta ||
                                                        old('frente_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="frente_nada_consta" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.frente_nada_consta')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('frente_nada_consta'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_nada_consta') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_nada_consta_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_obs') ? 'has-error' : '' }}">
                                                    <label for="frente_obs">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_obs')
                                                        }}</label>
                                                    <textarea class="form-control" name="frente_obs"
                                                        id="frente_obs">{{ old('frente_obs', $registoEntradaVeiculo->frente_obs) }}</textarea>
                                                    @if($errors->has('frente_obs'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_obs')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_obs_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('frente_teto_photos') ? 'has-error' : '' }}">
                                                    <label for="frente_teto_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_teto_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone" id="frente_teto_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('frente_teto_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_teto_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_teto_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_parabrisa_photos') ? 'has-error' : '' }}">
                                                    <label for="frente_parabrisa_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_parabrisa_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="frente_parabrisa_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('frente_parabrisa_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_parabrisa_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_parabrisa_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_capo_photos') ? 'has-error' : '' }}">
                                                    <label for="frente_capo_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_capo_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone" id="frente_capo_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('frente_capo_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_capo_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_capo_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('frente_parachoque_photos') ? 'has-error' : '' }}">
                                                    <label for="frente_parachoque_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_parachoque_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="frente_parachoque_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('frente_parachoque_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('frente_parachoque_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.frente_parachoque_photos_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo1">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordion1" href="#collapseTwo1" aria-expanded="false"
                                            aria-controls="collapseTwo1">
                                            Lateral esquerda
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingTwo1">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_paralama_diant') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_esquerda_paralama_diant"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_esquerda_paralama_diant"
                                                            id="lateral_esquerda_paralama_diant" value="1" {{
                                                            $registoEntradaVeiculo->lateral_esquerda_paralama_diant ||
                                                        old('lateral_esquerda_paralama_diant', 0) === 1 ? 'checked' : ''
                                                        }}>
                                                        <label for="lateral_esquerda_paralama_diant"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_paralama_diant')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_paralama_diant'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_paralama_diant') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_paralama_diant_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_retrovisor') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_esquerda_retrovisor"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_esquerda_retrovisor"
                                                            id="lateral_esquerda_retrovisor" value="1" {{
                                                            $registoEntradaVeiculo->lateral_esquerda_retrovisor ||
                                                        old('lateral_esquerda_retrovisor', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="lateral_esquerda_retrovisor"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_retrovisor')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_retrovisor'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_retrovisor') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_retrovisor_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_porta_dianteira') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_esquerda_porta_dianteira"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_esquerda_porta_dianteira"
                                                            id="lateral_esquerda_porta_dianteira" value="1" {{
                                                            $registoEntradaVeiculo->lateral_esquerda_porta_dianteira ||
                                                        old('lateral_esquerda_porta_dianteira', 0) === 1 ? 'checked' :
                                                        '' }}>
                                                        <label for="lateral_esquerda_porta_dianteira"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_dianteira')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_porta_dianteira'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_porta_dianteira') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_dianteira_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_porta_traseira') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_esquerda_porta_traseira"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_esquerda_porta_traseira"
                                                            id="lateral_esquerda_porta_traseira" value="1" {{
                                                            $registoEntradaVeiculo->lateral_esquerda_porta_traseira ||
                                                        old('lateral_esquerda_porta_traseira', 0) === 1 ? 'checked' : ''
                                                        }}>
                                                        <label for="lateral_esquerda_porta_traseira"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_traseira')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_porta_traseira'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_porta_traseira') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_traseira_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_lateral') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_esquerda_lateral" value="0">
                                                        <input type="checkbox" name="lateral_esquerda_lateral"
                                                            id="lateral_esquerda_lateral" value="1" {{
                                                            $registoEntradaVeiculo->lateral_esquerda_lateral ||
                                                        old('lateral_esquerda_lateral', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="lateral_esquerda_lateral"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_lateral')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_lateral'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_lateral') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_lateral_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_nada_consta') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_esquerda_nada_consta"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_esquerda_nada_consta"
                                                            id="lateral_esquerda_nada_consta" value="1" {{
                                                            $registoEntradaVeiculo->lateral_esquerda_nada_consta ||
                                                        old('lateral_esquerda_nada_consta', 0) === 1 ? 'checked' : ''
                                                        }}>
                                                        <label for="lateral_esquerda_nada_consta"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_nada_consta')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_nada_consta'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_nada_consta') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_nada_consta_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_obs') ? 'has-error' : '' }}">
                                                    <label for="lateral_esquerda_obs">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_obs')
                                                        }}</label>
                                                    <textarea class="form-control" name="lateral_esquerda_obs"
                                                        id="lateral_esquerda_obs">{{ old('lateral_esquerda_obs', $registoEntradaVeiculo->lateral_esquerda_obs) }}</textarea>
                                                    @if($errors->has('lateral_esquerda_obs'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_obs') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_obs_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_paralama_diant_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_esquerda_paralama_diant_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_paralama_diant_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_esquerda_paralama_diant_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_paralama_diant_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_paralama_diant_photos')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_paralama_diant_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_retrovisor_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_esquerda_retrovisor_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_retrovisor_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_esquerda_retrovisor_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_retrovisor_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_retrovisor_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_retrovisor_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_porta_dianteira_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_esquerda_porta_dianteira_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_dianteira_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_esquerda_porta_dianteira_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_porta_dianteira_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_porta_dianteira_photos')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_dianteira_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_porta_traseira_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_esquerda_porta_traseira_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_traseira_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_esquerda_porta_traseira_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_porta_traseira_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_porta_traseira_photos')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_traseira_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_esquerda_lateral_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_esquerda_lateral_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_lateral_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_esquerda_lateral_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_esquerda_lateral_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_esquerda_lateral_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_lateral_photos_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree1">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordion1" href="#collapseThree1" aria-expanded="false"
                                            aria-controls="collapseThree1">
                                            Traseira
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingThree1">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('traseira_mala') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_mala" value="0">
                                                        <input type="checkbox" name="traseira_mala" id="traseira_mala"
                                                            value="1" {{ $registoEntradaVeiculo->traseira_mala ||
                                                        old('traseira_mala', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_mala" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_mala')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_mala'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_mala') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_mala_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_farol_direito') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_farol_direito" value="0">
                                                        <input type="checkbox" name="traseira_farol_direito"
                                                            id="traseira_farol_direito" value="1" {{
                                                            $registoEntradaVeiculo->traseira_farol_direito ||
                                                        old('traseira_farol_direito', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_farol_direito" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_farol_direito')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_farol_direito'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_farol_direito') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_farol_direito_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_farol_esquerdo') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_farol_esquerdo" value="0">
                                                        <input type="checkbox" name="traseira_farol_esquerdo"
                                                            id="traseira_farol_esquerdo" value="1" {{
                                                            $registoEntradaVeiculo->traseira_farol_esquerdo ||
                                                        old('traseira_farol_esquerdo', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_farol_esquerdo" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_farol_esquerdo')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_farol_esquerdo'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_farol_esquerdo') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_farol_esquerdo_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_parachoque_traseiro') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_parachoque_traseiro"
                                                            value="0">
                                                        <input type="checkbox" name="traseira_parachoque_traseiro"
                                                            id="traseira_parachoque_traseiro" value="1" {{
                                                            $registoEntradaVeiculo->traseira_parachoque_traseiro ||
                                                        old('traseira_parachoque_traseiro', 0) === 1 ? 'checked' : ''
                                                        }}>
                                                        <label for="traseira_parachoque_traseiro"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_parachoque_traseiro')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_parachoque_traseiro'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_parachoque_traseiro') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_parachoque_traseiro_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_pneu_reserva') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_pneu_reserva" value="0">
                                                        <input type="checkbox" name="traseira_pneu_reserva"
                                                            id="traseira_pneu_reserva" value="1" {{
                                                            $registoEntradaVeiculo->traseira_pneu_reserva ||
                                                        old('traseira_pneu_reserva', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_pneu_reserva" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_pneu_reserva')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_pneu_reserva'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_pneu_reserva') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_pneu_reserva_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_macaco') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_macaco" value="0">
                                                        <input type="checkbox" name="traseira_macaco"
                                                            id="traseira_macaco" value="1" {{
                                                            $registoEntradaVeiculo->traseira_macaco ||
                                                        old('traseira_macaco', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_macaco" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_macaco')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_macaco'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_macaco') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_macaco_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_chave_de_roda') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_chave_de_roda" value="0">
                                                        <input type="checkbox" name="traseira_chave_de_roda"
                                                            id="traseira_chave_de_roda" value="1" {{
                                                            $registoEntradaVeiculo->traseira_chave_de_roda ||
                                                        old('traseira_chave_de_roda', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_chave_de_roda" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_chave_de_roda')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_chave_de_roda'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_chave_de_roda') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_chave_de_roda_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_triangulo') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_triangulo" value="0">
                                                        <input type="checkbox" name="traseira_triangulo"
                                                            id="traseira_triangulo" value="1" {{
                                                            $registoEntradaVeiculo->traseira_triangulo ||
                                                        old('traseira_triangulo', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_triangulo" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_triangulo')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_triangulo'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_triangulo') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_triangulo_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_nada_consta') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="traseira_nada_consta" value="0">
                                                        <input type="checkbox" name="traseira_nada_consta"
                                                            id="traseira_nada_consta" value="1" {{
                                                            $registoEntradaVeiculo->traseira_nada_consta ||
                                                        old('traseira_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="traseira_nada_consta" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.traseira_nada_consta')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('traseira_nada_consta'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_nada_consta') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_nada_consta_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_obs') ? 'has-error' : '' }}">
                                                    <label for="traseira_obs">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_obs')
                                                        }}</label>
                                                    <textarea class="form-control" name="traseira_obs"
                                                        id="traseira_obs">{{ old('traseira_obs', $registoEntradaVeiculo->traseira_obs) }}</textarea>
                                                    @if($errors->has('traseira_obs'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_obs') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_obs_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('traseira_tampa_traseira_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_tampa_traseira_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_tampa_traseira_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_tampa_traseira_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_tampa_traseira_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_tampa_traseira_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_tampa_traseira_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_lanternas_dir_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_lanternas_dir_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_lanternas_dir_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_lanternas_dir_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_lanternas_dir_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_lanternas_dir_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_lanternas_dir_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_lanterna_esq_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_lanterna_esq_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_lanterna_esq_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_lanterna_esq_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_lanterna_esq_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_lanterna_esq_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_lanterna_esq_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_parachoque_tras_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_parachoque_tras_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_parachoque_tras_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_parachoque_tras_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_parachoque_tras_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_parachoque_tras_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_parachoque_tras_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_estepe_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_estepe_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_estepe_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_estepe_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_estepe_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_estepe_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_estepe_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_macaco_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_macaco_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_macaco_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_macaco_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_macaco_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_macaco_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_macaco_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_chave_de_roda_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_chave_de_roda_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_chave_de_roda_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_chave_de_roda_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_chave_de_roda_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_chave_de_roda_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_chave_de_roda_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('traseira_triangulo_photos') ? 'has-error' : '' }}">
                                                    <label for="traseira_triangulo_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_triangulo_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="traseira_triangulo_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('traseira_triangulo_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('traseira_triangulo_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.traseira_triangulo_photos_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFour1">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordion1" href="#collapseFour1" aria-expanded="false"
                                            aria-controls="collapseFour1">
                                            Lateral direita
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingFour1">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_lateral') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_direita_lateral" value="0">
                                                        <input type="checkbox" name="lateral_direita_lateral"
                                                            id="lateral_direita_lateral" value="1" {{
                                                            $registoEntradaVeiculo->lateral_direita_lateral ||
                                                        old('lateral_direita_lateral', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="lateral_direita_lateral" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_direita_lateral')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_direita_lateral'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_lateral') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_lateral_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_porta_tras') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_direita_porta_tras"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_direita_porta_tras"
                                                            id="lateral_direita_porta_tras" value="1" {{
                                                            $registoEntradaVeiculo->lateral_direita_porta_tras ||
                                                        old('lateral_direita_porta_tras', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="lateral_direita_porta_tras"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_tras')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_direita_porta_tras'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_porta_tras') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_tras_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_porta_diant') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_direita_porta_diant"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_direita_porta_diant"
                                                            id="lateral_direita_porta_diant" value="1" {{
                                                            $registoEntradaVeiculo->lateral_direita_porta_diant ||
                                                        old('lateral_direita_porta_diant', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="lateral_direita_porta_diant"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_diant')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_direita_porta_diant'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_porta_diant') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_diant_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_retrovisor') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_direita_retrovisor"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_direita_retrovisor"
                                                            id="lateral_direita_retrovisor" value="1" {{
                                                            $registoEntradaVeiculo->lateral_direita_retrovisor ||
                                                        old('lateral_direita_retrovisor', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="lateral_direita_retrovisor"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_direita_retrovisor')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_direita_retrovisor'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_retrovisor') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_retrovisor_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_paralama_diant') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_direita_paralama_diant"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_direita_paralama_diant"
                                                            id="lateral_direita_paralama_diant" value="1" {{
                                                            $registoEntradaVeiculo->lateral_direita_paralama_diant ||
                                                        old('lateral_direita_paralama_diant', 0) === 1 ? 'checked' : ''
                                                        }}>
                                                        <label for="lateral_direita_paralama_diant"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_direita_paralama_diant')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_direita_paralama_diant'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_paralama_diant') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_paralama_diant_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_nada_consta') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="lateral_direita_nada_consta"
                                                            value="0">
                                                        <input type="checkbox" name="lateral_direita_nada_consta"
                                                            id="lateral_direita_nada_consta" value="1" {{
                                                            $registoEntradaVeiculo->lateral_direita_nada_consta ||
                                                        old('lateral_direita_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="lateral_direita_nada_consta"
                                                            style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.lateral_direita_nada_consta')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('lateral_direita_nada_consta'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_nada_consta') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_nada_consta_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_obs') ? 'has-error' : '' }}">
                                                    <label for="lateral_direita_obs">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_obs')
                                                        }}</label>
                                                    <textarea class="form-control" name="lateral_direita_obs"
                                                        id="lateral_direita_obs">{{ old('lateral_direita_obs', $registoEntradaVeiculo->lateral_direita_obs) }}</textarea>
                                                    @if($errors->has('lateral_direita_obs'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_obs') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_obs_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_lateral_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_direita_lateral_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_lateral_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_direita_lateral_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_direita_lateral_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_lateral_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_lateral_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_porta_tras_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_direita_porta_tras_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_tras_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_direita_porta_tras_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_direita_porta_tras_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_porta_tras_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_tras_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_porta_diant_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_direita_porta_diant_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_diant_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_direita_porta_diant_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_direita_porta_diant_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_porta_diant_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_diant_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_retrovisor_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_direita_retrovisor_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_retrovisor_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_direita_retrovisor_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_direita_retrovisor_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_retrovisor_photos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_retrovisor_photos_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('lateral_direita_paralama_diant_photos') ? 'has-error' : '' }}">
                                                    <label for="lateral_direita_paralama_diant_photos">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_paralama_diant_photos')
                                                        }}</label>
                                                    <div class="needsclick dropzone"
                                                        id="lateral_direita_paralama_diant_photos-dropzone">
                                                    </div>
                                                    @if($errors->has('lateral_direita_paralama_diant_photos'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('lateral_direita_paralama_diant_photos')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.lateral_direita_paralama_diant_photos_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFive1">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            data-parent="#accordion1" href="#collapseFive1" aria-expanded="false"
                                            aria-controls="collapseFive1">
                                            Cinzeiro (vestígios de cinza)
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive1" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingFive1">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('cinzeiro_sim') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="cinzeiro_sim" value="0">
                                                        <input type="checkbox" name="cinzeiro_sim" id="cinzeiro_sim"
                                                            value="1" {{ $registoEntradaVeiculo->cinzeiro_sim ||
                                                        old('cinzeiro_sim', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="cinzeiro_sim" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.cinzeiro_sim')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('cinzeiro_sim'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('cinzeiro_sim') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.cinzeiro_sim_helper')
                                                        }}</span>
                                                </div>
                                                <div
                                                    class="form-group {{ $errors->has('cinzeiro_nada_consta') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="cinzeiro_nada_consta" value="0">
                                                        <input type="checkbox" name="cinzeiro_nada_consta"
                                                            id="cinzeiro_nada_consta" value="1" {{
                                                            $registoEntradaVeiculo->cinzeiro_nada_consta ||
                                                        old('cinzeiro_nada_consta', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="cinzeiro_nada_consta" style="font-weight: 400">{{
                                                            trans('cruds.registoEntradaVeiculo.fields.cinzeiro_nada_consta')
                                                            }}</label>
                                                    </div>
                                                    @if($errors->has('cinzeiro_nada_consta'))
                                                    <span class="help-block" role="alert">{{
                                                        $errors->first('cinzeiro_nada_consta') }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.cinzeiro_nada_consta_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div
                                                    class="form-group {{ $errors->has('cinzeiro') ? 'has-error' : '' }}">
                                                    <label for="cinzeiro">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.cinzeiro') }}</label>
                                                    <div class="needsclick dropzone" id="cinzeiro-dropzone">
                                                    </div>
                                                    @if($errors->has('cinzeiro'))
                                                    <span class="help-block" role="alert">{{ $errors->first('cinzeiro')
                                                        }}</span>
                                                    @endif
                                                    <span class="help-block">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.cinzeiro_helper')
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger" type="submit" name="forward" value="true">
                            Avançar
                        </button>
                        @endif
                        @if (request()->query('step') == 2)
                        <input type="hidden" name="step" value="2">
                        <div class="panel-group" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title">
                                        <a role="button">
                                            Check list (aspiração)
                                        </a>
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div
                                                class="form-group {{ $errors->has('aspiracao_bancos_frente') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="aspiracao_bancos_frente" value="0">
                                                    <input type="checkbox" name="aspiracao_bancos_frente"
                                                        id="aspiracao_bancos_frente" value="1" {{
                                                        $registoEntradaVeiculo->aspiracao_bancos_frente ||
                                                    old('aspiracao_bancos_frente', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="aspiracao_bancos_frente" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.aspiracao_bancos_frente')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('aspiracao_bancos_frente'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('aspiracao_bancos_frente') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.aspiracao_bancos_frente_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('aspiracao_bancos_tras') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="aspiracao_bancos_tras" value="0">
                                                    <input type="checkbox" name="aspiracao_bancos_tras"
                                                        id="aspiracao_bancos_tras" value="1" {{
                                                        $registoEntradaVeiculo->aspiracao_bancos_tras ||
                                                    old('aspiracao_bancos_tras', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="aspiracao_bancos_tras" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.aspiracao_bancos_tras')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('aspiracao_bancos_tras'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('aspiracao_bancos_tras')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.aspiracao_bancos_tras_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('aspiracao_tapetes_e_chao_frente') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="aspiracao_tapetes_e_chao_frente"
                                                        value="0">
                                                    <input type="checkbox" name="aspiracao_tapetes_e_chao_frente"
                                                        id="aspiracao_tapetes_e_chao_frente" value="1" {{
                                                        $registoEntradaVeiculo->aspiracao_tapetes_e_chao_frente ||
                                                    old('aspiracao_tapetes_e_chao_frente', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="aspiracao_tapetes_e_chao_frente"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.aspiracao_tapetes_e_chao_frente')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('aspiracao_tapetes_e_chao_frente'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('aspiracao_tapetes_e_chao_frente') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.aspiracao_tapetes_e_chao_frente_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('aspiracao_tapetes_e_chao_tras') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="aspiracao_tapetes_e_chao_tras" value="0">
                                                    <input type="checkbox" name="aspiracao_tapetes_e_chao_tras"
                                                        id="aspiracao_tapetes_e_chao_tras" value="1" {{
                                                        $registoEntradaVeiculo->aspiracao_tapetes_e_chao_tras ||
                                                    old('aspiracao_tapetes_e_chao_tras', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="aspiracao_tapetes_e_chao_tras"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.aspiracao_tapetes_e_chao_tras')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('aspiracao_tapetes_e_chao_tras'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('aspiracao_tapetes_e_chao_tras') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.aspiracao_tapetes_e_chao_tras_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('limpeza_e_brilho_de_plasticos_carro') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="limpeza_e_brilho_de_plasticos_carro"
                                                        value="0">
                                                    <input type="checkbox" name="limpeza_e_brilho_de_plasticos_carro"
                                                        id="limpeza_e_brilho_de_plasticos_carro" value="1" {{
                                                        $registoEntradaVeiculo->limpeza_e_brilho_de_plasticos_carro ||
                                                    old('limpeza_e_brilho_de_plasticos_carro', 0) === 1 ? 'checked' : ''
                                                    }}>
                                                    <label for="limpeza_e_brilho_de_plasticos_carro"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.limpeza_e_brilho_de_plasticos_carro')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('limpeza_e_brilho_de_plasticos_carro'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('limpeza_e_brilho_de_plasticos_carro') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.limpeza_e_brilho_de_plasticos_carro_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div
                                                class="form-group {{ $errors->has('ambientador_de_carro') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="ambientador_de_carro" value="0">
                                                    <input type="checkbox" name="ambientador_de_carro"
                                                        id="ambientador_de_carro" value="1" {{
                                                        $registoEntradaVeiculo->ambientador_de_carro ||
                                                    old('ambientador_de_carro', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="ambientador_de_carro" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.ambientador_de_carro')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('ambientador_de_carro'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('ambientador_de_carro')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.ambientador_de_carro_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('limpeza_vidros_interiores') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="limpeza_vidros_interiores" value="0">
                                                    <input type="checkbox" name="limpeza_vidros_interiores"
                                                        id="limpeza_vidros_interiores" value="1" {{
                                                        $registoEntradaVeiculo->limpeza_vidros_interiores ||
                                                    old('limpeza_vidros_interiores', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="limpeza_vidros_interiores" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.limpeza_vidros_interiores')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('limpeza_vidros_interiores'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('limpeza_vidros_interiores') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.limpeza_vidros_interiores_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('retirar_os_objetos_pessoais_existentes_no_carro') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden"
                                                        name="retirar_os_objetos_pessoais_existentes_no_carro"
                                                        value="0">
                                                    <input type="checkbox"
                                                        name="retirar_os_objetos_pessoais_existentes_no_carro"
                                                        id="retirar_os_objetos_pessoais_existentes_no_carro" value="1"
                                                        {{
                                                        $registoEntradaVeiculo->retirar_os_objetos_pessoais_existentes_no_carro
                                                    || old('retirar_os_objetos_pessoais_existentes_no_carro', 0) === 1 ?
                                                    'checked' : '' }}>
                                                    <label for="retirar_os_objetos_pessoais_existentes_no_carro"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.retirar_os_objetos_pessoais_existentes_no_carro')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('retirar_os_objetos_pessoais_existentes_no_carro'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('retirar_os_objetos_pessoais_existentes_no_carro')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.retirar_os_objetos_pessoais_existentes_no_carro_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('verificacao_de_luzes_no_painel') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="verificacao_de_luzes_no_painel"
                                                        value="0">
                                                    <input type="checkbox" name="verificacao_de_luzes_no_painel"
                                                        id="verificacao_de_luzes_no_painel" value="1" {{
                                                        $registoEntradaVeiculo->verificacao_de_luzes_no_painel ||
                                                    old('verificacao_de_luzes_no_painel', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="verificacao_de_luzes_no_painel"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.verificacao_de_luzes_no_painel')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('verificacao_de_luzes_no_painel'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('verificacao_de_luzes_no_painel') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.verificacao_de_luzes_no_painel_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('verificacao_de_necessidade_de_lavagem_estofos') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden"
                                                        name="verificacao_de_necessidade_de_lavagem_estofos" value="0">
                                                    <input type="checkbox"
                                                        name="verificacao_de_necessidade_de_lavagem_estofos"
                                                        id="verificacao_de_necessidade_de_lavagem_estofos" value="1" {{
                                                        $registoEntradaVeiculo->verificacao_de_necessidade_de_lavagem_estofos
                                                    ||
                                                    old('verificacao_de_necessidade_de_lavagem_estofos', 0) === 1 ?
                                                    'checked' :
                                                    '' }}>
                                                    <label for="verificacao_de_necessidade_de_lavagem_estofos"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.verificacao_de_necessidade_de_lavagem_estofos')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('verificacao_de_necessidade_de_lavagem_estofos'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('verificacao_de_necessidade_de_lavagem_estofos')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.verificacao_de_necessidade_de_lavagem_estofos_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('aspiracao_obs') ? 'has-error' : '' }}">
                                        <label for="aspiracao_obs">{{
                                            trans('cruds.registoEntradaVeiculo.fields.aspiracao_obs') }}</label>
                                        <textarea class="form-control" name="aspiracao_obs"
                                            id="aspiracao_obs">{{ old('aspiracao_obs', $registoEntradaVeiculo->aspiracao_obs) }}</textarea>
                                        @if($errors->has('aspiracao_obs'))
                                        <span class="help-block" role="alert">{{ $errors->first('aspiracao_obs')
                                            }}</span>
                                        @endif
                                        <span class="help-block">{{
                                            trans('cruds.registoEntradaVeiculo.fields.aspiracao_obs_helper') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-danger" type="submit" name="backward" value="true">
                            Recuar
                        </button>
                        <button class="btn btn-danger" type="submit" name="forward" value="true">
                            Avançar
                        </button>
                        @endif
                        @if (request()->query('step') == 3)
                        <input type="hidden" name="step" value="3">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Check list (documentos)
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('copia_de_licenca_de_tvde') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="copia_de_licenca_de_tvde" value="0">
                                                    <input type="checkbox" name="copia_de_licenca_de_tvde"
                                                        id="copia_de_licenca_de_tvde" value="1" {{
                                                        $registoEntradaVeiculo->copia_de_licenca_de_tvde ||
                                                    old('copia_de_licenca_de_tvde', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="copia_de_licenca_de_tvde" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('copia_de_licenca_de_tvde'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('copia_de_licenca_de_tvde') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('copia_de_licenca_de_tvde_data') ? 'has-error' : '' }}">
                                                <label for="copia_de_licenca_de_tvde_data">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde_data')
                                                    }}</label>
                                                <input class="form-control date" type="text"
                                                    name="copia_de_licenca_de_tvde_data"
                                                    id="copia_de_licenca_de_tvde_data"
                                                    value="{{ old('copia_de_licenca_de_tvde_data', $registoEntradaVeiculo->copia_de_licenca_de_tvde_data) }}">
                                                @if($errors->has('copia_de_licenca_de_tvde_data'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('copia_de_licenca_de_tvde_data') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde_data_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('copia_de_licenca_de_tvde_comentarios') ? 'has-error' : '' }}">
                                                <label for="copia_de_licenca_de_tvde_comentarios">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde_comentarios')
                                                    }}</label>
                                                <input class="form-control" type="text"
                                                    name="copia_de_licenca_de_tvde_comentarios"
                                                    id="copia_de_licenca_de_tvde_comentarios"
                                                    value="{{ old('copia_de_licenca_de_tvde_comentarios', $registoEntradaVeiculo->copia_de_licenca_de_tvde_comentarios) }}">
                                                @if($errors->has('copia_de_licenca_de_tvde_comentarios'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('copia_de_licenca_de_tvde_comentarios') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde_comentarios_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('carta_verde_de_seguro_validade') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="carta_verde_de_seguro_validade"
                                                        value="0">
                                                    <input type="checkbox" name="carta_verde_de_seguro_validade"
                                                        id="carta_verde_de_seguro_validade" value="1" {{
                                                        $registoEntradaVeiculo->carta_verde_de_seguro_validade ||
                                                    old('carta_verde_de_seguro_validade', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="carta_verde_de_seguro_validade"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_validade')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('carta_verde_de_seguro_validade'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('carta_verde_de_seguro_validade') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_validade_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('carta_verde_de_seguro_data') ? 'has-error' : '' }}">
                                                <label for="carta_verde_de_seguro_data">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_data')
                                                    }}</label>
                                                <input class="form-control date" type="text"
                                                    name="carta_verde_de_seguro_data" id="carta_verde_de_seguro_data"
                                                    value="{{ old('carta_verde_de_seguro_data', $registoEntradaVeiculo->carta_verde_de_seguro_data) }}">
                                                @if($errors->has('carta_verde_de_seguro_data'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('carta_verde_de_seguro_data') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_data_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('carta_verde_de_seguro_comentarios') ? 'has-error' : '' }}">
                                                <label for="carta_verde_de_seguro_comentarios">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_comentarios')
                                                    }}</label>
                                                <input class="form-control" type="text"
                                                    name="carta_verde_de_seguro_comentarios"
                                                    id="carta_verde_de_seguro_comentarios"
                                                    value="{{ old('carta_verde_de_seguro_comentarios', $registoEntradaVeiculo->carta_verde_de_seguro_comentarios) }}">
                                                @if($errors->has('carta_verde_de_seguro_comentarios'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('carta_verde_de_seguro_comentarios') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_comentarios_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('dua_do_veiculo') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="dua_do_veiculo" value="0">
                                                    <input type="checkbox" name="dua_do_veiculo" id="dua_do_veiculo"
                                                        value="1" {{ $registoEntradaVeiculo->dua_do_veiculo ||
                                                    old('dua_do_veiculo', 0)
                                                    === 1 ? 'checked' : '' }}>
                                                    <label for="dua_do_veiculo" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('dua_do_veiculo'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('dua_do_veiculo')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('dua_do_veiculo_data') ? 'has-error' : '' }}">
                                                <label for="dua_do_veiculo_data">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo_data')
                                                    }}</label>
                                                <input class="form-control date" type="text" name="dua_do_veiculo_data"
                                                    id="dua_do_veiculo_data"
                                                    value="{{ old('dua_do_veiculo_data', $registoEntradaVeiculo->dua_do_veiculo_data) }}">
                                                @if($errors->has('dua_do_veiculo_data'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('dua_do_veiculo_data')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo_data_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('dua_do_veiculo_comentarios') ? 'has-error' : '' }}">
                                                <label for="dua_do_veiculo_comentarios">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo_comentarios')
                                                    }}</label>
                                                <input class="form-control" type="text"
                                                    name="dua_do_veiculo_comentarios" id="dua_do_veiculo_comentarios"
                                                    value="{{ old('dua_do_veiculo_comentarios', $registoEntradaVeiculo->dua_do_veiculo_comentarios) }}">
                                                @if($errors->has('dua_do_veiculo_comentarios'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('dua_do_veiculo_comentarios') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo_comentarios_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('inspecao_do_veiculo_validade') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="inspecao_do_veiculo_validade" value="0">
                                                    <input type="checkbox" name="inspecao_do_veiculo_validade"
                                                        id="inspecao_do_veiculo_validade" value="1" {{
                                                        $registoEntradaVeiculo->inspecao_do_veiculo_validade ||
                                                    old('inspecao_do_veiculo_validade', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="inspecao_do_veiculo_validade"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('inspecao_do_veiculo_validade'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('inspecao_do_veiculo_validade') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('inspecao_do_veiculo_validade_data') ? 'has-error' : '' }}">
                                                <label for="inspecao_do_veiculo_validade_data">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade_data')
                                                    }}</label>
                                                <input class="form-control date" type="text"
                                                    name="inspecao_do_veiculo_validade_data"
                                                    id="inspecao_do_veiculo_validade_data"
                                                    value="{{ old('inspecao_do_veiculo_validade_data', $registoEntradaVeiculo->inspecao_do_veiculo_validade_data) }}">
                                                @if($errors->has('inspecao_do_veiculo_validade_data'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('inspecao_do_veiculo_validade_data') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade_data_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('inspecao_do_veiculo_validade_comentarios') ? 'has-error' : '' }}">
                                                <label for="inspecao_do_veiculo_validade_comentarios">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade_comentarios')
                                                    }}</label>
                                                <input class="form-control" type="text"
                                                    name="inspecao_do_veiculo_validade_comentarios"
                                                    id="inspecao_do_veiculo_validade_comentarios"
                                                    value="{{ old('inspecao_do_veiculo_validade_comentarios', $registoEntradaVeiculo->inspecao_do_veiculo_validade_comentarios) }}">
                                                @if($errors->has('inspecao_do_veiculo_validade_comentarios'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('inspecao_do_veiculo_validade_comentarios') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade_comentarios_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('contratro_de_prestacao_de_servicos') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="contratro_de_prestacao_de_servicos"
                                                        value="0">
                                                    <input type="checkbox" name="contratro_de_prestacao_de_servicos"
                                                        id="contratro_de_prestacao_de_servicos" value="1" {{
                                                        $registoEntradaVeiculo->contratro_de_prestacao_de_servicos ||
                                                    old('contratro_de_prestacao_de_servicos', 0) === 1 ? 'checked' : ''
                                                    }}>
                                                    <label for="contratro_de_prestacao_de_servicos"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('contratro_de_prestacao_de_servicos'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('contratro_de_prestacao_de_servicos') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('contratro_de_prestacao_de_servicos_data') ? 'has-error' : '' }}">
                                                <label for="contratro_de_prestacao_de_servicos_data">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos_data')
                                                    }}</label>
                                                <input class="form-control date" type="text"
                                                    name="contratro_de_prestacao_de_servicos_data"
                                                    id="contratro_de_prestacao_de_servicos_data"
                                                    value="{{ old('contratro_de_prestacao_de_servicos_data', $registoEntradaVeiculo->contratro_de_prestacao_de_servicos_data) }}">
                                                @if($errors->has('contratro_de_prestacao_de_servicos_data'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('contratro_de_prestacao_de_servicos_data') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos_data_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('contratro_de_prestacao_de_servicos_comentarios') ? 'has-error' : '' }}">
                                                <label for="contratro_de_prestacao_de_servicos_comentarios">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos_comentarios')
                                                    }}</label>
                                                <input class="form-control" type="text"
                                                    name="contratro_de_prestacao_de_servicos_comentarios"
                                                    id="contratro_de_prestacao_de_servicos_comentarios"
                                                    value="{{ old('contratro_de_prestacao_de_servicos_comentarios', $registoEntradaVeiculo->contratro_de_prestacao_de_servicos_comentarios) }}">
                                                @if($errors->has('contratro_de_prestacao_de_servicos_comentarios'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('contratro_de_prestacao_de_servicos_comentarios')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos_comentarios_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('distico_tvde_colocado') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="distico_tvde_colocado" value="0">
                                                    <input type="checkbox" name="distico_tvde_colocado"
                                                        id="distico_tvde_colocado" value="1" {{
                                                        $registoEntradaVeiculo->distico_tvde_colocado ||
                                                    old('distico_tvde_colocado', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="distico_tvde_colocado" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('distico_tvde_colocado'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('distico_tvde_colocado')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('distico_tvde_colocado_data') ? 'has-error' : '' }}">
                                                <label for="distico_tvde_colocado_data">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado_data')
                                                    }}</label>
                                                <input class="form-control date" type="text"
                                                    name="distico_tvde_colocado_data" id="distico_tvde_colocado_data"
                                                    value="{{ old('distico_tvde_colocado_data', $registoEntradaVeiculo->distico_tvde_colocado_data) }}">
                                                @if($errors->has('distico_tvde_colocado_data'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('distico_tvde_colocado_data') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado_data_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('distico_tvde_colocado_comentarios') ? 'has-error' : '' }}">
                                                <label for="distico_tvde_colocado_comentarios">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado_comentarios')
                                                    }}</label>
                                                <input class="form-control" type="text"
                                                    name="distico_tvde_colocado_comentarios"
                                                    id="distico_tvde_colocado_comentarios"
                                                    value="{{ old('distico_tvde_colocado_comentarios', $registoEntradaVeiculo->distico_tvde_colocado_comentarios) }}">
                                                @if($errors->has('distico_tvde_colocado_comentarios'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('distico_tvde_colocado_comentarios') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado_comentarios_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('declaracao_amigavel') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="declaracao_amigavel" value="0">
                                                    <input type="checkbox" name="declaracao_amigavel"
                                                        id="declaracao_amigavel" value="1" {{
                                                        $registoEntradaVeiculo->declaracao_amigavel ||
                                                    old('declaracao_amigavel', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="declaracao_amigavel" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('declaracao_amigavel'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('declaracao_amigavel')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('declaracao_amigavel_data') ? 'has-error' : '' }}">
                                                <label for="declaracao_amigavel_data">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel_data')
                                                    }}</label>
                                                <input class="form-control date" type="text"
                                                    name="declaracao_amigavel_data" id="declaracao_amigavel_data"
                                                    value="{{ old('declaracao_amigavel_data', $registoEntradaVeiculo->declaracao_amigavel_data) }}">
                                                @if($errors->has('declaracao_amigavel_data'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('declaracao_amigavel_data') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel_data_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ $errors->has('declaracao_amigavel_comentarios') ? 'has-error' : '' }}">
                                                <label for="declaracao_amigavel_comentarios">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel_comentarios')
                                                    }}</label>
                                                <input class="form-control" type="text"
                                                    name="declaracao_amigavel_comentarios"
                                                    id="declaracao_amigavel_comentarios"
                                                    value="{{ old('declaracao_amigavel_comentarios', $registoEntradaVeiculo->declaracao_amigavel_comentarios) }}">
                                                @if($errors->has('declaracao_amigavel_comentarios'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('declaracao_amigavel_comentarios') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel_comentarios_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger" type="submit" name="backward" value="true">
                            Recuar
                        </button>
                        <button class="btn btn-danger" type="submit" name="forward" value="true">
                            Avançar
                        </button>
                        @endif
                        @if (request()->query('step') == 4)
                        <input type="hidden" name="step" value="4">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Check list (aspiração)
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div
                                                class="form-group {{ $errors->has('aplicacao_de_agua_por_todo_o_carro') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="aplicacao_de_agua_por_todo_o_carro"
                                                        value="0">
                                                    <input type="checkbox" name="aplicacao_de_agua_por_todo_o_carro"
                                                        id="aplicacao_de_agua_por_todo_o_carro" value="1" {{
                                                        $registoEntradaVeiculo->aplicacao_de_agua_por_todo_o_carro ||
                                                    old('aplicacao_de_agua_por_todo_o_carro', 0) === 1 ? 'checked' : ''
                                                    }}>
                                                    <label for="aplicacao_de_agua_por_todo_o_carro"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.aplicacao_de_agua_por_todo_o_carro')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('aplicacao_de_agua_por_todo_o_carro'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('aplicacao_de_agua_por_todo_o_carro') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.aplicacao_de_agua_por_todo_o_carro_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('passagem_de_agua_em_todo_o_carro') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="passagem_de_agua_em_todo_o_carro"
                                                        value="0">
                                                    <input type="checkbox" name="passagem_de_agua_em_todo_o_carro"
                                                        id="passagem_de_agua_em_todo_o_carro" value="1" {{
                                                        $registoEntradaVeiculo->passagem_de_agua_em_todo_o_carro ||
                                                    old('passagem_de_agua_em_todo_o_carro', 0) === 1 ? 'checked' : ''
                                                    }}>
                                                    <label for="passagem_de_agua_em_todo_o_carro"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.passagem_de_agua_em_todo_o_carro')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('passagem_de_agua_em_todo_o_carro'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('passagem_de_agua_em_todo_o_carro') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.passagem_de_agua_em_todo_o_carro_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('aplicacao_de_champo_em_todo_o_carro') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="aplicacao_de_champo_em_todo_o_carro"
                                                        value="0">
                                                    <input type="checkbox" name="aplicacao_de_champo_em_todo_o_carro"
                                                        id="aplicacao_de_champo_em_todo_o_carro" value="1" {{
                                                        $registoEntradaVeiculo->aplicacao_de_champo_em_todo_o_carro ||
                                                    old('aplicacao_de_champo_em_todo_o_carro', 0) === 1 ? 'checked' : ''
                                                    }}>
                                                    <label for="aplicacao_de_champo_em_todo_o_carro"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.aplicacao_de_champo_em_todo_o_carro')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('aplicacao_de_champo_em_todo_o_carro'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('aplicacao_de_champo_em_todo_o_carro') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.aplicacao_de_champo_em_todo_o_carro_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('esfregar_todo_o_carro_com_a_escova') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="esfregar_todo_o_carro_com_a_escova"
                                                        value="0">
                                                    <input type="checkbox" name="esfregar_todo_o_carro_com_a_escova"
                                                        id="esfregar_todo_o_carro_com_a_escova" value="1" {{
                                                        $registoEntradaVeiculo->esfregar_todo_o_carro_com_a_escova ||
                                                    old('esfregar_todo_o_carro_com_a_escova', 0) === 1 ? 'checked' : ''
                                                    }}>
                                                    <label for="esfregar_todo_o_carro_com_a_escova"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.esfregar_todo_o_carro_com_a_escova')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('esfregar_todo_o_carro_com_a_escova'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('esfregar_todo_o_carro_com_a_escova') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.esfregar_todo_o_carro_com_a_escova_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('retirar_com_agua') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="retirar_com_agua" value="0">
                                                    <input type="checkbox" name="retirar_com_agua" id="retirar_com_agua"
                                                        value="1" {{ $registoEntradaVeiculo->retirar_com_agua ||
                                                    old('retirar_com_agua', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="retirar_com_agua" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.retirar_com_agua')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('retirar_com_agua'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('retirar_com_agua')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.retirar_com_agua_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('verificar_sujidades_ainda_existentes') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="verificar_sujidades_ainda_existentes"
                                                        value="0">
                                                    <input type="checkbox" name="verificar_sujidades_ainda_existentes"
                                                        id="verificar_sujidades_ainda_existentes" value="1" {{
                                                        $registoEntradaVeiculo->verificar_sujidades_ainda_existentes ||
                                                    old('verificar_sujidades_ainda_existentes', 0) === 1 ? 'checked' :
                                                    '' }}>
                                                    <label for="verificar_sujidades_ainda_existentes"
                                                        style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.verificar_sujidades_ainda_existentes')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('verificar_sujidades_ainda_existentes'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('verificar_sujidades_ainda_existentes') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.verificar_sujidades_ainda_existentes_helper')
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div
                                                class="form-group {{ $errors->has('limpeza_de_jantes') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="limpeza_de_jantes" value="0">
                                                    <input type="checkbox" name="limpeza_de_jantes"
                                                        id="limpeza_de_jantes" value="1" {{
                                                        $registoEntradaVeiculo->limpeza_de_jantes ||
                                                    old('limpeza_de_jantes', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="limpeza_de_jantes" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.limpeza_de_jantes')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('limpeza_de_jantes'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('limpeza_de_jantes')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.limpeza_de_jantes_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('possui_triangulo') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="possui_triangulo" value="0">
                                                    <input type="checkbox" name="possui_triangulo" id="possui_triangulo"
                                                        value="1" {{ $registoEntradaVeiculo->possui_triangulo ||
                                                    old('possui_triangulo', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="possui_triangulo" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.possui_triangulo')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('possui_triangulo'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('possui_triangulo')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.possui_triangulo_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('possui_extintor') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="possui_extintor" value="0">
                                                    <input type="checkbox" name="possui_extintor" id="possui_extintor"
                                                        value="1" {{ $registoEntradaVeiculo->possui_extintor ||
                                                    old('possui_extintor', 0)
                                                    === 1 ? 'checked' : '' }}>
                                                    <label for="possui_extintor" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.possui_extintor')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('possui_extintor'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('possui_extintor')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.possui_extintor_helper')
                                                    }}</span>
                                            </div>
                                            <div
                                                class="form-group {{ $errors->has('banco_elevatorio_crianca') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="banco_elevatorio_crianca" value="0">
                                                    <input type="checkbox" name="banco_elevatorio_crianca"
                                                        id="banco_elevatorio_crianca" value="1" {{
                                                        $registoEntradaVeiculo->banco_elevatorio_crianca ||
                                                    old('banco_elevatorio_crianca', 0) === 1 ? 'checked' : '' }}>
                                                    <label for="banco_elevatorio_crianca" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.banco_elevatorio_crianca')
                                                        }}</label>
                                                </div>
                                                @if($errors->has('banco_elevatorio_crianca'))
                                                <span class="help-block" role="alert">{{
                                                    $errors->first('banco_elevatorio_crianca') }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.banco_elevatorio_crianca_helper')
                                                    }}</span>
                                            </div>
                                            <div class="form-group {{ $errors->has('colete') ? 'has-error' : '' }}">
                                                <div>
                                                    <input type="hidden" name="colete" value="0">
                                                    <input type="checkbox" name="colete" id="colete" value="1" {{
                                                        $registoEntradaVeiculo->colete || old('colete', 0) === 1 ?
                                                    'checked' :
                                                    '' }}>
                                                    <label for="colete" style="font-weight: 400">{{
                                                        trans('cruds.registoEntradaVeiculo.fields.colete') }}</label>
                                                </div>
                                                @if($errors->has('colete'))
                                                <span class="help-block" role="alert">{{ $errors->first('colete')
                                                    }}</span>
                                                @endif
                                                <span class="help-block">{{
                                                    trans('cruds.registoEntradaVeiculo.fields.colete_helper') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger" type="submit" name="backward" value="true">
                            Recuar
                        </button>
                        <button class="btn btn-success" type="submit" name="save" value="true">
                            Concluir
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var uploadedFrenteTetoPhotosMap = {}
Dropzone.options.frenteTetoPhotosDropzone = {
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_teto_photos[]" value="' + response.name + '">')
      uploadedFrenteTetoPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteTetoPhotosMap[file.name]
      }
      $('form').find('input[name="frente_teto_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->frente_teto_photos)
      var files = {!! json_encode($registoEntradaVeiculo->frente_teto_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="frente_teto_photos[]" value="' + file.file_name + '">')
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
    var uploadedFrenteParabrisaPhotosMap = {}
Dropzone.options.frenteParabrisaPhotosDropzone = {
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_parabrisa_photos[]" value="' + response.name + '">')
      uploadedFrenteParabrisaPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteParabrisaPhotosMap[file.name]
      }
      $('form').find('input[name="frente_parabrisa_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->frente_parabrisa_photos)
      var files = {!! json_encode($registoEntradaVeiculo->frente_parabrisa_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="frente_parabrisa_photos[]" value="' + file.file_name + '">')
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
    var uploadedFrenteCapoPhotosMap = {}
Dropzone.options.frenteCapoPhotosDropzone = {
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_capo_photos[]" value="' + response.name + '">')
      uploadedFrenteCapoPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteCapoPhotosMap[file.name]
      }
      $('form').find('input[name="frente_capo_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->frente_capo_photos)
      var files = {!! json_encode($registoEntradaVeiculo->frente_capo_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="frente_capo_photos[]" value="' + file.file_name + '">')
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
    var uploadedFrenteParachoquePhotosMap = {}
Dropzone.options.frenteParachoquePhotosDropzone = {
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="frente_parachoque_photos[]" value="' + response.name + '">')
      uploadedFrenteParachoquePhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFrenteParachoquePhotosMap[file.name]
      }
      $('form').find('input[name="frente_parachoque_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->frente_parachoque_photos)
      var files = {!! json_encode($registoEntradaVeiculo->frente_parachoque_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="frente_parachoque_photos[]" value="' + file.file_name + '">')
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_paralama_diant_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaParalamaDiantPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_esquerda_paralama_diant_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_esquerda_paralama_diant_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_retrovisor_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaRetrovisorPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_esquerda_retrovisor_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_esquerda_retrovisor_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    var uploadedLateralEsquerdaPortaDianteiraPhotosMap = {}
Dropzone.options.lateralEsquerdaPortaDianteiraPhotosDropzone = {
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_porta_dianteira_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaPortaDianteiraPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralEsquerdaPortaDianteiraPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_esquerda_porta_dianteira_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_esquerda_porta_dianteira_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_esquerda_porta_dianteira_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="lateral_esquerda_porta_dianteira_photos[]" value="' + file.file_name + '">')
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
    var uploadedLateralEsquerdaPortaTraseiraPhotosMap = {}
Dropzone.options.lateralEsquerdaPortaTraseiraPhotosDropzone = {
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_porta_traseira_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaPortaTraseiraPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedLateralEsquerdaPortaTraseiraPhotosMap[file.name]
      }
      $('form').find('input[name="lateral_esquerda_porta_traseira_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_esquerda_porta_traseira_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_esquerda_porta_traseira_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="lateral_esquerda_porta_traseira_photos[]" value="' + file.file_name + '">')
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_esquerda_lateral_photos[]" value="' + response.name + '">')
      uploadedLateralEsquerdaLateralPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_esquerda_lateral_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_esquerda_lateral_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_tampa_traseira_photos[]" value="' + response.name + '">')
      uploadedTraseiraTampaTraseiraPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_tampa_traseira_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_tampa_traseira_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_lanternas_dir_photos[]" value="' + response.name + '">')
      uploadedTraseiraLanternasDirPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_lanternas_dir_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_lanternas_dir_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_lanterna_esq_photos[]" value="' + response.name + '">')
      uploadedTraseiraLanternaEsqPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_lanterna_esq_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_lanterna_esq_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_parachoque_tras_photos[]" value="' + response.name + '">')
      uploadedTraseiraParachoqueTrasPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_parachoque_tras_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_parachoque_tras_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_estepe_photos[]" value="' + response.name + '">')
      uploadedTraseiraEstepePhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_estepe_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_estepe_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_macaco_photos[]" value="' + response.name + '">')
      uploadedTraseiraMacacoPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_macaco_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_macaco_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_chave_de_roda_photos[]" value="' + response.name + '">')
      uploadedTraseiraChaveDeRodaPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_chave_de_roda_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_chave_de_roda_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="traseira_triangulo_photos[]" value="' + response.name + '">')
      uploadedTraseiraTrianguloPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->traseira_triangulo_photos)
      var files = {!! json_encode($registoEntradaVeiculo->traseira_triangulo_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_lateral_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaLateralPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_direita_lateral_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_direita_lateral_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_porta_tras_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaPortaTrasPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_direita_porta_tras_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_direita_porta_tras_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_porta_diant_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaPortaDiantPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_direita_porta_diant_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_direita_porta_diant_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_retrovisor_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaRetrovisorPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_direita_retrovisor_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_direita_retrovisor_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="lateral_direita_paralama_diant_photos[]" value="' + response.name + '">')
      uploadedLateralDireitaParalamaDiantPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
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
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->lateral_direita_paralama_diant_photos)
      var files = {!! json_encode($registoEntradaVeiculo->lateral_direita_paralama_diant_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
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
    var uploadedCinzeiroMap = {}
Dropzone.options.cinzeiroDropzone = {
    url: '{{ route('admin.registo-entrada-veiculos.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="cinzeiro[]" value="' + response.name + '">')
      uploadedCinzeiroMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedCinzeiroMap[file.name]
      }
      $('form').find('input[name="cinzeiro[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($registoEntradaVeiculo) && $registoEntradaVeiculo->cinzeiro)
      var files = {!! json_encode($registoEntradaVeiculo->cinzeiro) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="cinzeiro[]" value="' + file.file_name + '">')
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
@endsection