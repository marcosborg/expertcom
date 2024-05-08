@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.registoEntradaVeiculo.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.registo-entrada-veiculos.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.data_e_horario') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->data_e_horario }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.driver') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->driver->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.vehicle_item') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->vehicle_item->license_plate ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.bateria_a_chegada') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->bateria_a_chegada }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.de_bateria_de_saida') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->de_bateria_de_saida }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.km_atual') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->km_atual }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_teto') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->frente_do_veiculo_teto ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_parabrisa') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->frente_do_veiculo_parabrisa ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_capo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->frente_do_veiculo_capo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_parachoque') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->frente_do_veiculo_parachoque ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->frente_do_veiculo_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_obs') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->frente_do_veiculo_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_teto_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->frente_do_veiculo_teto_photos as $key => $media)
                                            <img src="{{ $media->getUrl() }}" style="max-width: 200px;">
                                                {{ trans('global.view_file') }}
                                    </img>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_parabrisa_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->frente_do_veiculo_parabrisa_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_capo_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->frente_do_veiculo_capo_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.frente_do_veiculo_parachoque_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->frente_do_veiculo_parachoque_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_paralama_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_esquerda_paralama_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_retrovisor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_esquerda_retrovisor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_esquerda_porta_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_esquerda_porta_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_lateral') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_esquerda_lateral ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_esquerda_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_obs') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->lateral_esquerda_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_paralama_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_esquerda_paralama_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_retrovisor_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_esquerda_retrovisor_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_esquerda_porta_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_porta_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_esquerda_porta_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_esquerda_lateral_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_esquerda_lateral_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_mala') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_mala ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_farol_dir') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_farol_dir ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_farol_esq') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_farol_esq ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_parachoque_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_parachoque_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_pneu_reserva') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_pneu_reserva ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_macaco') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_macaco ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_chave_de_roda') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_chave_de_roda ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_triangulo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_triangulo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->traseira_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_obs') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->traseira_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_tampa_traseira_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_tampa_traseira_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_lanternas_dir_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_lanternas_dir_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_lanterna_esq_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_lanterna_esq_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_parachoque_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_parachoque_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_estepe_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_estepe_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_macaco_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_macaco_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_chave_de_roda_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_chave_de_roda_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.traseira_triangulo_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->traseira_triangulo_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_lateral') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_direita_lateral ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_direita_porta_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_direita_porta_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_retrovisor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_direita_retrovisor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_paralama_diant') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_direita_paralama_diant ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->lateral_direita_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_lateral_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_direita_lateral_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_tras_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_direita_porta_tras_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_porta_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_direita_porta_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_retrovisor_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_direita_retrovisor_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_paralama_diant_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->lateral_direita_paralama_diant_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.lateral_direita_obs') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->lateral_direita_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.cinzeiro_sim') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->cinzeiro_sim ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.cinzeiro_nada_consta') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->cinzeiro_nada_consta ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.cinzeiro_photos') }}
                                    </th>
                                    <td>
                                        @foreach($registoEntradaVeiculo->cinzeiro_photos as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.aspiracao_bancos_frente') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->aspiracao_bancos_frente ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.aspiracao_bancos_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->aspiracao_bancos_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.aspiracao_tapetes_e_chao_frente') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->aspiracao_tapetes_e_chao_frente ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.aspiracao_tapetes_e_chao_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->aspiracao_tapetes_e_chao_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.limpeza_e_brilho_de_plasticos_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->limpeza_e_brilho_de_plasticos_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.ambientador_de_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->ambientador_de_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.limpeza_vidros_interiores') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->limpeza_vidros_interiores ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.retirar_os_objetos_pessoais_existentes_no_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->retirar_os_objetos_pessoais_existentes_no_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.verificacao_de_luzes_no_painel') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->verificacao_de_luzes_no_painel ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.verificacao_de_necessidade_de_lavagem_estofos') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->verificacao_de_necessidade_de_lavagem_estofos ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.check_list_aspiracao_obs') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->check_list_aspiracao_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->copia_de_licenca_de_tvde ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde_data') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->copia_de_licenca_de_tvde_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.copia_de_licenca_de_tvde_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->copia_de_licenca_de_tvde_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_validade') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->carta_verde_de_seguro_validade ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_validade_data') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->carta_verde_de_seguro_validade_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.carta_verde_de_seguro_validade_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->carta_verde_de_seguro_validade_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->dua_do_veiculo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo_data') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->dua_do_veiculo_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.dua_do_veiculo_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->dua_do_veiculo_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->inspecao_do_veiculo_validade ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade_data') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->inspecao_do_veiculo_validade_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.inspecao_do_veiculo_validade_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->inspecao_do_veiculo_validade_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->contratro_de_prestacao_de_servicos ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos_data') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->contratro_de_prestacao_de_servicos_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.contratro_de_prestacao_de_servicos_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->contratro_de_prestacao_de_servicos_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->distico_tvde_colocado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado_data') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->distico_tvde_colocado_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.distico_tvde_colocado_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->distico_tvde_colocado_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->declaracao_amigavel ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel_data') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->declaracao_amigavel_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.declaracao_amigavel_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->declaracao_amigavel_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.aplicacao_de_agua_por_todo_o_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->aplicacao_de_agua_por_todo_o_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.passagem_de_agua_em_todo_o_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->passagem_de_agua_em_todo_o_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.aplicacao_de_champo_em_todo_o_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->aplicacao_de_champo_em_todo_o_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.esfregar_todo_o_carro_com_a_escova') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->esfregar_todo_o_carro_com_a_escova ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.retirar_com_agua') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->retirar_com_agua ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.verificar_sujidades_ainda_existentes') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->verificar_sujidades_ainda_existentes ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.limpeza_de_jantes') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->limpeza_de_jantes ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.possui_triangulo') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->possui_triangulo }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.possui_extintor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->possui_extintor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.banco_elevatorio_crianca') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->banco_elevatorio_crianca ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.colete') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->colete ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.tratado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->tratado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.comentarios') }}
                                    </th>
                                    <td>
                                        {{ $registoEntradaVeiculo->comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.registoEntradaVeiculo.fields.reparado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $registoEntradaVeiculo->reparado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.registo-entrada-veiculos.index') }}">
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