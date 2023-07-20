<?php

namespace App\Http\Requests;

use App\Models\Adjust;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdjustRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('adjust_edit');
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
            'adjustment_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
