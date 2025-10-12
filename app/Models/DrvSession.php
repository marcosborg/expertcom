<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrvSession extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'drv_sessions';

    public const SOURCE_RADIO = [
        'app' => 'app',
        'api' => 'api',
    ];

    public const STATUS_RADIO = [
        'running'  => 'running',
        'paused'   => 'paused',
        'finished' => 'finished',
    ];

    protected $fillable = [
        'driver_id',
        'started_at',
        'ended_at',
        'status',
        'total_drive_seconds',
        'total_pause_seconds',
        'started_lat',
        'started_lng',
        'ended_lat',
        'ended_lng',
        'source',
    ];

    protected $casts = [
        'driver_id'            => 'integer',
        'started_at'           => 'datetime', // UTC
        'ended_at'             => 'datetime', // UTC
        'total_drive_seconds'  => 'integer',
        'total_pause_seconds'  => 'integer',
        'started_lat'          => 'float',
        'started_lng'          => 'float',
        'ended_lat'            => 'float',
        'ended_lng'            => 'float',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Relações
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function segments()
    {
        // ordem por defeito por started_at
        return $this->hasMany(DrvSegment::class, 'session_id')->orderBy('started_at');
    }

    // Scopes úteis
    public function scopeOfDriver($q, int $driverId)
    {
        return $q->where('driver_id', $driverId);
    }

    public function scopeRunning($q)
    {
        return $q->where('status', self::STATUS_RADIO['running']);
    }

    public function scopePaused($q)
    {
        return $q->where('status', self::STATUS_RADIO['paused']);
    }

    public function scopeOpen($q)
    {
        return $q->whereIn('status', [self::STATUS_RADIO['running'], self::STATUS_RADIO['paused']]);
    }

    // Helpers de negócio
    public function openSegment(): ?DrvSegment
    {
        return $this->segments()->whereNull('ended_at')->latest('started_at')->first();
    }

    public function startDriveSegment(Carbon $now): DrvSegment
    {
        return $this->segments()->create([
            'kind'              => DrvSegment::KIND_RADIO['drive'],
            'started_at'        => $now,
            'duration_seconds'  => 0, // garante default
        ]);
    }

    public function startPauseSegment(Carbon $now): DrvSegment
    {
        return $this->segments()->create([
            'kind'              => DrvSegment::KIND_RADIO['pause'],
            'started_at'        => $now,
            'duration_seconds'  => 0, // garante default
        ]);
    }

    /**
     * Fecha o segmento aberto, actualiza totais e devolve [segundos, kind].
     */
    public function closeOpenSegmentAndAccumulate(Carbon $now): array
    {
        $seg = $this->openSegment();
        if (!$seg) {
            return [0, null];
        }
        $seconds = $seg->closeAt($now);

        if ($seg->kind === DrvSegment::KIND_RADIO['drive']) {
            $this->increment('total_drive_seconds', $seconds);
        } else {
            $this->increment('total_pause_seconds', $seconds);
        }

        return [$seconds, $seg->kind];
    }

    public function markFinished(Carbon $now): void
    {
        if (!$this->ended_at) {
            $this->ended_at = $now;
        }
        $this->status = self::STATUS_RADIO['finished'];
        $this->save();
    }

    public function getIsOpenAttribute(): bool
    {
        return in_array($this->status, [self::STATUS_RADIO['running'], self::STATUS_RADIO['paused']], true);
    }
}
