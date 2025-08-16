<?php

namespace App\Http\Requests;

use App\Models\DriverClass;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDriverClassRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('driver_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:driver_classes,id',
        ];
    }
}
