<?php

namespace App\Http\Requests;

use App\Models\VehicleManageDelivery;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVehicleManageDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_manage_delivery_create');
    }

    public function rules()
    {
        return [
            'vehicle_item_id' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'driver_id' => [
                'required',
                'integer',
            ],
            'data_e_horario' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'de_bateria_de_saida' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'km_atual' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'copia_de_licenca_de_tvde_data' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'copia_de_licenca_de_tvde_comentarios' => [
                'string',
                'nullable',
            ],
            'carta_verde_de_seguro_validade_data' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'carta_verde_de_seguro_validade_comentarios' => [
                'string',
                'nullable',
            ],
            'dua_do_veiculo_data' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'dua_do_veiculo_comentarios' => [
                'string',
                'nullable',
            ],
            'inspecao_do_veiculo_validade_data' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'inspecao_do_veiculo_validade_comentarios' => [
                'string',
                'nullable',
            ],
            'contratro_de_prestacao_de_servicos_data' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'contratro_de_prestacao_de_servicos_comentarios' => [
                'string',
                'nullable',
            ],
            'distico_tvde_colocado_data' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'distico_tvde_colocado_comentarios' => [
                'string',
                'nullable',
            ],
            'declaracao_amigavel_data' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'declaracao_amigavel_comentarios' => [
                'string',
                'nullable',
            ],
            'cinzeiro_minutos' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
