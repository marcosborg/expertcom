<?php

namespace App\Http\Requests;

use App\Models\Adjustment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdjustmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('adjustment_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'type' => [
                'required',
            ],
            'apply' => [
                'required',
            ],
        ];
    }
}
