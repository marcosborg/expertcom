<?php

namespace App\Http\Requests;

use App\Models\Adjust;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdjustRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('adjust_create');
    }

    public function rules()
    {
        return [
            'value' => [
                'required',
            ],
            'tvde_week_id' => [
                'required',
                'integer',
            ],
            'driver_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
