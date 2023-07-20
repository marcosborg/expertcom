@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="panel panel-default">
        <div class="panel-heading">
            Semanas
        </div>
        <div class="panel-body">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($years as $key => $year)
                    <li role="presentation" {{ $key===0 ? 'class="active"' : '' }}><a href="#year-{{ $year->id }}"
                            role="tab" data-toggle="tab">{{ $year->name }}</a></li>
                    @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach ($years as $key => $year)
                    <div role="tabpanel" class="tab-pane {{ $key === 0 ? 'active' : '' }}" id="year-{{ $year->id }}">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach ($year->months as $monthKey => $month)
                                <li role="presentation" {{ $monthKey===0 ? 'class="active"' : '' }}><a
                                        href="#month-{{ $month->id }}" role="tab" data-toggle="tab">{{ $month->name
                                        }}</a></li>
                                @endforeach
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                @foreach ($year->months as $monthKey => $month)
                                <div role="tabpanel" class="tab-pane {{ $monthKey === 0 ? 'active' : '' }}"
                                    id="month-{{ $month->id }}">
                                    <div>
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach ($month->weeks as $weekKey => $week)
                                            <li role="presentation" {{ $weekKey===0 ? 'class="active"' : '' }}><a
                                                    href="#week-{{ $week->id }}" role="tab" data-toggle="tab">{{
                                                    $week->start_date }} - {{ $week->end_date }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            @foreach ($month->weeks as $weekKey => $week)
                                            <div role="tabpanel" class="tab-pane active" id="week-{{ $week->id }}">
                                                <p> </p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                {{ $driver->name }}
                                                            </div>
                                                            <div class="panel-body">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>Uber</th>
                                                                            <td>{{
                                                                                $uber_tvde_activities->sum('earnings_one')
                                                                                }}€
                                                                            </td>
                                                                            <td>55%</td>
                                                                            <td>{{
                                                                                round(($uber_tvde_activities->sum('earnings_one') * (100 - 55))/100, 2)
                                                                                }}€</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Bolt</th>
                                                                            <td>
                                                                                {{
                                                                                $bolt_tvde_activities->sum('earnings_one')
                                                                                }}€
                                                                            </td>
                                                                            <td>55%</td>
                                                                            <td>{{
                                                                                round(($bolt_tvde_activities->sum('earnings_one') * (100 - 55))/100, 2)
                                                                                }}€</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Gorjeta Uber</th>
                                                                            <td>
                                                                                {{
                                                                                $bolt_tvde_activities->sum('earnings_two')
                                                                                }}€
                                                                            </td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Gorjeta Bolt</th>
                                                                            <td>
                                                                                {{
                                                                                $bolt_tvde_activities->sum('earnings_two')
                                                                                }}€
                                                                            </td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">

                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    console.log({!! $uber_tvde_activities !!})
</script>