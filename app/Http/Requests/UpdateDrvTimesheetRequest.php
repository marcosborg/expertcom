<?php

namespace App\Http\Requests;

use App\Models\DrvTimesheet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDrvTimesheetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('drv_timesheet_edit');
    }

    public function rules()
    {
        return [
            'driver_id' => [
                'required',
                'integer',
            ],
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
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
        ];
    }
}
