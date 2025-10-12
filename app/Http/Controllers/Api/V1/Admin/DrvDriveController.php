<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\DrvSegment;
use App\Models\DrvSession;
use App\Models\DrvTimesheet;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DrvDriveController extends Controller
{
    private string $tz = 'Europe/Lisbon';

    /**
     * Resolve o driver_id a partir do utilizador autenticado.
     * Ajusta se usares outra relação (ex.: $user->driver->id).
     */
    private function driverId(): int
    {
        $user = auth()->user();
        return $user->driver_id ?? $user->id;
    }

    /**
     * Inicia sessão e primeiro segmento drive.
     * Body opcional: { lat: float, lng: float, source: 'app'|'api' }
     */
    public function start(Request $request)
    {
        $data = $request->validate([
            'lat'    => ['nullable', 'numeric'],
            'lng'    => ['nullable', 'numeric'],
            'source' => ['nullable', Rule::in(array_keys(DrvSession::SOURCE_RADIO))],
        ]);

        $driverId = $this->driverId();
        $now = Carbon::now('UTC');

        // Bloquear outra sessão aberta
        $open = DrvSession::ofDriver($driverId)->open()->first();
        if ($open) {
            return response()->json([
                'message' => 'Já existe uma sessão em curso para este motorista.',
                'session' => $open->id,
                'status'  => $open->status,
            ], 409);
        }

        return DB::transaction(function () use ($driverId, $data, $now) {
            $session = DrvSession::create([
                'driver_id'            => $driverId,
                'started_at'           => $now,
                'status'               => DrvSession::STATUS_RADIO['running'],
                'total_drive_seconds'  => 0,
                'total_pause_seconds'  => 0,
                'started_lat'          => $data['lat'] ?? null,
                'started_lng'          => $data['lng'] ?? null,
                'source'               => $data['source'] ?? DrvSession::SOURCE_RADIO['app'],
            ]);

            $segment = $session->startDriveSegment($now);

            return response()->json([
                'session' => $session->fresh(['segments' => fn($q) => $q->latest('started_at')]),
                'current_segment' => $segment,
            ], 201);
        });
    }

    /**
     * Pausa a sessão corrente (fecha segmento drive e abre pause).
     */
    public function pause(Request $request)
    {
        $driverId = $this->driverId();
        $now = Carbon::now('UTC');

        $session = DrvSession::ofDriver($driverId)->running()->latest('started_at')->first();
        if (!$session) {
            return response()->json(['message' => 'Nenhuma sessão em estado running.'], 409);
        }

        return DB::transaction(function () use ($session, $now) {
            // fecha o drive aberto e acumula
            [$seconds, $kind] = $session->closeOpenSegmentAndAccumulate($now);

            // actualizar timesheet(s) PT
            if ($kind) {
                $this->upsertTimesheetsForSegment($session->driver_id, $kind, $session->openSegment()?->started_at ?? $now->copy()->subSeconds($seconds), $now);
            }

            // abre pause e marca estado
            $session->startPauseSegment($now);
            $session->status = DrvSession::STATUS_RADIO['paused'];
            $session->save();

            return response()->json(['session' => $session->fresh('segments')], 200);
        });
    }

    /**
     * Retoma (fecha pause e abre drive).
     */
    public function resume(Request $request)
    {
        $driverId = $this->driverId();
        $now = Carbon::now('UTC');

        $session = DrvSession::ofDriver($driverId)->paused()->latest('started_at')->first();
        if (!$session) {
            return response()->json(['message' => 'Nenhuma sessão em estado paused.'], 409);
        }

        return DB::transaction(function () use ($session, $now) {
            // fecha o pause e acumula
            [$seconds, $kind] = $session->closeOpenSegmentAndAccumulate($now);

            if ($kind) {
                $this->upsertTimesheetsForSegment($session->driver_id, $kind, $session->openSegment()?->started_at ?? $now->copy()->subSeconds($seconds), $now);
            }

            // abre drive e marca estado
            $session->startDriveSegment($now);
            $session->status = DrvSession::STATUS_RADIO['running'];
            $session->save();

            return response()->json(['session' => $session->fresh('segments')], 200);
        });
    }

    /**
     * Termina a sessão (fecha segmento aberto e encerra).
     * Body opcional: { lat: float, lng: float }
     */
    public function finish(Request $request)
    {
        $data = $request->validate([
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
        ]);

        $driverId = $this->driverId();
        $now = Carbon::now('UTC');

        $session = DrvSession::ofDriver($driverId)->open()->latest('started_at')->first();
        if (!$session) {
            return response()->json(['message' => 'Nenhuma sessão aberta.'], 409);
        }

        return DB::transaction(function () use ($session, $now, $data) {
            $openSeg = $session->openSegment();
            if ($openSeg) {
                $started = $openSeg->started_at->copy();
                [$seconds, $kind] = $session->closeOpenSegmentAndAccumulate($now);
                if ($kind) {
                    $this->upsertTimesheetsForSegment($session->driver_id, $kind, $started, $now);
                }
            }

            $session->ended_at = $now;
            $session->status   = DrvSession::STATUS_RADIO['finished'];
            $session->ended_lat = $data['lat'] ?? null;
            $session->ended_lng = $data['lng'] ?? null;
            $session->save();

            return response()->json(['session' => $session->fresh('segments')], 200);
        });
    }

    /**
     * Vista diária para autoridade: segmentos (drive/pause) recortados ao dia local.
     * Query: ?date=YYYY-MM-DD  (default: hoje em PT)
     */
    public function dailyLogs(Request $request)
    {
        $driverId = $this->driverId();

        $dateStr = $request->query('date');
        $localDay = $dateStr ? CarbonImmutable::parse($dateStr, $this->tz) : CarbonImmutable::now($this->tz);
        $startLocal = $localDay->startOfDay();
        $endLocal   = $localDay->endOfDay();

        // Converter janelas do dia PT para UTC para query
        $startUtc = $startLocal->setTimezone('UTC');
        $endUtc   = $endLocal->setTimezone('UTC');

        // Obter todos os segmentos que intersectam o dia pedido
        $segments = DrvSegment::whereHas('session', function ($q) use ($driverId) {
            $q->where('driver_id', $driverId);
        })
            ->where(function ($q) use ($startUtc, $endUtc) {
                // started < end && (ended is null || ended > start)
                $q->where('started_at', '<=', $endUtc)
                    ->where(function ($q2) use ($startUtc) {
                        $q2->whereNull('ended_at')->orWhere('ended_at', '>=', $startUtc);
                    });
            })
            ->with('session')
            ->orderBy('started_at')
            ->get();

        // Recortar cada segmento ao intervalo do dia PT e calcular duração parcial
        $items = [];
        $totalDrive = 0;
        $totalPause = 0;

        foreach ($segments as $seg) {
            $segStartUtc = CarbonImmutable::instance($seg->started_at ?? $startUtc)->setTimezone('UTC');
            $segEndUtc   = CarbonImmutable::instance($seg->ended_at ?? $endUtc)->setTimezone('UTC');

            // Intersecção com janela do dia em UTC
            $clipStart = $segStartUtc->max($startUtc);
            $clipEnd   = $segEndUtc->min($endUtc);

            if ($clipEnd->lessThanOrEqualTo($clipStart)) {
                continue;
            }

            $duration = $clipEnd->diffInSeconds($clipStart);

            // Apresentar horários em hora local PT
            $startLocalStr = $clipStart->setTimezone($this->tz)->format('Y-m-d H:i:s');
            $endLocalStr   = $clipEnd->setTimezone($this->tz)->format('Y-m-d H:i:s');

            $items[] = [
                'kind'            => $seg->kind,         // 'drive' | 'pause'
                'started_at'      => $startLocalStr,
                'ended_at'        => $endLocalStr,
                'duration_seconds' => $duration,
                'session_id'      => $seg->session_id,
            ];

            if ($seg->kind === DrvSegment::KIND_RADIO['drive']) {
                $totalDrive += $duration;
            } else {
                $totalPause += $duration;
            }
        }

        return response()->json([
            'date'                  => $startLocal->format('Y-m-d'),
            'timezone'              => $this->tz,
            'total_drive_seconds'   => $totalDrive,
            'total_pause_seconds'   => $totalPause,
            'segments'              => $items,
        ]);
    }

    /**
     * Atualiza os timesheets dividindo por dias locais PT se o segmento atravessar a meia-noite.
     */
    private function upsertTimesheetsForSegment(int $driverId, string $kind, Carbon $startUtc, Carbon $endUtc): void
    {
        // Itera dia a dia em Europe/Lisbon
        $startLocal = CarbonImmutable::instance($startUtc)->setTimezone($this->tz);
        $endLocal   = CarbonImmutable::instance($endUtc)->setTimezone($this->tz);

        // Se por alguma razão end < start, ignora
        if ($endLocal->lessThanOrEqualTo($startLocal)) {
            return;
        }

        // Percorrer dias (inclusive do start ao end)
        $cursor = $startLocal->startOfDay();
        $lastDay = $endLocal->startOfDay();

        while ($cursor->lessThanOrEqualTo($lastDay)) {
            $dayStartLocal = $cursor->copy()->startOfDay();
            $dayEndLocal   = $cursor->copy()->endOfDay();

            // Intersecção do segmento (em local) com este dia
            $segStartLocal = $startLocal;
            $segEndLocal   = $endLocal;

            $clipStartLocal = $segStartLocal->max($dayStartLocal);
            $clipEndLocal   = $segEndLocal->min($dayEndLocal);

            if ($clipEndLocal->greaterThan($clipStartLocal)) {
                $seconds = $clipEndLocal->diffInSeconds($clipStartLocal);

                // Upsert no timesheet deste dia
                $timesheet = DrvTimesheet::firstOrCreate(
                    ['driver_id' => $driverId, 'date' => $dayStartLocal->toDateString()],
                    [
                        'total_drive_seconds' => 0,
                        'total_pause_seconds' => 0,
                        'status' => DrvTimesheet::STATUS_RADIO['open'],
                    ]
                );

                if ($kind === DrvSegment::KIND_RADIO['drive']) {
                    $timesheet->addDriveSeconds($seconds);
                } else {
                    $timesheet->addPauseSeconds($seconds);
                }
            }

            $cursor = $cursor->addDay();
        }
    }

    public function status()
    {
        $driverId = $this->driverId();
        $now = \Carbon\Carbon::now('UTC');

        $session = \App\Models\DrvSession::ofDriver($driverId)->open()->latest('started_at')->with('segments')->first();

        if (!$session) {
            return response()->json([
                'active'  => false,
                'status'  => 'idle',
                'session' => null,
            ]);
        }

        $openSeg = $session->openSegment(); // null se não houver
        $runningKind = $openSeg?->kind;     // 'drive' ou 'pause' ou null

        // Totais “até agora” (inclui o segmento aberto)
        $elapsed = 0;
        if ($openSeg) {
            $elapsed = max(0, $now->diffInSeconds($openSeg->started_at));
        }

        $driveTotal = (int)$session->total_drive_seconds + ($runningKind === 'drive' ? $elapsed : 0);
        $pauseTotal = (int)$session->total_pause_seconds + ($runningKind === 'pause' ? $elapsed : 0);

        return response()->json([
            'active'               => true,
            'status'               => $session->status,     // 'running' | 'paused'
            'running_segment_kind' => $runningKind,         // 'drive' | 'pause' | null
            'session'              => $session,
            'totals_now' => [
                'total_drive_seconds' => $driveTotal,
                'total_pause_seconds' => $pauseTotal,
            ],
        ]);
    }
}
