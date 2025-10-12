<?php

namespace App\Http\Requests;

use App\Models\DrvSession;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDrvSessionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('drv_session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:drv_sessions,id',
        ];
    }
}
