<?php

// app/Services/DriverClassResolver.php
namespace App\Services;

use App\Models\Driver;
use App\Models\DriverClass;
use Carbon\Carbon;

class DriverClassResolver
{
    public function forDriver(Driver $driver): ?int
    {
        $startRaw = $driver->getRawOriginal('start_date');
        if (!$startRaw) return null;

        $start = Carbon::parse($startRaw);
        $asOf  = $driver->getRawOriginal('end_date')
            ? Carbon::parse($driver->getRawOriginal('end_date'))
            : now();

        $years = $start->diffInDays($asOf) / 365.2425;

        $class = DriverClass::where('from', '<=', $years)
            ->where(function ($q) use ($years) {
                $q->whereNull('to')->orWhere('to', '>', $years); // [from, to)
            })
            ->orderByDesc('from')
            ->first();

        return $class?->id;
    }

    /** Info do próximo escalão: nome, data de passagem e tempo restante em formato humano */
    public function nextClassInfo(Driver $driver): ?array
    {
        $startRaw = $driver->getRawOriginal('start_date');
        if (!$startRaw) return null;

        $start = Carbon::parse($startRaw);
        $asOf  = $driver->getRawOriginal('end_date')
            ? Carbon::parse($driver->getRawOriginal('end_date'))
            : now();

        $elapsedMonths = $start->diffInMonths($asOf);

        // Encontrar o escalão seguinte: primeiro cujo FROM (em meses) seja > meses decorridos
        $next = DriverClass::orderBy('from')->get()->first(function ($c) use ($elapsedMonths) {
            return (int) round($c->from * 12) > $elapsedMonths;
        });

        if (!$next) return null; // já está no topo

        // Data em que atinge o FROM do próximo escalão (regra [from,to))
        $thresholdMonths = (int) ceil($next->from * 12);
        $promotionDate   = $start->copy()->addMonths($thresholdMonths);

        // Restante em meses + dias (para string “humana” PT)
        if ($asOf->greaterThanOrEqualTo($promotionDate)) {
            $monthsRemaining = 0;
            $daysRemaining   = 0;
        } else {
            $monthsRemaining = $asOf->diffInMonths($promotionDate);
            $tmp             = $asOf->copy()->addMonths($monthsRemaining);
            $daysRemaining   = $tmp->diffInDays($promotionDate);
        }

        $human = [];
        if ($monthsRemaining > 0) $human[] = $monthsRemaining . ' ' . ($monthsRemaining == 1 ? 'mês' : 'meses');
        if ($daysRemaining > 0)   $human[] = $daysRemaining . ' ' . ($daysRemaining == 1 ? 'dia' : 'dias');
        if (!$human)              $human[] = '0 dias';

        return [
            'next_class_id'   => $next->id,
            'next_class_name' => $next->name,
            'promotion_date'  => $promotionDate->toDateString(),
            'remaining_months' => $monthsRemaining,
            'remaining_days'  => $daysRemaining,
            'remaining_human' => implode(' e ', $human),
        ];
    }
}
