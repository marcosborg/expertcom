@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Atividade
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Semana</label>
                                <select class="form-control">
                                    <option selected disabled>Selecionar</option>
                                    @foreach ($tvde_weeks as $week)
                                        <option>{{ $week->start_date }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Condutor</label>
                                <select class="form-control">
                                    <option selected disabled>Selecionar</option>
                                    @foreach ($drivers as $d)
                                        <option>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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
                                <th>Gorjeta total</th>
                                <td>{{ $total_tips }}€</td>
                                <td></td>
                                <td>{{ $total_tip_after_vat }}€</td>
                            </tr>
                            @foreach ($adjustments as $adjustment)
                                <tr>
                                    <th>{{ $adjustment->name }}</th>
                                    <td>
                                        {{ $adjustment->amount ? $adjustment->amount . '€' : '' }}
                                        {{ $adjustment->percent ? $adjustment->percent . '%' : '' }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>

</div>
@endsection
<script>
    console.log({
    adjustments: {!! $adjustments !!},
    tvde_week: {!! $tvde_week !!},
    total_earnings_bolt: {!! $total_earnings_bolt !!},
    total_tips_bolt: {!! $total_tips_bolt !!},
    total_earnings_uber: {!! $total_earnings_uber !!},
    total_tips_uber: {!! $total_tips_uber !!},
    driver: {!! $driver !!},
    contract_type_rank: {!! $contract_type_rank !!}
});
</script>