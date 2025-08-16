<?php

namespace App\Http\Requests;

use App\Models\DriverClass;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDriverClassRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('driver_class_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'from' => [
                'numeric',
            ],
            'to' => [
                'numeric',
                'required',
            ],
            'additional_commission' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'time_for_loyalty_bonus' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
