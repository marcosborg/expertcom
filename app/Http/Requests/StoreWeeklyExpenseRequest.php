<?php

namespace App\Http\Requests;

use App\Models\WeeklyExpense;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWeeklyExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('weekly_expense_create');
    }

    public function rules()
    {
        return [
            'company_id' => [
                'required',
                'integer',
            ],
            'tvde_week_id' => [
                'required',
                'integer',
            ],
            'expenses' => [
                'required',
            ],
        ];
    }
}
