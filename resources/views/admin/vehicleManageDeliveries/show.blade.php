@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.vehicleManageDelivery.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-manage-deliveries.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.vehicle_item') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->vehicle_item->license_plate ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.driver') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->driver->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.data_e_horario') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->data_e_horario }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.de_bateria_de_saida') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->de_bateria_de_saida }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.km_atual') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->km_atual }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.aspiracao_bancos_frente') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->aspiracao_bancos_frente ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.aspiracao_bancos_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->aspiracao_bancos_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.aspiracao_tapetes_e_chao_frente') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->aspiracao_tapetes_e_chao_frente ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.aspiracao_tapetes_e_chao_tras') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->aspiracao_tapetes_e_chao_tras ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.limpeza_e_brilho_de_plasticos_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->limpeza_e_brilho_de_plasticos_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.ambientador_de_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->ambientador_de_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.limpeza_vidros_interiores') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->limpeza_vidros_interiores ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.retirar_os_objetos_pessoais_existentes_no_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->retirar_os_objetos_pessoais_existentes_no_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.verificacao_de_luzes_no_painel') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->verificacao_de_luzes_no_painel ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.verificacao_de_necessidade_de_lavagem_estofos') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->verificacao_de_necessidade_de_lavagem_estofos ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.check_list_aspiracao_obs') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->check_list_aspiracao_obs }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->copia_de_licenca_de_tvde ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->copia_de_licenca_de_tvde_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.copia_de_licenca_de_tvde_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->copia_de_licenca_de_tvde_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->carta_verde_de_seguro_validade ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->carta_verde_de_seguro_validade_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.carta_verde_de_seguro_validade_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->carta_verde_de_seguro_validade_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->dua_do_veiculo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->dua_do_veiculo_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.dua_do_veiculo_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->dua_do_veiculo_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->inspecao_do_veiculo_validade ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->inspecao_do_veiculo_validade_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.inspecao_do_veiculo_validade_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->inspecao_do_veiculo_validade_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->contratro_de_prestacao_de_servicos ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->contratro_de_prestacao_de_servicos_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.contratro_de_prestacao_de_servicos_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->contratro_de_prestacao_de_servicos_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->distico_tvde_colocado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->distico_tvde_colocado_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.distico_tvde_colocado_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->distico_tvde_colocado_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->declaracao_amigavel ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->declaracao_amigavel_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.declaracao_amigavel_comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->declaracao_amigavel_comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.aplicacao_de_agua_por_todo_o_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->aplicacao_de_agua_por_todo_o_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.passagem_de_agua_em_todo_o_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->passagem_de_agua_em_todo_o_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.aplicacao_de_champo_em_todo_o_carro') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->aplicacao_de_champo_em_todo_o_carro ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.esfregar_todo_o_carro_com_a_escova') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->esfregar_todo_o_carro_com_a_escova ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.retirar_com_agua') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->retirar_com_agua ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.verificar_sujidades_ainda_existentes') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->verificar_sujidades_ainda_existentes ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.limpeza_de_jantes') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->limpeza_de_jantes ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.possui_extintor') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->possui_extintor ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.banco_elevatorio_crianca') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->banco_elevatorio_crianca ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.colete') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->colete ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.tratado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->tratado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.comentarios') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->comentarios }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.reparado') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->reparado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.possui_triangulo') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->possui_triangulo ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.cinzeiro_minutos') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->cinzeiro_minutos }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.telemovel_sim') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $vehicleManageDelivery->telemovel_sim ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.signature_collector_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->signature_collector_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vehicleManageDelivery.fields.signature_driver_data') }}
                                    </th>
                                    <td>
                                        {{ $vehicleManageDelivery->signature_driver_data }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.vehicle-manage-deliveries.index') }}">
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