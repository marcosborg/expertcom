<?php

namespace App\Http\Requests;

use App\Models\RecruitmentForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRecruitmentFormRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('recruitment_form_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
            ],
            'phone' => [
                'string',
                'required',
            ],
            'appointment' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'not_recruited_reason' => [
                'nullable',
                'in:Não possui licença TVDE,Não é do Grande Porto,Melhores condições,Rejeitado,Outro',
            ],
            'responsible_for_the_lead' => [
                'string',
                'nullable'
            ],
            'start_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'end_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
