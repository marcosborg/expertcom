<?php

namespace App\Http\Requests;

use App\Models\VehicleManageEntry;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVehicleManageEntryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('vehicle_manage_entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:vehicle_manage_entries,id',
        ];
    }
}
