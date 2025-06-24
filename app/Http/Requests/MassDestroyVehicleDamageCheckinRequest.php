<?php

namespace App\Http\Requests;

use App\Models\VehicleDamageCheckin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVehicleDamageCheckinRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('vehicle_damage_checkin_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:vehicle_damage_checkins,id',
        ];
    }
}
