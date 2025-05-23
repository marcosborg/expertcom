<?php

namespace App\Http\Requests;

use App\Models\Company;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('company_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'vat' => [
                'string',
                'required',
            ],
            'address' => [
                'string',
                'required',
            ],
            'zip' => [
                'string',
                'required',
            ],
            'location' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
            ],
            'phone' => [
                'string',
                'nullable'
            ],
            'lead' => [
                'string',
                'nullable'
            ]
        ];
    }
}
