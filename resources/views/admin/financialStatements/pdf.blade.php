<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Extrato</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
        }

        @page {
            margin-top: 40px;
            margin-bottom: 0;
            margin-left: 40px;
            margin-right: 40px;
        }

        body {
            margin: 0;
        }

        footer {
            position: fixed;
            bottom: -0px;
            left: 0px;
            right: 0px;
            height: 50px;
            line-height: 35px;
        }

        table.bordered {
            border-collapse: collapse;
        }

        table.bordered th {
            border: solid 1px #ccc;
        }

        table.bordered td {
            border: solid 1px #ccc;
        }

        table.bordered thead th {
            background: #eeeeee;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td style="vertical-align: top; width: 50%;">
                    <h1>{{ $company->name }}</h1>
                    <p>{{ $company->vat }}<br>
                        {{ $company->address }}, {{ $company->zip }}<br>
                        {{ $company->location }}<br>
                        {{ $company->email }}
                    </p>
                </td>
                <td style="vertical-align: top; width: 50%;">
                    <h1>{{ $tvde_week->start_date }} a {{ $tvde_week->end_date }}</h1>
                    <p>
                        <strong>{{ $driver->name }}</strong><br>
                        {{ $driver->address != null ?? $driver->address . ',' . $driver->zip . '<br>'}}
                        {{ $driver->city != null ?? $driver->city . '<br>' }}
                        {{ $driver->phone != null ?? $driver->phone . '<br>' }}
                        {{ $driver->email }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td style="vertical-align: top; width: 50%;">
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th colspan="4" style="text-align: left; text-transform: uppercase;">Atividades por
                                    operador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="text-align: left;">UBER</th>
                                <td style="text-align: right;">{{ $total_earnings_uber }}€</td>
                                @if ($driver)
                                <td style="text-align: right;">{{ $contract_type_rank ? $contract_type_rank->percent :
                                    '' }}%</td>
                                <td style="text-align: right;">{{ $total_uber }}€</td>
                                @endif
                            </tr>
                            <tr>
                                <th style="text-align: left;">BOLT</th>
                                <td style="text-align: right;">{{ $total_earnings_bolt }}€</td>
                                @if ($driver)
                                <td style="text-align: right;">{{ $contract_type_rank ? $contract_type_rank->percent :
                                    '' }}%</td>
                                <td style="text-align: right;">{{ $total_bolt }}€</td>
                                @endif
                            </tr>
                            <tr>
                                <th style="text-align: left;">Gorjeta UBER</th>
                                <td style="text-align: right;">{{ $total_tips_uber }}€</td>
                                @if ($driver)
                                <td style="text-align: right;">{{ $uber_tip_percent }}%</td>
                                <td style="text-align: right;">{{ $uber_tip_after_vat }}€</td>
                                @endif
                            </tr>
                            <tr>
                                <th style="text-align: left;">Gorjeta BOLT</th>
                                <td style="text-align: right;">{{ $total_tips_bolt }}€</td>
                                @if ($driver)
                                <td style="text-align: right;">{{ $bolt_tip_percent }}%</td>
                                <td style="text-align: right;">{{ $bolt_tip_after_vat }}€</td>
                                @endif
                            </tr>
                            <tr style="text-align: left;">
                                <th style="text-align: left;">Totais</th>
                                <td style="text-align: right;">{{ $total_earnings }}€</td>
                                @if ($driver)
                                <td></td>
                                <td style="text-align: right;">{{ $total_after_vat }}€</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    @if (($electric_expenses && $electric_expenses['value'] > 0) || ($combustion_expenses &&
                    $combustion_expenses['value'] > 0))
                    <table class="bordered" style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th style="text-transform: uppercase; text-align: left" colspan="3">
                                    Abastecimento
                                    <small style="float: right">
                                    {{ $electric_expenses ? 'Rentabilidade: ' . number_format($electric_racio, 2) . '%' : '' }}
                                    {{ $combustion_expenses ? 'Rentabilidade: ' . number_format($combustion_racio, 2) . '%' : '' }}
                                    </small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th></th>
                                <th style="text-align: right;">Quantidade</th>
                                <th style="text-align: right;">Custo</th>
                            </tr>
                            @if ($electric_expenses)
                            <tr>
                                <th style="text-align: left;">Gastos</th>
                                <td style="text-align: right;">{{ $electric_expenses['amount'] }}</td>
                                <td style="text-align: right;">{{ $electric_expenses['total'] }}</td>
                            </tr>
                            @endif
                            @if ($combustion_expenses)
                            <tr>
                                <th style="text-align: left;">Gastos</th>
                                <td style="text-align: right;">{{ $combustion_expenses['amount'] }}</td>
                                <td style="text-align: right;">{{ $combustion_expenses['total'] }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    @endif
                </td>
                <td style="vertical-align: top; width: 50%;">
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th colspan="4" style="text-align: left; text-transform: uppercase;">Totais</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th></th>
                                <th style="text-align: right;">Créditos</th>
                                @if ($driver)
                                <th style="text-align: right;">Débitos</th>
                                <th style="text-align: right;">Totais</th>
                                @endif
                            </tr>
                            <tr>
                                <th style="text-align: left;">Ganhos</th>
                                <td style="text-align: right;">{{ $total_earnings_no_tip }}€</td>
                                @if ($driver)
                                <td style="text-align: right;">- {{ $total_earnings_no_tip - $total_earnings_after_vat
                                    }}€</td>
                                <td style="text-align: right;">{{ number_format($total_earnings_after_vat, 2) }}€</td>
                                @endif
                            </tr>
                            <tr>
                                <th style="text-align: left;">Gorjetas</th>
                                <td style="text-align: right;">{{ number_format($total_tips, 2) }}€</td>
                                @if ($driver)
                                <td style="text-align: right;">- {{ number_format($total_tips - $total_tip_after_vat, 2)
                                    }}€</td>
                                <td style="text-align: right;">{{ $total_tip_after_vat }}€</td>
                                @endif
                            </tr>
                            @if ($electric_expenses && $electric_expenses['value'] > 0)
                            <tr>
                                <th style="text-align: left;">Abastecimento elétrico</th>
                                <td></td>
                                @if ($driver)
                                <td style="text-align: right;">- {{ $electric_expenses['total'] }}</td>
                                <td></td>
                                @endif
                            </tr>
                            @endif
                            @if ($combustion_expenses && $combustion_expenses['value'] > 0)
                            <tr>
                                <th style="text-align: left;">Abastecimento combustivel</th>
                                <td></td>
                                @if ($driver)
                                <td style="text-align: right;">- {{ $combustion_expenses['total'] }}</td>
                                <td></td>
                                @endif
                            </tr>
                            @endif
                            @foreach ($adjustments as $adjustment)
                            <tr>
                                <th style="text-align: left;">{{ $adjustment->name }}</th>
                                <td style="text-align: right;">{{ $adjustment->type == 'refund' ? '' .
                                    $adjustment->amount . '€' : '' }}</td>
                                <td style="text-align: right;">{{ $adjustment->type == 'deduct' ? '- ' .
                                    $adjustment->amount . '€' : '' }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            @if ($txt_admin > 0)
                                <tr>
                                    <th style="text-align: left;">Taxa administrativa</th>
                                    <td></td>
                                    <td style="text-align: right;">- {{ number_format($txt_admin, 2) }}€</td>
                                    <td></td>
                                </tr>
                            @endif
                            <tr>
                                <th style="text-align: left;">Totais</th>
                                <th style="text-align: right;">{{ number_format($gross_credits, 2) }}€</th>
                                @if ($driver)
                                <th style="text-align: right;">- {{ number_format($gross_debts, 2) }}€</th>
                                <th style="text-align: right;">{{ number_format($final_total, 2) }}€</th>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    <table class="bordered" style="margin-top: 20px;">
                        <tbody>
                            <tr>
                                <td style="text-align: center; background: #eeeeee;">
                                    <h2>Valor a pagar: {{ number_format($final_total, 2) }}€</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 50%;">
                    <img src="https://quickchart.io/chart?c={%20type:%20%27bar%27,%20data:%20{%20labels:%20[%22Motorista%201%22,%20%22Motorista%202%22,%20%22Motorista%203%22,%20%22Motorista%204%22,%20%22Motorista%205%22,%20%22Motorista%206%22,%20%22Motorista%207%22,%20%22Motorista%208%22,%20%22Motorista%209%22,%20%22Motorista%2010%22,%20%22Motorista%2011%22,%20%22Motorista%2012%22,%20%22Motorista%2013%22,%20%22Motorista%2014%22,%20%22Motorista%2015%22,%20%22Motorista%2016%22,%20%22Motorista%2017%22,%20%22Motorista%2018%22,%20%22Motorista%2019%22,%20%22Motorista%2020%22,%20%22Motorista%2021%22,%20%22Motorista%2022%22,%20%22Motorista%2023%22,%20%22Motorista%2024%22,%20%22Mateus%20Costa%22,%20%22Motorista%2026%22,%20%22Motorista%2027%22,%20%22Motorista%2028%22,%20%22Motorista%2029%22,%20%22Motorista%2030%22,%20%22Motorista%2031%22,%20%22Motorista%2032%22,%20%22Motorista%2033%22],%20datasets:%20[{%20label:%20%27Valor%20faturado%27,%20data:%20[%22274.99%22,%20%220.00%22,%20%22125.81%22,%20%22768.15%22,%20%220.00%22,%20%22410.19%22,%20%22241.14%22,%20%220.00%22,%20%22470.37%22,%20%22438.54%22,%20%22282.11%22,%20%22532.64%22,%20%22359.56%22,%20%22605.53%22,%20%22533.00%22,%20%2230.96%22,%20%220.00%22,%20%22757.48%22,%20%220.00%22,%20%22196.64%22,%20%22420.86%22,%20%22508.13%22,%20%22257.03%22,%20%22428.50%22,%20%22501.81%22,%20%22165.76%22,%20%220.00%22,%20%2237.13%22,%20%22612.02%22,%20%22527.77%22,%20%22624.92%22,%20%22630.71%22,%20%220.00%22],%20}]%20},%20options:%20{%20responsive:%20true,%20maintainAspectRatio:%20false,%20scales:%20{%20y:%20{%20beginAtZero:%20true%20}%20},%20}%20}" style="max-width: 100%;">
                </td>
            </tr>
        </tbody>
    </table>
    <footer>
        ExpertCom ©
        <?php echo date("Y");?>
    </footer>
</body>

</html>