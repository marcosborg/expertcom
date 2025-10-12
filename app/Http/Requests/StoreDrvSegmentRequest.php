<?php

namespace App\Http\Requests;

use App\Models\DrvSegment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDrvSegmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('drv_segment_create');
    }

    public function rules()
    {
        return [
            'session_id' => [
                'required',
                'integer',
            ],
            'kind' => [
                'required',
            ],
            'started_at' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'ended_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'duration_seconds' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'notes' => [
                'string',
                'nullable',
            ],
        ];
    }
}
