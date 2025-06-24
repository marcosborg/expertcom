<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDamageCheckin extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'vehicle_damage_checkins';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'vehicle_manage_checkin_id',
        'driver_warning',
        'company_warning',
        'admin_warning',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function vehicle_manage_checkin()
    {
        return $this->belongsTo(VehicleManageCheckin::class, 'vehicle_manage_checkin_id');
    }
}
