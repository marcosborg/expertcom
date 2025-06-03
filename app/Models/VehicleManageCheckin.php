<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class VehicleManageCheckin extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'vehicle_manage_checkins';

    protected $dates = [
        'data_e_horario',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'frente_do_veiculo_teto_photos',
        'frente_do_veiculo_parabrisa_photos',
        'frente_do_veiculo_capo_photos',
        'frente_do_veiculo_parachoque_photos',
        'lateral_esquerda_paralama_diant_photos',
        'lateral_esquerda_retrovisor_photos',
        'lateral_esquerda_porta_diant_photos',
        'lateral_esquerda_porta_tras_photos',
        'lateral_esquerda_lateral_photos',
        'traseira_tampa_traseira_photos',
        'traseira_lanternas_dir_photos',
        'traseira_lanterna_esq_photos',
        'traseira_parachoque_tras_photos',
        'traseira_estepe_photos',
        'traseira_macaco_photos',
        'traseira_chave_de_roda_photos',
        'traseira_triangulo_photos',
        'lateral_direita_lateral_photos',
        'lateral_direita_porta_tras_photos',
        'lateral_direita_porta_diant_photos',
        'lateral_direita_retrovisor_photos',
        'lateral_direita_paralama_diant_photos',
        'cinzeiro_photos',
        'telemovel_photos',
    ];

    protected $fillable = [
        'user_id',
        'vehicle_item_id',
        'driver_id',
        'data_e_horario',
        'bateria_a_chegada',
        'km_atual',
        'frente_do_veiculo_teto',
        'frente_do_veiculo_parabrisa',
        'frente_do_veiculo_capo',
        'frente_do_veiculo_parachoque',
        'frente_do_veiculo_nada_consta',
        'frente_do_veiculo_obs',
        'lateral_esquerda_paralama_diant',
        'lateral_esquerda_retrovisor',
        'lateral_esquerda_porta_diant',
        'lateral_esquerda_porta_tras',
        'lateral_esquerda_lateral',
        'lateral_esquerda_nada_consta',
        'lateral_esquerda_obs',
        'traseira_mala',
        'traseira_farol_dir',
        'traseira_farol_esq',
        'traseira_parachoque_tras',
        'traseira_pneu_reserva',
        'traseira_macaco',
        'traseira_chave_de_roda',
        'traseira_triangulo',
        'traseira_nada_consta',
        'traseira_obs',
        'lateral_direita_lateral',
        'lateral_direita_porta_tras',
        'lateral_direita_porta_diant',
        'lateral_direita_retrovisor',
        'lateral_direita_paralama_diant',
        'lateral_direita_nada_consta',
        'lateral_direita_obs',
        'cinzeiro_sim',
        'cinzeiro_nada_consta',
        'telemovel_sim',
        'telemovel_nada_consta',
        'tratado',
        'reparado',
        'comentarios',
        'signature_collector_data',
        'signature_driver_data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle_item()
    {
        return $this->belongsTo(VehicleItem::class, 'vehicle_item_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function getDataEHorarioAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDataEHorarioAttribute($value)
    {
        $this->attributes['data_e_horario'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getFrenteDoVeiculoTetoPhotosAttribute()
    {
        return $this->getMedia('frente_do_veiculo_teto_photos');
    }

    public function getFrenteDoVeiculoParabrisaPhotosAttribute()
    {
        return $this->getMedia('frente_do_veiculo_parabrisa_photos');
    }

    public function getFrenteDoVeiculoCapoPhotosAttribute()
    {
        return $this->getMedia('frente_do_veiculo_capo_photos');
    }

    public function getFrenteDoVeiculoParachoquePhotosAttribute()
    {
        return $this->getMedia('frente_do_veiculo_parachoque_photos');
    }

    public function getLateralEsquerdaParalamaDiantPhotosAttribute()
    {
        return $this->getMedia('lateral_esquerda_paralama_diant_photos');
    }

    public function getLateralEsquerdaRetrovisorPhotosAttribute()
    {
        return $this->getMedia('lateral_esquerda_retrovisor_photos');
    }

    public function getLateralEsquerdaPortaDiantPhotosAttribute()
    {
        return $this->getMedia('lateral_esquerda_porta_diant_photos');
    }

    public function getLateralEsquerdaPortaTrasPhotosAttribute()
    {
        return $this->getMedia('lateral_esquerda_porta_tras_photos');
    }

    public function getLateralEsquerdaLateralPhotosAttribute()
    {
        return $this->getMedia('lateral_esquerda_lateral_photos');
    }

    public function getTraseiraTampaTraseiraPhotosAttribute()
    {
        return $this->getMedia('traseira_tampa_traseira_photos');
    }

    public function getTraseiraLanternasDirPhotosAttribute()
    {
        return $this->getMedia('traseira_lanternas_dir_photos');
    }

    public function getTraseiraLanternaEsqPhotosAttribute()
    {
        return $this->getMedia('traseira_lanterna_esq_photos');
    }

    public function getTraseiraParachoqueTrasPhotosAttribute()
    {
        return $this->getMedia('traseira_parachoque_tras_photos');
    }

    public function getTraseiraEstepePhotosAttribute()
    {
        return $this->getMedia('traseira_estepe_photos');
    }

    public function getTraseiraMacacoPhotosAttribute()
    {
        return $this->getMedia('traseira_macaco_photos');
    }

    public function getTraseiraChaveDeRodaPhotosAttribute()
    {
        return $this->getMedia('traseira_chave_de_roda_photos');
    }

    public function getTraseiraTrianguloPhotosAttribute()
    {
        return $this->getMedia('traseira_triangulo_photos');
    }

    public function getLateralDireitaLateralPhotosAttribute()
    {
        return $this->getMedia('lateral_direita_lateral_photos');
    }

    public function getLateralDireitaPortaTrasPhotosAttribute()
    {
        return $this->getMedia('lateral_direita_porta_tras_photos');
    }

    public function getLateralDireitaPortaDiantPhotosAttribute()
    {
        return $this->getMedia('lateral_direita_porta_diant_photos');
    }

    public function getLateralDireitaRetrovisorPhotosAttribute()
    {
        return $this->getMedia('lateral_direita_retrovisor_photos');
    }

    public function getLateralDireitaParalamaDiantPhotosAttribute()
    {
        return $this->getMedia('lateral_direita_paralama_diant_photos');
    }

    public function getCinzeiroPhotosAttribute()
    {
        return $this->getMedia('cinzeiro_photos');
    }

    public function getTelemovelPhotosAttribute()
    {
        return $this->getMedia('telemovel_photos');
    }
}
