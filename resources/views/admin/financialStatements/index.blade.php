@extends('layouts.admin')
@section('content')
<div class="content">
    @if ($company_id == 0)
    <div class="alert alert-info" role="alert">
        Selecione uma empresa para ver os seus extratos.
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
    <a href="/admin/financial-statements/driver/0"
        class="btn btn-default {{ $driver_id == null ? 'disabled selected' : '' }}" style="margin-top: 5px;">Todos</a>
    @foreach ($drivers as $driver)
    <a href="/admin/financial-statements/driver/{{ $driver->id }}"
        class="btn btn-default {{ $driver_id == $driver->id ? 'disabled selected' : '' }}" style="margin-top: 5px;">{{
        $driver->name }}</a>
    @endforeach
    <div class="row" style="margin-top: 5px;">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Atividades por operador
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>UBER</th>
                                <td>{{ $total_earnings_uber }}€</td>
                                <td>{{ $contract_type_rank->percent }}%</td>
                                <td>{{ $total_uber }}€</td>
                            </tr>
                            <tr>
                                <th>BOLT</th>
                                <td>{{ $total_earnings_bolt }}€</td>
                                <td>{{ $contract_type_rank->percent }}%</td>
                                <td>{{ $total_bolt }}€</td>
                            </tr>
                            <tr>
                                <th>Gorjeta UBER</th>
                                <td>{{ $total_tips_uber }}€</td>
                                <td>{{ $uber_tip_percent }}%</td>
                                <td>{{ $uber_tip_after_vat }}€</td>
                            </tr>
                            <tr>
                                <th>Gorjeta BOLT</th>
                                <td>{{ $total_tips_bolt }}€</td>
                                <td>{{ $bolt_tip_percent }}%</td>
                                <td>{{ $bolt_tip_after_vat }}€</td>
                            </tr>
                            <tr>
                                <th>Totais</th>
                                <td>{{ $total }}€</td>
                                <td></td>
                                <td>{{ $total_after_vat }}€</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Totais
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th></th>
                                <th style="text-align: right;">Créditos</th>
                                <th style="text-align: right;">Débitos</th>
                                <th style="text-align: right;">Totais</th>
                            </tr>
                            <tr>
                                <th>Ganhos</th>
                                <td>{{ $total_earnings }}€</td>
                                <td>- {{ $total_earnings - $total_after_vat }}€</td>
                                <td>{{ $total_after_vat }}€</td>
                            </tr>
                            <tr>
                                <th>Gorjetas</th>
                                <td>{{ $total_tips }}€</td>
                                <td>- {{ $total_tips - $total_tip_after_vat }}€</td>
                                <td>{{ $total_tip_after_vat }}€</td>
                            </tr>
                            @foreach ($adjustments as $adjustment)
                            <tr>
                                <th>{{ $adjustment->name }}</th>
                                <td>{{ $adjustment->type == 'refund' ? '' . $adjustment->amount . '€' : '' }}</td>
                                <td>{{ $adjustment->type == 'deduct' ? '- ' . $adjustment->amount . '€' : '' }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            <tr>
                                <th>Totais</th>
                                <th style="text-align: right;">{{ $gross_credits }}€</th>
                                <th style="text-align: right;">- {{ $gross_debts }}€</th>
                                <th style="text-align: right;">{{ $final_total }}€</th>
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
@section('styles')
<style>
    td {
        text-align: right;
    }

    table {
        font-size: 13px;
    }
</style>
@endsection
<script>
    console.log({
        bolt_activities: {!! $bolt_activities !!},
        uber_activities: {!! $uber_activities !!}
    });
</script>