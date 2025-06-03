@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.vehicleManageEntry.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-manage-entries.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.vehicle_item') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->vehicle_item->license_plate ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.data_e_horario') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->data_e_horario }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.bateria_a_chegada') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->bateria_a_chegada }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.km_atual') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->km_atual }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_teto') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->frente_do_veiculo_teto ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parabrisa') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->frente_do_veiculo_parabrisa ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_capo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->frente_do_veiculo_capo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parachoque') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->frente_do_veiculo_parachoque ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->frente_do_veiculo_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->frente_do_veiculo_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_teto_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->frente_do_veiculo_teto_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parabrisa_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->frente_do_veiculo_parabrisa_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_capo_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->frente_do_veiculo_capo_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.frente_do_veiculo_parachoque_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->frente_do_veiculo_parachoque_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_paralama_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_esquerda_paralama_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_retrovisor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_esquerda_retrovisor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_esquerda_porta_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_esquerda_porta_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_lateral') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_esquerda_lateral ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_esquerda_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->lateral_esquerda_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_paralama_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_esquerda_paralama_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_retrovisor_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_esquerda_retrovisor_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_esquerda_porta_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_porta_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_esquerda_porta_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_esquerda_lateral_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_esquerda_lateral_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_mala') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_mala ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_farol_dir') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_farol_dir ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_farol_esq') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_farol_esq ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_parachoque_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_parachoque_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_pneu_reserva') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_pneu_reserva ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_macaco') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_macaco ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_chave_de_roda') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_chave_de_roda ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_triangulo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_triangulo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->traseira_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->traseira_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_tampa_traseira_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_tampa_traseira_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_lanternas_dir_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_lanternas_dir_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_lanterna_esq_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_lanterna_esq_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_parachoque_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_parachoque_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_estepe_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_estepe_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_macaco_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_macaco_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_chave_de_roda_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_chave_de_roda_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.traseira_triangulo_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->traseira_triangulo_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_lateral') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_direita_lateral ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_direita_porta_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_direita_porta_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_retrovisor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_direita_retrovisor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_paralama_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_direita_paralama_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->lateral_direita_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_lateral_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_direita_lateral_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_direita_porta_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_porta_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_direita_porta_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_retrovisor_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_direita_retrovisor_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_paralama_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->lateral_direita_paralama_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.lateral_direita_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->lateral_direita_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.cinzeiro_sim') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->cinzeiro_sim ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.cinzeiro_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->cinzeiro_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.cinzeiro_minutos') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->cinzeiro_minutos }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.cinzeiro_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->cinzeiro_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.telemovel_sim') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->telemovel_sim ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.telemovel_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->telemovel_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.telemovel_photos') }}
                                    </th>
                                    <td>
                                        @foreach($vehicleManageEntry->telemovel_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.possui_triangulo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->possui_triangulo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.possui_extintor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->possui_extintor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.colete') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->colete ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.disticos') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->disticos ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.via_verde') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageEntry->via_verde ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.signature_collector_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->signature_collector_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageEntry.fields.signature_driver_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageEntry->signature_driver_data }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-manage-entries.index') }}">
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