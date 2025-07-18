<?php

namespace App\Http\Requests;

use App\Models\VehicleDamageCheckin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVehicleDamageCheckinRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_damage_checkin_create');
    }

    public function rules()
    {
        return [
            'vehicle_manage_checkin_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
