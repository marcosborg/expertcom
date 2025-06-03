<?php

namespace App\Http\Requests;

use App\Models\VehicleManageCheckin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVehicleManageCheckinRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_manage_checkin_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'vehicle_item_id' => [
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
            'bateria_a_chegada' => [
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
            'frente_do_veiculo_teto_photos' => [
                'array',
            ],
            'frente_do_veiculo_parabrisa_photos' => [
                'array',
            ],
            'frente_do_veiculo_capo_photos' => [
                'array',
            ],
            'frente_do_veiculo_parachoque_photos' => [
                'array',
            ],
            'lateral_esquerda_paralama_diant_photos' => [
                'array',
            ],
            'lateral_esquerda_retrovisor_photos' => [
                'array',
            ],
            'lateral_esquerda_porta_diant_photos' => [
                'array',
            ],
            'lateral_esquerda_porta_tras_photos' => [
                'array',
            ],
            'lateral_esquerda_lateral_photos' => [
                'array',
            ],
            'traseira_tampa_traseira_photos' => [
                'array',
            ],
            'traseira_lanternas_dir_photos' => [
                'array',
            ],
            'traseira_lanterna_esq_photos' => [
                'array',
            ],
            'traseira_parachoque_tras_photos' => [
                'array',
            ],
            'traseira_estepe_photos' => [
                'array',
            ],
            'traseira_macaco_photos' => [
                'array',
            ],
            'traseira_chave_de_roda_photos' => [
                'array',
            ],
            'traseira_triangulo_photos' => [
                'array',
            ],
            'lateral_direita_lateral_photos' => [
                'array',
            ],
            'lateral_direita_porta_tras_photos' => [
                'array',
            ],
            'lateral_direita_porta_diant_photos' => [
                'array',
            ],
            'lateral_direita_retrovisor_photos' => [
                'array',
            ],
            'lateral_direita_paralama_diant_photos' => [
                'array',
            ],
            'cinzeiro_photos' => [
                'array',
            ],
            'telemovel_photos' => [
                'array',
            ],
        ];
    }
}
