<?php

namespace App\Http\Requests;

use App\Models\DrvTimesheet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDrvTimesheetRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('drv_timesheet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:drv_timesheets,id',
        ];
    }
}
