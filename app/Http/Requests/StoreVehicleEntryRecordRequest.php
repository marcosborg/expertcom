<?php

namespace App\Http\Requests;

use App\Models\VehicleEntryRecord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVehicleEntryRecordRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_entry_record_create');
    }

    public function rules()
    {
        return [
            'date_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'vehicle_id' => [
                'required',
                'integer',
            ],
            'battery_enter' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'quilometers' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'photos' => [
                'array',
            ],
        ];
    }
}
