<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrvTimesheet extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'drv_timesheets';

    public const STATUS_RADIO = [
        'open'   => 'open',
        'closed' => 'closed',
    ];

    protected $fillable = [
        'driver_id',
        'date',
        'total_drive_seconds',
        'total_pause_seconds',
        'status',
    ];

    protected $casts = [
        'driver_id'            => 'integer',
        'date'                 => 'date',     // dia civil (Europe/Lisbon)
        'total_drive_seconds'  => 'integer',
        'total_pause_seconds'  => 'integer',
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

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    // Scopes
    public function scopeOfDriver($q, int $driverId)
    {
        return $q->where('driver_id', $driverId);
    }

    public function scopeOnDate($q, string|\DateTimeInterface $date)
    {
        $d = $date instanceof \DateTimeInterface ? Carbon::instance($date) : Carbon::parse($date);
        return $q->whereDate('date', $d->toDateString());
    }

    // Helpers de acumulação
    public function addDriveSeconds(int $seconds): void
    {
        $this->increment('total_drive_seconds', max(0, $seconds));
    }

    public function addPauseSeconds(int $seconds): void
    {
        $this->increment('total_pause_seconds', max(0, $seconds));
    }
}
