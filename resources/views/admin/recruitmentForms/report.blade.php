@php
    use App\Models\RecruitmentForm;

    $statusLabels = RecruitmentForm::STATUS_RADIO;
    $typeLabels = RecruitmentForm::TYPE_RADIO;
    $chanelLabels = RecruitmentForm::CHANEL_RADIO;
@endphp
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatorio Recruitment Forms</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; margin: 18px; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        h2 { font-size: 14px; margin: 10px 0 6px; }
        .meta { font-size: 11px; color: #555; margin-bottom: 10px; }
        .summary-grid { display: table; width: 100%; table-layout: fixed; margin-top: 6px; }
        .card { display: table-cell; padding: 8px 10px; border: 1px solid #ddd; border-radius: 6px; margin-right: 6px; }
        .card strong { display: block; font-size: 12px; color: #111; }
        .card span { font-size: 18px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 6px; table-layout: fixed; font-size: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 4px 6px; text-align: left; vertical-align: top; word-break: break-word; hyphens: auto; }
        .table th { background: #f5f5f5; font-weight: bold; }
        .section { margin-top: 14px; }
        .kpi-table { width: 260px; border-collapse: collapse; margin: 10px 0; font-size: 11px; }
        .kpi-table th, .kpi-table td { border: 1px solid #ddd; padding: 4px 6px; }
        .chart { margin: 10px 0 6px; }
        .bar-row { display: flex; align-items: center; margin: 3px 0; }
        .bar-label { width: 140px; font-size: 10px; }
        .bar-track { flex: 1; background: #f3f3f3; border: 1px solid #e0e0e0; height: 12px; margin-right: 6px; }
        .bar-fill { height: 100%; background: #4a8fe7; }
        .bar-value { min-width: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <h1>Relatorio de Recruitment Forms</h1>
    <div class="meta">
        Gerado em: {{ $period['generated_at'] ?? 'N/A' }}<br>
        Periodo analisado: {{ $period['first'] ?? 'N/A' }} - {{ $period['last'] ?? 'N/A' }}
    </div>

    @php
        $statusTotals = [
            'Fechado'     => $grouped['status']['Fechado'] ?? 0,
            'Sem sucesso' => $grouped['status']['Sem sucesso'] ?? 0,
            'Tratamento'  => $grouped['status']['Tratamento'] ?? 0,
            'Em aberto'   => $grouped['status']['Em aberto'] ?? 0,
        ];
        $maxStatus = max($statusTotals ?: [0]);
        $maxChanel = ($grouped['chanel']->max() ?? 0) ?: 0;
        $maxResponsible = ($responsibles->max() ?? 0) ?: 0;
        $maxSuccessRate = ($responsibleSuccess->pluck('rate')->max() ?? 0);
        $maxChanelLeadToClosed = ($chanelConversion->pluck('rate_lead_to_closed')->max() ?? 0);
        $maxRespLeadToClosed = ($responsibleConversion->pluck('rate_lead_to_closed')->max() ?? 0);
    @endphp

    <div class="section">
        <h2>Resumo KPI</h2>
        <table class="kpi-table">
            <thead>
                <tr><th>KPI</th><th>Valor</th></tr>
            </thead>
            <tbody>
                <tr><td>Total Leads</td><td>{{ $summary['total'] }}</td></tr>
                <tr><td>Total Fechado</td><td>{{ $statusTotals['Fechado'] }}</td></tr>
                <tr><td>Total Sem Sucesso</td><td>{{ $statusTotals['Sem sucesso'] }}</td></tr>
                <tr><td>Total Tratamento</td><td>{{ $statusTotals['Tratamento'] }}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Funil de Recrutamento</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Etapa</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Leads Totais</td><td>{{ $funnel['leads_total'] }}</td></tr>
                <tr><td>Entrevistas Agendadas</td><td>{{ $funnel['interviews'] }}</td></tr>
                <tr><td>Fechados</td><td>{{ $funnel['closed'] }}</td></tr>
            </tbody>
        </table>
        @php
            $maxFunnel = max($funnel['leads_total'], $funnel['interviews'], $funnel['closed'], 1);
            $funnelItems = [
                ['label' => 'Leads Totais', 'value' => $funnel['leads_total']],
                ['label' => 'Entrevistas Agendadas', 'value' => $funnel['interviews']],
                ['label' => 'Fechados', 'value' => $funnel['closed']],
            ];
        @endphp
        <div class="chart">
            @foreach($funnelItems as $item)
                @php $width = $maxFunnel > 0 ? round($item['value'] / $maxFunnel * 100, 1) : 0; @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $item['label'] }}</div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $width }}%;"></div></div>
                    <div class="bar-value">{{ $item['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h2>Distribuicao por Status</h2>
        <div class="chart">
            @foreach($grouped['status'] as $status => $total)
                @php $width = $maxStatus > 0 ? round($total / $maxStatus * 100, 1) : 0; @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $statusLabels[$status] ?? $status ?? 'Indefinido' }}</div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $width }}%;"></div></div>
                    <div class="bar-value">{{ $total }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h2>Leads por Origem</h2>
        <div class="chart">
            @foreach($grouped['chanel'] as $chanel => $total)
                @php $width = $maxChanel > 0 ? round($total / $maxChanel * 100, 1) : 0; @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $chanelLabels[$chanel] ?? $chanel ?? 'Indefinido' }}</div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $width }}%;"></div></div>
                    <div class="bar-value">{{ $total }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h2>Leads por Responsavel</h2>
        <div class="chart">
            @foreach($responsibles as $responsible => $total)
                @php $width = $maxResponsible > 0 ? round($total / $maxResponsible * 100, 1) : 0; @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $responsible ?: 'Nao definido' }}</div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $width }}%;"></div></div>
                    <div class="bar-value">{{ $total }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h2>Taxa de Sucesso por Responsavel</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Responsavel</th>
                    <th>Total Leads</th>
                    <th>Fechadas</th>
                    <th>Taxa Sucesso %</th>
                </tr>
            </thead>
            <tbody>
                @forelse($responsibleSuccess as $responsible => $metrics)
                    <tr>
                        <td>{{ $responsible ?: 'Nao definido' }}</td>
                        <td>{{ $metrics['total'] }}</td>
                        <td>{{ $metrics['closed'] }}</td>
                        <td>{{ number_format($metrics['rate'], 1, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Sem registos</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="chart">
            @foreach($responsibleSuccess as $responsible => $metrics)
                @php
                    $width = $maxSuccessRate > 0 ? round($metrics['rate'] / $maxSuccessRate * 100, 1) : 0;
                @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $responsible ?: 'Nao definido' }}</div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $width }}%;"></div></div>
                    <div class="bar-value">{{ number_format($metrics['rate'], 1, ',', '.') }}%</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h2>Conversao por Origem</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Origem</th>
                    <th>Leads Totais</th>
                    <th>Entrevistas</th>
                    <th>Fechados</th>
                    <th>Tx Lead→Entrevista %</th>
                    <th>Tx Entrevista→Fechado %</th>
                    <th>Tx Lead→Fechado %</th>
                </tr>
            </thead>
            <tbody>
                @forelse($chanelConversion as $chanel => $metrics)
                    <tr>
                        <td>{{ $chanelLabels[$chanel] ?? $chanel ?? 'Indefinido' }}</td>
                        <td>{{ $metrics['total'] }}</td>
                        <td>{{ $metrics['interviews'] }}</td>
                        <td>{{ $metrics['closed'] }}</td>
                        <td>{{ number_format($metrics['rate_lead_to_interview'], 1, ',', '.') }}</td>
                        <td>{{ number_format($metrics['rate_interview_to_closed'], 1, ',', '.') }}</td>
                        <td>{{ number_format($metrics['rate_lead_to_closed'], 1, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">Sem registos</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="chart">
            @foreach($chanelConversion as $chanel => $metrics)
                @php
                    $width = $maxChanelLeadToClosed > 0 ? round($metrics['rate_lead_to_closed'] / $maxChanelLeadToClosed * 100, 1) : 0;
                @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $chanelLabels[$chanel] ?? $chanel ?? 'Indefinido' }}</div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $width }}%;"></div></div>
                    <div class="bar-value">{{ number_format($metrics['rate_lead_to_closed'], 1, ',', '.') }}%</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h2>Conversao por Responsavel</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Responsavel</th>
                    <th>Leads Totais</th>
                    <th>Entrevistas</th>
                    <th>Fechados</th>
                    <th>Tx Lead→Entrevista %</th>
                    <th>Tx Entrevista→Fechado %</th>
                    <th>Tx Lead→Fechado %</th>
                </tr>
            </thead>
            <tbody>
                @forelse($responsibleConversion as $responsible => $metrics)
                    <tr>
                        <td>{{ $responsible ?: 'Nao definido' }}</td>
                        <td>{{ $metrics['total'] }}</td>
                        <td>{{ $metrics['interviews'] }}</td>
                        <td>{{ $metrics['closed'] }}</td>
                        <td>{{ number_format($metrics['rate_lead_to_interview'], 1, ',', '.') }}</td>
                        <td>{{ number_format($metrics['rate_interview_to_closed'], 1, ',', '.') }}</td>
                        <td>{{ number_format($metrics['rate_lead_to_closed'], 1, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">Sem registos</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="chart">
            @foreach($responsibleConversion as $responsible => $metrics)
                @php
                    $width = $maxRespLeadToClosed > 0 ? round($metrics['rate_lead_to_closed'] / $maxRespLeadToClosed * 100, 1) : 0;
                @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $responsible ?: 'Nao definido' }}</div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $width }}%;"></div></div>
                    <div class="bar-value">{{ number_format($metrics['rate_lead_to_closed'], 1, ',', '.') }}%</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="summary-grid">
        <div class="card">
            <strong>Total de registos</strong>
            <span>{{ $summary['total'] }}</span>
        </div>
        <div class="card">
            <strong>Contacto bem sucedido</strong>
            <span>{{ $summary['contact_successfully'] }}</span>
        </div>
        <div class="card">
            <strong>Entrevistas agendadas</strong>
            <span>{{ $summary['scheduled_interview'] }}</span>
        </div>
        <div class="card">
            <strong>Processos fechados</strong>
            <span>{{ $summary['done'] }}</span>
        </div>
    </div>

    <div class="section">
        <h2>Processos fechados</h2>
        @if($closedForms->isEmpty())
            <p>Sem registos fechados no período.</p>
        @else
            <table class="table">
                <colgroup>
                    <col style="width:10%">
                    <col style="width:16%">
                    <col style="width:20%">
                    <col style="width:18%">
                    <col style="width:10%">
                    <col style="width:10%">
                    <col style="width:8%">
                    <col style="width:8%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Empresa</th>
                        <th>Status</th>
                        <th>Tipo</th>
                        <th>Canal</th>
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($closedForms as $form)
                        <tr>
                            <td>{{ optional($form->created_at)->format(config('panel.date_format')) }}</td>
                            <td>{{ $form->name }}</td>
                            <td>{{ $form->email }}</td>
                            <td>{{ $form->company->name ?? '' }}</td>
                            <td>{{ $statusLabels[$form->status] ?? $form->status ?? 'Indefinido' }}</td>
                            <td>{{ $typeLabels[$form->type] ?? $form->type ?? 'Indefinido' }}</td>
                            <td>{{ $chanelLabels[$form->chanel] ?? $form->chanel ?? 'Indefinido' }}</td>
                            <td>{{ $form->phone }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2>Distribuicao por status</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grouped['status'] as $status => $total)
                    <tr>
                        <td>{{ $statusLabels[$status] ?? $status ?? 'Indefinido' }}</td>
                        <td>{{ $total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Sem registos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Distribuicao por tipo</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grouped['type'] as $type => $total)
                    <tr>
                        <td>{{ $typeLabels[$type] ?? $type ?? 'Indefinido' }}</td>
                        <td>{{ $total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Sem registos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Distribuicao por canal</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Canal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grouped['chanel'] as $chanel => $total)
                    <tr>
                        <td>{{ $chanelLabels[$chanel] ?? $chanel ?? 'Indefinido' }}</td>
                        <td>{{ $total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Sem registos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @foreach($groupedForms as $statusKey => $forms)
        <div class="section">
            <h2>Registos - Status: {{ $statusLabels[$statusKey] ?? ($statusKey ?? 'Indefinido') }} ({{ $forms->count() }})</h2>
            <table class="table">
                <colgroup>
                    <col style="width:8%">
                    <col style="width:13%">
                    <col style="width:17%">
                    <col style="width:18%">
                    <col style="width:12%">
                    <col style="width:10%">
                    <col style="width:8%">
                    <col style="width:8%">
                    <col style="width:6%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Empresa</th>
                        <th>Status</th>
                        <th>Tipo</th>
                        <th>Canal</th>
                        <th>Contacto</th>
                        <th>Responsavel</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($forms as $form)
                        <tr>
                            <td>{{ optional($form->created_at)->format(config('panel.date_format')) }}</td>
                            <td>{{ $form->name }}</td>
                            <td>{{ $form->email }}</td>
                            <td>{{ $form->company->name ?? '' }}</td>
                            <td>{{ $statusLabels[$form->status] ?? $form->status ?? 'Indefinido' }}</td>
                            <td>{{ $typeLabels[$form->type] ?? $form->type ?? 'Indefinido' }}</td>
                            <td>{{ $chanelLabels[$form->chanel] ?? $form->chanel ?? 'Indefinido' }}</td>
                            <td>{{ $form->phone }}</td>
                            <td>{{ $form->responsible_for_the_lead }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">Sem registos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach
</body>
</html>
