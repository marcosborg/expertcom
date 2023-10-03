<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Extrato</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 11px;
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
                                    <h2>Valor a emitir recibo: {{ number_format($final_total, 2) }}€</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <canvas id="driver_earnings"></canvas>
                </td>
                <td style="width: 50%;">
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