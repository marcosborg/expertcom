<?php

namespace App\Http\Requests;

use App\Models\DrvSegment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDrvSegmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('drv_segment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:drv_segments,id',
        ];
    }
}
