@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.vehicleManageCheckin.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-manage-checkins.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.vehicle_item') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->vehicle_item->license_plate ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.driver') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->driver->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.data_e_horario') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->data_e_horario }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.bateria_a_chegada') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->bateria_a_chegada }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.km_atual') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->km_atual }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_teto') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->frente_do_veiculo_teto ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_parabrisa') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->frente_do_veiculo_parabrisa ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_capo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->frente_do_veiculo_capo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_parachoque') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->frente_do_veiculo_parachoque ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->frente_do_veiculo_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_teto_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->frente_do_veiculo_teto_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_parabrisa_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->frente_do_veiculo_parabrisa_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_capo_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->frente_do_veiculo_capo_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_parachoque_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->frente_do_veiculo_parachoque_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.frente_do_veiculo_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->frente_do_veiculo_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_paralama_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_esquerda_paralama_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_retrovisor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_esquerda_retrovisor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_porta_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_esquerda_porta_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_porta_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_esquerda_porta_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_lateral') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_esquerda_lateral ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_esquerda_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_paralama_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_esquerda_paralama_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_retrovisor_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_esquerda_retrovisor_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_porta_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_esquerda_porta_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_porta_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_esquerda_porta_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_lateral_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_esquerda_lateral_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_esquerda_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->lateral_esquerda_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_mala') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_mala ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_farol_dir') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_farol_dir ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_farol_esq') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_farol_esq ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_parachoque_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_parachoque_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_pneu_reserva') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_pneu_reserva ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_macaco') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_macaco ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_chave_de_roda') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_chave_de_roda ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_triangulo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_triangulo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->traseira_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_tampa_traseira_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_tampa_traseira_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_lanternas_dir_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_lanternas_dir_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_lanterna_esq_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_lanterna_esq_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_parachoque_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_parachoque_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_estepe_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_estepe_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_macaco_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_macaco_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_chave_de_roda_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_chave_de_roda_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_triangulo_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->traseira_triangulo_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.traseira_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->traseira_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_lateral') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_direita_lateral ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_porta_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_direita_porta_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_porta_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_direita_porta_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_retrovisor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_direita_retrovisor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_paralama_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_direita_paralama_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->lateral_direita_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_lateral_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_direita_lateral_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_porta_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_direita_porta_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_porta_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_direita_porta_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_retrovisor_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_direita_retrovisor_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_paralama_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->lateral_direita_paralama_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.lateral_direita_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->lateral_direita_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.cinzeiro_sim') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->cinzeiro_sim ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.cinzeiro_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->cinzeiro_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.cinzeiro_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->cinzeiro_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.telemovel_sim') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->telemovel_sim ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.telemovel_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->telemovel_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.telemovel_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageCheckin->telemovel_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.tratado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->tratado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.reparado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageCheckin->reparado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.signature_collector_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->signature_collector_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageCheckin.fields.signature_driver_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageCheckin->signature_driver_data }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-manage-checkins.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection