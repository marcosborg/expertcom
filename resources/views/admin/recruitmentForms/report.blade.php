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
    </style>
</head>
<body>
    <h1>Relatorio de Recruitment Forms</h1>
    <div class="meta">
        Gerado em: {{ $period['generated_at'] ?? 'N/A' }}<br>
        Periodo analisado: {{ $period['first'] ?? 'N/A' }} - {{ $period['last'] ?? 'N/A' }}
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
