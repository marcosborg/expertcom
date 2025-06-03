@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.vehicleManageDelivery.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.vehicle-manage-deliveries.update", [$vehicleManageDelivery->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('vehicle_item') ? 'has-error' : '' }}">
                            <label class="required" for="vehicle_item_id">{{ trans('cruds.vehicleManageDelivery.fields.vehicle_item') }}</label>
                            <select class="form-control select2" name="vehicle_item_id" id="vehicle_item_id" required>
                                @foreach($vehicle_items as $id => $entry)
                                <option value="{{ $id }}" {{ (old('vehicle_item_id') ? old('vehicle_item_id') : $vehicleManageDelivery->vehicle_item->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vehicle_item'))
                            <span class="help-block" role="alert">{{ $errors->first('vehicle_item') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.vehicle_item_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                            <label class="required" for="user_id">{{ trans('cruds.vehicleManageDelivery.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $vehicleManageDelivery->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                            <span class="help-block" role="alert">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">
                            <label class="required" for="driver_id">{{ trans('cruds.vehicleManageDelivery.fields.driver') }}</label>
                            <select class="form-control select2" name="driver_id" id="driver_id" required>
                                @foreach($drivers as $id => $entry)
                                <option value="{{ $id }}" {{ (old('driver_id') ? old('driver_id') : $vehicleManageDelivery->driver->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('driver'))
                            <span class="help-block" role="alert">{{ $errors->first('driver') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.driver_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('data_e_horario') ? 'has-error' : '' }}">
                            <label class="required" for="data_e_horario">{{ trans('cruds.vehicleManageDelivery.fields.data_e_horario') }}</label>
                            <input class="form-control datetime" type="text" name="data_e_horario" id="data_e_horario" value="{{ old('data_e_horario', $vehicleManageDelivery->data_e_horario) }}" required>
                            @if($errors->has('data_e_horario'))
                            <span class="help-block" role="alert">{{ $errors->first('data_e_horario') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.data_e_horario_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('de_bateria_de_saida') ? 'has-error' : '' }}">
                            <label class="required" for="de_bateria_de_saida">{{ trans('cruds.vehicleManageDelivery.fields.de_bateria_de_saida') }}</label>
                            <input class="form-control" type="number" name="de_bateria_de_saida" id="de_bateria_de_saida" value="{{ old('de_bateria_de_saida', $vehicleManageDelivery->de_bateria_de_saida) }}" step="1" required>
                            @if($errors->has('de_bateria_de_saida'))
                            <span class="help-block" role="alert">{{ $errors->first('de_bateria_de_saida') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.de_bateria_de_saida_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('km_atual') ? 'has-error' : '' }}">
                            <label class="required" for="km_atual">{{ trans('cruds.vehicleManageDelivery.fields.km_atual') }}</label>
                            <input class="form-control" type="number" name="km_atual" id="km_atual" value="{{ old('km_atual', $vehicleManageDelivery->km_atual) }}" step="1" required>
                            @if($errors->has('km_atual'))
                            <span class="help-block" role="alert">{{ $errors->first('km_atual') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.km_atual_helper') }}</span>
                        </div>









                        <div class="form-group {{ $errors->has('signature_collector_data') ? 'has-error' : '' }}">
                            <label for="signature_collector_data">{{ trans('cruds.vehicleManageDelivery.fields.signature_collector_data') }}</label>
                            <textarea class="form-control" name="signature_collector_data" id="signature_collector_data">{{ old('signature_collector_data', $vehicleManageDelivery->signature_collector_data) }}</textarea>
                            @if($errors->has('signature_collector_data'))
                            <span class="help-block" role="alert">{{ $errors->first('signature_collector_data') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.signature_collector_data_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('signature_driver_data') ? 'has-error' : '' }}">
                            <label for="signature_driver_data">{{ trans('cruds.vehicleManageDelivery.fields.signature_driver_data') }}</label>
                            <textarea class="form-control" name="signature_driver_data" id="signature_driver_data">{{ old('signature_driver_data', $vehicleManageDelivery->signature_driver_data) }}</textarea>
                            @if($errors->has('signature_driver_data'))
                            <span class="help-block" role="alert">{{ $errors->first('signature_driver_data') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.signature_driver_data_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Limpeza</div>
                <div class="panel-body">
                    <div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#deliveries-1" aria-controls="deliveries-1" role="tab" data-toggle="tab">Limpeza</a></li>
                            <li role="presentation"><a href="#deliveries-2" aria-controls="deliveries-2" role="tab" data-toggle="tab">Documentos</a></li>
                            <li role="presentation"><a href="#deliveries-3" aria-controls="deliveries-3" role="tab" data-toggle="tab">Assinaturas</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content" style="margin-top: 20px;">
                            <div role="tabpanel" class="tab-pane active" id="deliveries-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group {{ $errors->has('aspiracao_bancos_frente') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="aspiracao_bancos_frente" value="0">
                                                        <input type="checkbox" name="aspiracao_bancos_frente" id="aspiracao_bancos_frente" value="1" {{ $vehicleManageDelivery->aspiracao_bancos_frente || old('aspiracao_bancos_frente', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="aspiracao_bancos_frente" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_bancos_frente') }}</label>
                                                    </div>
                                                    @if($errors->has('aspiracao_bancos_frente'))
                                                    <span class="help-block" role="alert">{{ $errors->first('aspiracao_bancos_frente') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_bancos_frente_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('aspiracao_bancos_tras') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="aspiracao_bancos_tras" value="0">
                                                        <input type="checkbox" name="aspiracao_bancos_tras" id="aspiracao_bancos_tras" value="1" {{ $vehicleManageDelivery->aspiracao_bancos_tras || old('aspiracao_bancos_tras', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="aspiracao_bancos_tras" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_bancos_tras') }}</label>
                                                    </div>
                                                    @if($errors->has('aspiracao_bancos_tras'))
                                                    <span class="help-block" role="alert">{{ $errors->first('aspiracao_bancos_tras') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_bancos_tras_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('aspiracao_tapetes_e_chao_frente') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="aspiracao_tapetes_e_chao_frente" value="0">
                                                        <input type="checkbox" name="aspiracao_tapetes_e_chao_frente" id="aspiracao_tapetes_e_chao_frente" value="1" {{ $vehicleManageDelivery->aspiracao_tapetes_e_chao_frente || old('aspiracao_tapetes_e_chao_frente', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="aspiracao_tapetes_e_chao_frente" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_tapetes_e_chao_frente') }}</label>
                                                    </div>
                                                    @if($errors->has('aspiracao_tapetes_e_chao_frente'))
                                                    <span class="help-block" role="alert">{{ $errors->first('aspiracao_tapetes_e_chao_frente') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_tapetes_e_chao_frente_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('aspiracao_tapetes_e_chao_tras') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="aspiracao_tapetes_e_chao_tras" value="0">
                                                        <input type="checkbox" name="aspiracao_tapetes_e_chao_tras" id="aspiracao_tapetes_e_chao_tras" value="1" {{ $vehicleManageDelivery->aspiracao_tapetes_e_chao_tras || old('aspiracao_tapetes_e_chao_tras', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="aspiracao_tapetes_e_chao_tras" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_tapetes_e_chao_tras') }}</label>
                                                    </div>
                                                    @if($errors->has('aspiracao_tapetes_e_chao_tras'))
                                                    <span class="help-block" role="alert">{{ $errors->first('aspiracao_tapetes_e_chao_tras') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.aspiracao_tapetes_e_chao_tras_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('limpeza_e_brilho_de_plasticos_carro') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="limpeza_e_brilho_de_plasticos_carro" value="0">
                                                        <input type="checkbox" name="limpeza_e_brilho_de_plasticos_carro" id="limpeza_e_brilho_de_plasticos_carro" value="1" {{ $vehicleManageDelivery->limpeza_e_brilho_de_plasticos_carro || old('limpeza_e_brilho_de_plasticos_carro', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="limpeza_e_brilho_de_plasticos_carro" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.limpeza_e_brilho_de_plasticos_carro') }}</label>
                                                    </div>
                                                    @if($errors->has('limpeza_e_brilho_de_plasticos_carro'))
                                                    <span class="help-block" role="alert">{{ $errors->first('limpeza_e_brilho_de_plasticos_carro') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.limpeza_e_brilho_de_plasticos_carro_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('ambientador_de_carro') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="ambientador_de_carro" value="0">
                                                        <input type="checkbox" name="ambientador_de_carro" id="ambientador_de_carro" value="1" {{ $vehicleManageDelivery->ambientador_de_carro || old('ambientador_de_carro', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="ambientador_de_carro" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.ambientador_de_carro') }}</label>
                                                    </div>
                                                    @if($errors->has('ambientador_de_carro'))
                                                    <span class="help-block" role="alert">{{ $errors->first('ambientador_de_carro') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.ambientador_de_carro_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('limpeza_vidros_interiores') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="limpeza_vidros_interiores" value="0">
                                                        <input type="checkbox" name="limpeza_vidros_interiores" id="limpeza_vidros_interiores" value="1" {{ $vehicleManageDelivery->limpeza_vidros_interiores || old('limpeza_vidros_interiores', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="limpeza_vidros_interiores" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.limpeza_vidros_interiores') }}</label>
                                                    </div>
                                                    @if($errors->has('limpeza_vidros_interiores'))
                                                    <span class="help-block" role="alert">{{ $errors->first('limpeza_vidros_interiores') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.limpeza_vidros_interiores_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('retirar_os_objetos_pessoais_existentes_no_carro') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="retirar_os_objetos_pessoais_existentes_no_carro" value="0">
                                                        <input type="checkbox" name="retirar_os_objetos_pessoais_existentes_no_carro" id="retirar_os_objetos_pessoais_existentes_no_carro" value="1" {{ $vehicleManageDelivery->retirar_os_objetos_pessoais_existentes_no_carro || old('retirar_os_objetos_pessoais_existentes_no_carro', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="retirar_os_objetos_pessoais_existentes_no_carro" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.retirar_os_objetos_pessoais_existentes_no_carro') }}</label>
                                                    </div>
                                                    @if($errors->has('retirar_os_objetos_pessoais_existentes_no_carro'))
                                                    <span class="help-block" role="alert">{{ $errors->first('retirar_os_objetos_pessoais_existentes_no_carro') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.retirar_os_objetos_pessoais_existentes_no_carro_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('verificacao_de_luzes_no_painel') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="verificacao_de_luzes_no_painel" value="0">
                                                        <input type="checkbox" name="verificacao_de_luzes_no_painel" id="verificacao_de_luzes_no_painel" value="1" {{ $vehicleManageDelivery->verificacao_de_luzes_no_painel || old('verificacao_de_luzes_no_painel', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="verificacao_de_luzes_no_painel" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.verificacao_de_luzes_no_painel') }}</label>
                                                    </div>
                                                    @if($errors->has('verificacao_de_luzes_no_painel'))
                                                    <span class="help-block" role="alert">{{ $errors->first('verificacao_de_luzes_no_painel') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.verificacao_de_luzes_no_painel_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('verificacao_de_necessidade_de_lavagem_estofos') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="verificacao_de_necessidade_de_lavagem_estofos" value="0">
                                                        <input type="checkbox" name="verificacao_de_necessidade_de_lavagem_estofos" id="verificacao_de_necessidade_de_lavagem_estofos" value="1" {{ $vehicleManageDelivery->verificacao_de_necessidade_de_lavagem_estofos || old('verificacao_de_necessidade_de_lavagem_estofos', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="verificacao_de_necessidade_de_lavagem_estofos" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.verificacao_de_necessidade_de_lavagem_estofos') }}</label>
                                                    </div>
                                                    @if($errors->has('verificacao_de_necessidade_de_lavagem_estofos'))
                                                    <span class="help-block" role="alert">{{ $errors->first('verificacao_de_necessidade_de_lavagem_estofos') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.verificacao_de_necessidade_de_lavagem_estofos_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('check_list_aspiracao_obs') ? 'has-error' : '' }}">
                                                    <label for="check_list_aspiracao_obs">{{ trans('cruds.vehicleManageDelivery.fields.check_list_aspiracao_obs') }}</label>
                                                    <textarea class="form-control" name="check_list_aspiracao_obs" id="check_list_aspiracao_obs">{{ old('check_list_aspiracao_obs', $vehicleManageDelivery->check_list_aspiracao_obs) }}</textarea>
                                                    @if($errors->has('check_list_aspiracao_obs'))
                                                    <span class="help-block" role="alert">{{ $errors->first('check_list_aspiracao_obs') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.check_list_aspiracao_obs_helper') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group {{ $errors->has('aplicacao_de_agua_por_todo_o_carro') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="aplicacao_de_agua_por_todo_o_carro" value="0">
                                                        <input type="checkbox" name="aplicacao_de_agua_por_todo_o_carro" id="aplicacao_de_agua_por_todo_o_carro" value="1" {{ $vehicleManageDelivery->aplicacao_de_agua_por_todo_o_carro || old('aplicacao_de_agua_por_todo_o_carro', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="aplicacao_de_agua_por_todo_o_carro" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.aplicacao_de_agua_por_todo_o_carro') }}</label>
                                                    </div>
                                                    @if($errors->has('aplicacao_de_agua_por_todo_o_carro'))
                                                    <span class="help-block" role="alert">{{ $errors->first('aplicacao_de_agua_por_todo_o_carro') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.aplicacao_de_agua_por_todo_o_carro_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('passagem_de_agua_em_todo_o_carro') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="passagem_de_agua_em_todo_o_carro" value="0">
                                                        <input type="checkbox" name="passagem_de_agua_em_todo_o_carro" id="passagem_de_agua_em_todo_o_carro" value="1" {{ $vehicleManageDelivery->passagem_de_agua_em_todo_o_carro || old('passagem_de_agua_em_todo_o_carro', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="passagem_de_agua_em_todo_o_carro" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.passagem_de_agua_em_todo_o_carro') }}</label>
                                                    </div>
                                                    @if($errors->has('passagem_de_agua_em_todo_o_carro'))
                                                    <span class="help-block" role="alert">{{ $errors->first('passagem_de_agua_em_todo_o_carro') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.passagem_de_agua_em_todo_o_carro_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('aplicacao_de_champo_em_todo_o_carro') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="aplicacao_de_champo_em_todo_o_carro" value="0">
                                                        <input type="checkbox" name="aplicacao_de_champo_em_todo_o_carro" id="aplicacao_de_champo_em_todo_o_carro" value="1" {{ $vehicleManageDelivery->aplicacao_de_champo_em_todo_o_carro || old('aplicacao_de_champo_em_todo_o_carro', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="aplicacao_de_champo_em_todo_o_carro" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.aplicacao_de_champo_em_todo_o_carro') }}</label>
                                                    </div>
                                                    @if($errors->has('aplicacao_de_champo_em_todo_o_carro'))
                                                    <span class="help-block" role="alert">{{ $errors->first('aplicacao_de_champo_em_todo_o_carro') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.aplicacao_de_champo_em_todo_o_carro_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('esfregar_todo_o_carro_com_a_escova') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="esfregar_todo_o_carro_com_a_escova" value="0">
                                                        <input type="checkbox" name="esfregar_todo_o_carro_com_a_escova" id="esfregar_todo_o_carro_com_a_escova" value="1" {{ $vehicleManageDelivery->esfregar_todo_o_carro_com_a_escova || old('esfregar_todo_o_carro_com_a_escova', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="esfregar_todo_o_carro_com_a_escova" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.esfregar_todo_o_carro_com_a_escova') }}</label>
                                                    </div>
                                                    @if($errors->has('esfregar_todo_o_carro_com_a_escova'))
                                                    <span class="help-block" role="alert">{{ $errors->first('esfregar_todo_o_carro_com_a_escova') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.esfregar_todo_o_carro_com_a_escova_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('retirar_com_agua') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="retirar_com_agua" value="0">
                                                        <input type="checkbox" name="retirar_com_agua" id="retirar_com_agua" value="1" {{ $vehicleManageDelivery->retirar_com_agua || old('retirar_com_agua', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="retirar_com_agua" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.retirar_com_agua') }}</label>
                                                    </div>
                                                    @if($errors->has('retirar_com_agua'))
                                                    <span class="help-block" role="alert">{{ $errors->first('retirar_com_agua') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.retirar_com_agua_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('verificar_sujidades_ainda_existentes') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="verificar_sujidades_ainda_existentes" value="0">
                                                        <input type="checkbox" name="verificar_sujidades_ainda_existentes" id="verificar_sujidades_ainda_existentes" value="1" {{ $vehicleManageDelivery->verificar_sujidades_ainda_existentes || old('verificar_sujidades_ainda_existentes', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="verificar_sujidades_ainda_existentes" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.verificar_sujidades_ainda_existentes') }}</label>
                                                    </div>
                                                    @if($errors->has('verificar_sujidades_ainda_existentes'))
                                                    <span class="help-block" role="alert">{{ $errors->first('verificar_sujidades_ainda_existentes') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.verificar_sujidades_ainda_existentes_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('limpeza_de_jantes') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="limpeza_de_jantes" value="0">
                                                        <input type="checkbox" name="limpeza_de_jantes" id="limpeza_de_jantes" value="1" {{ $vehicleManageDelivery->limpeza_de_jantes || old('limpeza_de_jantes', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="limpeza_de_jantes" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.limpeza_de_jantes') }}</label>
                                                    </div>
                                                    @if($errors->has('limpeza_de_jantes'))
                                                    <span class="help-block" role="alert">{{ $errors->first('limpeza_de_jantes') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.limpeza_de_jantes_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('possui_extintor') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="possui_extintor" value="0">
                                                        <input type="checkbox" name="possui_extintor" id="possui_extintor" value="1" {{ $vehicleManageDelivery->possui_extintor || old('possui_extintor', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="possui_extintor" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.possui_extintor') }}</label>
                                                    </div>
                                                    @if($errors->has('possui_extintor'))
                                                    <span class="help-block" role="alert">{{ $errors->first('possui_extintor') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.possui_extintor_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('banco_elevatorio_crianca') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="banco_elevatorio_crianca" value="0">
                                                        <input type="checkbox" name="banco_elevatorio_crianca" id="banco_elevatorio_crianca" value="1" {{ $vehicleManageDelivery->banco_elevatorio_crianca || old('banco_elevatorio_crianca', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="banco_elevatorio_crianca" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.banco_elevatorio_crianca') }}</label>
                                                    </div>
                                                    @if($errors->has('banco_elevatorio_crianca'))
                                                    <span class="help-block" role="alert">{{ $errors->first('banco_elevatorio_crianca') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.banco_elevatorio_crianca_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('colete') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="colete" value="0">
                                                        <input type="checkbox" name="colete" id="colete" value="1" {{ $vehicleManageDelivery->colete || old('colete', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="colete" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.colete') }}</label>
                                                    </div>
                                                    @if($errors->has('colete'))
                                                    <span class="help-block" role="alert">{{ $errors->first('colete') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.colete_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('possui_triangulo') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="possui_triangulo" value="0">
                                                        <input type="checkbox" name="possui_triangulo" id="possui_triangulo" value="1" {{ $vehicleManageDelivery->possui_triangulo || old('possui_triangulo', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="possui_triangulo" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.possui_triangulo') }}</label>
                                                    </div>
                                                    @if($errors->has('possui_triangulo'))
                                                    <span class="help-block" role="alert">{{ $errors->first('possui_triangulo') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.possui_triangulo_helper') }}</span>
                                                </div>
                                                <div class="form-group {{ $errors->has('telemovel_sim') ? 'has-error' : '' }}">
                                                    <div>
                                                        <input type="hidden" name="telemovel_sim" value="0">
                                                        <input type="checkbox" name="telemovel_sim" id="telemovel_sim" value="1" {{ $vehicleManageDelivery->telemovel_sim || old('telemovel_sim', 0) === 1 ? 'checked' : '' }}>
                                                        <label for="telemovel_sim" style="font-weight: 400">Tem telemóvel?</label>
                                                    </div>
                                                    @if($errors->has('telemovel_sim'))
                                                    <span class="help-block" role="alert">{{ $errors->first('telemovel_sim') }}</span>
                                                    @endif
                                                    <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.telemovel_sim_helper') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="deliveries-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('copia_de_licenca_de_tvde') ? 'has-error' : '' }}">
                                            <div>
                                                <input type="hidden" name="copia_de_licenca_de_tvde" value="0">
                                                <input type="checkbox" name="copia_de_licenca_de_tvde" id="copia_de_licenca_de_tvde" value="1" {{ $vehicleManageDelivery->copia_de_licenca_de_tvde || old('copia_de_licenca_de_tvde', 0) === 1 ? 'checked' : '' }}>
                                                <label for="copia_de_licenca_de_tvde" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde') }}</label>
                                            </div>
                                            @if($errors->has('copia_de_licenca_de_tvde'))
                                            <span class="help-block" role="alert">{{ $errors->first('copia_de_licenca_de_tvde') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('copia_de_licenca_de_tvde_data') ? 'has-error' : '' }}">
                                            <label for="copia_de_licenca_de_tvde_data">{{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde_data') }}</label>
                                            <input class="form-control date" type="text" name="copia_de_licenca_de_tvde_data" id="copia_de_licenca_de_tvde_data" value="{{ old('copia_de_licenca_de_tvde_data', $vehicleManageDelivery->copia_de_licenca_de_tvde_data) }}">
                                            @if($errors->has('copia_de_licenca_de_tvde_data'))
                                            <span class="help-block" role="alert">{{ $errors->first('copia_de_licenca_de_tvde_data') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde_data_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('copia_de_licenca_de_tvde_comentarios') ? 'has-error' : '' }}">
                                            <label for="copia_de_licenca_de_tvde_comentarios">{{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde_comentarios') }}</label>
                                            <input class="form-control" type="text" name="copia_de_licenca_de_tvde_comentarios" id="copia_de_licenca_de_tvde_comentarios" value="{{ old('copia_de_licenca_de_tvde_comentarios', $vehicleManageDelivery->copia_de_licenca_de_tvde_comentarios) }}">
                                            @if($errors->has('copia_de_licenca_de_tvde_comentarios'))
                                            <span class="help-block" role="alert">{{ $errors->first('copia_de_licenca_de_tvde_comentarios') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde_comentarios_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('carta_verde_de_seguro_validade') ? 'has-error' : '' }}">
                                            <div>
                                                <input type="hidden" name="carta_verde_de_seguro_validade" value="0">
                                                <input type="checkbox" name="carta_verde_de_seguro_validade" id="carta_verde_de_seguro_validade" value="1" {{ $vehicleManageDelivery->carta_verde_de_seguro_validade || old('carta_verde_de_seguro_validade', 0) === 1 ? 'checked' : '' }}>
                                                <label for="carta_verde_de_seguro_validade" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade') }}</label>
                                            </div>
                                            @if($errors->has('carta_verde_de_seguro_validade'))
                                            <span class="help-block" role="alert">{{ $errors->first('carta_verde_de_seguro_validade') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('carta_verde_de_seguro_validade_data') ? 'has-error' : '' }}">
                                            <label for="carta_verde_de_seguro_validade_data">{{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade_data') }}</label>
                                            <input class="form-control date" type="text" name="carta_verde_de_seguro_validade_data" id="carta_verde_de_seguro_validade_data" value="{{ old('carta_verde_de_seguro_validade_data', $vehicleManageDelivery->carta_verde_de_seguro_validade_data) }}">
                                            @if($errors->has('carta_verde_de_seguro_validade_data'))
                                            <span class="help-block" role="alert">{{ $errors->first('carta_verde_de_seguro_validade_data') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade_data_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('carta_verde_de_seguro_validade_comentarios') ? 'has-error' : '' }}">
                                            <label for="carta_verde_de_seguro_validade_comentarios">{{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade_comentarios') }}</label>
                                            <input class="form-control" type="text" name="carta_verde_de_seguro_validade_comentarios" id="carta_verde_de_seguro_validade_comentarios" value="{{ old('carta_verde_de_seguro_validade_comentarios', $vehicleManageDelivery->carta_verde_de_seguro_validade_comentarios) }}">
                                            @if($errors->has('carta_verde_de_seguro_validade_comentarios'))
                                            <span class="help-block" role="alert">{{ $errors->first('carta_verde_de_seguro_validade_comentarios') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade_comentarios_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('dua_do_veiculo') ? 'has-error' : '' }}">
                                            <div>
                                                <input type="hidden" name="dua_do_veiculo" value="0">
                                                <input type="checkbox" name="dua_do_veiculo" id="dua_do_veiculo" value="1" {{ $vehicleManageDelivery->dua_do_veiculo || old('dua_do_veiculo', 0) === 1 ? 'checked' : '' }}>
                                                <label for="dua_do_veiculo" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo') }}</label>
                                            </div>
                                            @if($errors->has('dua_do_veiculo'))
                                            <span class="help-block" role="alert">{{ $errors->first('dua_do_veiculo') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('dua_do_veiculo_data') ? 'has-error' : '' }}">
                                            <label for="dua_do_veiculo_data">{{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo_data') }}</label>
                                            <input class="form-control date" type="text" name="dua_do_veiculo_data" id="dua_do_veiculo_data" value="{{ old('dua_do_veiculo_data', $vehicleManageDelivery->dua_do_veiculo_data) }}">
                                            @if($errors->has('dua_do_veiculo_data'))
                                            <span class="help-block" role="alert">{{ $errors->first('dua_do_veiculo_data') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo_data_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('dua_do_veiculo_comentarios') ? 'has-error' : '' }}">
                                            <label for="dua_do_veiculo_comentarios">{{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo_comentarios') }}</label>
                                            <input class="form-control" type="text" name="dua_do_veiculo_comentarios" id="dua_do_veiculo_comentarios" value="{{ old('dua_do_veiculo_comentarios', $vehicleManageDelivery->dua_do_veiculo_comentarios) }}">
                                            @if($errors->has('dua_do_veiculo_comentarios'))
                                            <span class="help-block" role="alert">{{ $errors->first('dua_do_veiculo_comentarios') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo_comentarios_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('inspecao_do_veiculo_validade') ? 'has-error' : '' }}">
                                            <div>
                                                <input type="hidden" name="inspecao_do_veiculo_validade" value="0">
                                                <input type="checkbox" name="inspecao_do_veiculo_validade" id="inspecao_do_veiculo_validade" value="1" {{ $vehicleManageDelivery->inspecao_do_veiculo_validade || old('inspecao_do_veiculo_validade', 0) === 1 ? 'checked' : '' }}>
                                                <label for="inspecao_do_veiculo_validade" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade') }}</label>
                                            </div>
                                            @if($errors->has('inspecao_do_veiculo_validade'))
                                            <span class="help-block" role="alert">{{ $errors->first('inspecao_do_veiculo_validade') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('inspecao_do_veiculo_validade_data') ? 'has-error' : '' }}">
                                            <label for="inspecao_do_veiculo_validade_data">{{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade_data') }}</label>
                                            <input class="form-control date" type="text" name="inspecao_do_veiculo_validade_data" id="inspecao_do_veiculo_validade_data" value="{{ old('inspecao_do_veiculo_validade_data', $vehicleManageDelivery->inspecao_do_veiculo_validade_data) }}">
                                            @if($errors->has('inspecao_do_veiculo_validade_data'))
                                            <span class="help-block" role="alert">{{ $errors->first('inspecao_do_veiculo_validade_data') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade_data_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('inspecao_do_veiculo_validade_comentarios') ? 'has-error' : '' }}">
                                            <label for="inspecao_do_veiculo_validade_comentarios">{{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade_comentarios') }}</label>
                                            <input class="form-control" type="text" name="inspecao_do_veiculo_validade_comentarios" id="inspecao_do_veiculo_validade_comentarios" value="{{ old('inspecao_do_veiculo_validade_comentarios', $vehicleManageDelivery->inspecao_do_veiculo_validade_comentarios) }}">
                                            @if($errors->has('inspecao_do_veiculo_validade_comentarios'))
                                            <span class="help-block" role="alert">{{ $errors->first('inspecao_do_veiculo_validade_comentarios') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade_comentarios_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('contratro_de_prestacao_de_servicos') ? 'has-error' : '' }}">
                                            <div>
                                                <input type="hidden" name="contratro_de_prestacao_de_servicos" value="0">
                                                <input type="checkbox" name="contratro_de_prestacao_de_servicos" id="contratro_de_prestacao_de_servicos" value="1" {{ $vehicleManageDelivery->contratro_de_prestacao_de_servicos || old('contratro_de_prestacao_de_servicos', 0) === 1 ? 'checked' : '' }}>
                                                <label for="contratro_de_prestacao_de_servicos" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos') }}</label>
                                            </div>
                                            @if($errors->has('contratro_de_prestacao_de_servicos'))
                                            <span class="help-block" role="alert">{{ $errors->first('contratro_de_prestacao_de_servicos') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('contratro_de_prestacao_de_servicos_data') ? 'has-error' : '' }}">
                                            <label for="contratro_de_prestacao_de_servicos_data">{{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos_data') }}</label>
                                            <input class="form-control date" type="text" name="contratro_de_prestacao_de_servicos_data" id="contratro_de_prestacao_de_servicos_data" value="{{ old('contratro_de_prestacao_de_servicos_data', $vehicleManageDelivery->contratro_de_prestacao_de_servicos_data) }}">
                                            @if($errors->has('contratro_de_prestacao_de_servicos_data'))
                                            <span class="help-block" role="alert">{{ $errors->first('contratro_de_prestacao_de_servicos_data') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos_data_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('contratro_de_prestacao_de_servicos_comentarios') ? 'has-error' : '' }}">
                                            <label for="contratro_de_prestacao_de_servicos_comentarios">{{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos_comentarios') }}</label>
                                            <input class="form-control" type="text" name="contratro_de_prestacao_de_servicos_comentarios" id="contratro_de_prestacao_de_servicos_comentarios" value="{{ old('contratro_de_prestacao_de_servicos_comentarios', $vehicleManageDelivery->contratro_de_prestacao_de_servicos_comentarios) }}">
                                            @if($errors->has('contratro_de_prestacao_de_servicos_comentarios'))
                                            <span class="help-block" role="alert">{{ $errors->first('contratro_de_prestacao_de_servicos_comentarios') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos_comentarios_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('distico_tvde_colocado') ? 'has-error' : '' }}">
                                            <div>
                                                <input type="hidden" name="distico_tvde_colocado" value="0">
                                                <input type="checkbox" name="distico_tvde_colocado" id="distico_tvde_colocado" value="1" {{ $vehicleManageDelivery->distico_tvde_colocado || old('distico_tvde_colocado', 0) === 1 ? 'checked' : '' }}>
                                                <label for="distico_tvde_colocado" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado') }}</label>
                                            </div>
                                            @if($errors->has('distico_tvde_colocado'))
                                            <span class="help-block" role="alert">{{ $errors->first('distico_tvde_colocado') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('distico_tvde_colocado_data') ? 'has-error' : '' }}">
                                            <label for="distico_tvde_colocado_data">{{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado_data') }}</label>
                                            <input class="form-control date" type="text" name="distico_tvde_colocado_data" id="distico_tvde_colocado_data" value="{{ old('distico_tvde_colocado_data', $vehicleManageDelivery->distico_tvde_colocado_data) }}">
                                            @if($errors->has('distico_tvde_colocado_data'))
                                            <span class="help-block" role="alert">{{ $errors->first('distico_tvde_colocado_data') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado_data_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('distico_tvde_colocado_comentarios') ? 'has-error' : '' }}">
                                            <label for="distico_tvde_colocado_comentarios">{{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado_comentarios') }}</label>
                                            <input class="form-control" type="text" name="distico_tvde_colocado_comentarios" id="distico_tvde_colocado_comentarios" value="{{ old('distico_tvde_colocado_comentarios', $vehicleManageDelivery->distico_tvde_colocado_comentarios) }}">
                                            @if($errors->has('distico_tvde_colocado_comentarios'))
                                            <span class="help-block" role="alert">{{ $errors->first('distico_tvde_colocado_comentarios') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado_comentarios_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('declaracao_amigavel') ? 'has-error' : '' }}">
                                            <div>
                                                <input type="hidden" name="declaracao_amigavel" value="0">
                                                <input type="checkbox" name="declaracao_amigavel" id="declaracao_amigavel" value="1" {{ $vehicleManageDelivery->declaracao_amigavel || old('declaracao_amigavel', 0) === 1 ? 'checked' : '' }}>
                                                <label for="declaracao_amigavel" style="font-weight: 400">{{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel') }}</label>
                                            </div>
                                            @if($errors->has('declaracao_amigavel'))
                                            <span class="help-block" role="alert">{{ $errors->first('declaracao_amigavel') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('declaracao_amigavel_data') ? 'has-error' : '' }}">
                                            <label for="declaracao_amigavel_data">{{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel_data') }}</label>
                                            <input class="form-control date" type="text" name="declaracao_amigavel_data" id="declaracao_amigavel_data" value="{{ old('declaracao_amigavel_data', $vehicleManageDelivery->declaracao_amigavel_data) }}">
                                            @if($errors->has('declaracao_amigavel_data'))
                                            <span class="help-block" role="alert">{{ $errors->first('declaracao_amigavel_data') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel_data_helper') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('declaracao_amigavel_comentarios') ? 'has-error' : '' }}">
                                            <label for="declaracao_amigavel_comentarios">{{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel_comentarios') }}</label>
                                            <input class="form-control" type="text" name="declaracao_amigavel_comentarios" id="declaracao_amigavel_comentarios" value="{{ old('declaracao_amigavel_comentarios', $vehicleManageDelivery->declaracao_amigavel_comentarios) }}">
                                            @if($errors->has('declaracao_amigavel_comentarios'))
                                            <span class="help-block" role="alert">{{ $errors->first('declaracao_amigavel_comentarios') }}</span>
                                            @endif
                                            <span class="help-block">{{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel_comentarios_helper') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="deliveries-3">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            @if ($vehicleManageDelivery->signature_driver_data &&
                                            $vehicleManageDelivery->signature_collector_data)
                                            <div class="col-md-12">
                                                <div class="alert alert-success" role="alert">As assinaturas já foram recolhidas</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="signature-collector">Recolha da viatura:</label><br>
                                                <img src="{{ $vehicleManageDelivery->signature_collector_data }}" alt="Assinatura de quem recolhe a viatura" style="border:1px solid #000; width: 400px; height: 150px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="signature-driver">Motorista:</label><br>
                                                <img src="{{ $vehicleManageDelivery->signature_driver_data }}" alt="Assinatura do motorista" style="border:1px solid #000; width: 400px; height: 150px;">
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
                                        @if ($vehicleManageDelivery->signature_driver_data &&
                                        $vehicleManageDelivery->signature_collector_data)
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
@endsection
@section('scripts')
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