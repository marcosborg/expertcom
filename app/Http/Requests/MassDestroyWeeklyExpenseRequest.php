<?php

namespace App\Http\Requests;

use App\Models\WeeklyExpense;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWeeklyExpenseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('weekly_expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:weekly_expenses,id',
        ];
    }
}
