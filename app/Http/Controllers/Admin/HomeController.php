<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title' => 'Ranking de faturação semanal por motoristas',
            'chart_type' => 'bar',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\TvdeActivity',
            'group_by_field' => 'driver_code',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'earnings_one',
            'filter_field' => 'created_at',
            'column_class' => 'col-md-12',
            'entries_number' => '5',
            'translation_key' => 'tvdeActivity',
        ];

        $chart1 = new LaravelChart($settings1);

        return view('home', compact('chart1'));
    }

    public function selectCompany($company_id)
    {
        session()->put('company_id', $company_id);
    }
}