@extends('layouts.admin')
@section('styles')
<style>
    tr {
        line-height: 25px;
    }

    tr:nth-child(even) {
        background-color: #eeeeee;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>
@endsection
@section('content')
<div class="content">

    @if ($company_id == 0)
    <div class="alert alert-info" role="alert">
        Selecione uma empresa para ver os extratos.
    </div>
    @else
    <div class="btn-group btn-group-justified" role="group">
        @foreach ($tvde_years as $tvde_year)
        <a href="/admin/financial-statements/year/{{ $tvde_year->id }}"
            class="btn btn-default {{ $tvde_year->id == $tvde_year_id ? 'disabled selected' : '' }}">{{ $tvde_year->name
            }}</a>
        @endforeach
    </div>
    <div class="btn-group btn-group-justified" role="group" style="margin-top: 5px;">
        @foreach ($tvde_months as $tvde_month)
        <a href="/admin/financial-statements/month/{{ $tvde_month->id }}"
            class="btn btn-default {{ $tvde_month->id == $tvde_month_id ? 'disabled selected' : '' }}">{{
            $tvde_month->name
            }}</a>
        @endforeach
    </div>
    <div class="btn-group btn-group-justified" role="group" style="margin-top: 5px;">
        @foreach ($tvde_weeks as $tvde_week)
        <a href="/admin/financial-statements/week/{{ $tvde_week->id }}"
            class="btn btn-default {{ $tvde_week->id == $tvde_week_id ? 'disabled selected' : '' }}">Semana de {{
            \Carbon\Carbon::parse($tvde_week->start_date)->format('d')
            }} a {{ \Carbon\Carbon::parse($tvde_week->end_date)->format('d') }}</a>
        @endforeach
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Custos operacionais
                </div>
                <div class="panel-body">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="text-align: right;">Qtd.</th>
                                <th style="text-align: right;">Unitário</th>
                                <th style="text-align: right;">Semanal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Despesas fixas</th>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($company_expenses as $company_expense)
                            <tr>
                                <td>{{ $company_expense->name }}</td>
                                <td style="text-align: right;">{{ $company_expense->qty }}</td>
                                <td style="text-align: right;">{{ $company_expense->weekly_value }} <small>€</small>
                                </td>
                                <td style="text-align: right;">{{ number_format($company_expense->total, 2) }}
                                    <small>€</small>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <th>Despesas variáveis</th>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Ajustes</td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;">{{ number_format($totals['total_company_adjustments'], 2)
                                    }} <small>€</small></td>
                            </tr>
                            <tr>
                                <td>Park</td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right;">{{ $company_park }} <small>€</small></td>
                            </tr>
                            <tr>
                                <td>Pagamentos a motoristas</td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right">{{ number_format($totals['total_drivers'], 2) }} <small>€</small></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total de despesas</th>
                                <th></th>
                                <th></th>
                                <th style="text-align: right;">{{ number_format($final_total, 2) }} <small>€</small>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Rentabilidade semanal
                </div>
                <div class="panel-body">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <th>Ganhos</th>
                                <td style="text-align: right">{{ number_format($totals['total_operators'], 2) }} <small>€</small></td>
                            </tr>
                            <tr>
                                <th>Pagamentos a motoristas</th>
                                <td style="text-align: right">{{ number_format($totals['total_drivers'], 2) }} <small>€</small></td>
                            </tr>
                            <tr>
                                <th>Despesas da empresa</th>
                                <td style="text-align: right">{{ number_format($final_company_expenses, 2) }} <small>€</small></td>
                            </tr>
                            <tr>
                                <th>Rentabilidade</th>
                                <td style="text-align: right">{{ number_format($profit, 2) }} <small>€</small></td>
                            </tr>
                            <tr>
                                <th>ROI (Return of investment)</th>
                                <td style="text-align: right"><h1>{{ round($roi) }}<small>%</small></h1></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection