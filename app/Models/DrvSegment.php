<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrvSegment extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'drv_segments';

    public const KIND_RADIO = [
        'drive' => 'drive',
        'pause' => 'pause',
    ];

    protected $fillable = [
        'session_id',
        'kind',
        'started_at',
        'ended_at',
        'duration_seconds',
        'notes',
    ];

    protected $casts = [
        'started_at'       => 'datetime', // UTC
        'ended_at'         => 'datetime', // UTC
        'duration_seconds' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // importante: tocar a sessão quando o segmento muda
    protected $touches = ['session'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function session()
    {
        return $this->belongsTo(DrvSession::class, 'session_id');
    }

    /**
     * Fecha o segmento e devolve duração (segundos).
     */
    public function closeAt(Carbon $endedAt): int
    {
        if ($this->ended_at) {
            return $this->duration_seconds ?? 0; // já fechado
        }

        $this->ended_at = $endedAt;
        $seconds = max(0, $endedAt->diffInSeconds($this->started_at));
        $this->duration_seconds = $seconds;
        $this->save();

        return $seconds;
    }

    /**
     * True se o segmento ainda estiver aberto.
     */
    public function getIsOpenAttribute(): bool
    {
        return is_null($this->ended_at);
    }
}
