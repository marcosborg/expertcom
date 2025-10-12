<?php

namespace App\Http\Requests;

use App\Models\DrvSession;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDrvSessionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('drv_session_edit');
    }

    public function rules()
    {
        return [
            'driver_id' => [
                'required',
                'integer',
            ],
            'started_at' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'ended_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'status' => [
                'required',
            ],
            'total_drive_seconds' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_pause_seconds' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'started_lat' => [
                'numeric',
            ],
            'started_lng' => [
                'numeric',
            ],
            'ended_lat' => [
                'numeric',
            ],
            'ended_lng' => [
                'numeric',
            ],
        ];
    }
}
