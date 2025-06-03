<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleManageDelivery extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'vehicle_manage_deliveries';

    protected $dates = [
        'data_e_horario',
        'copia_de_licenca_de_tvde_data',
        'carta_verde_de_seguro_validade_data',
        'dua_do_veiculo_data',
        'inspecao_do_veiculo_validade_data',
        'contratro_de_prestacao_de_servicos_data',
        'distico_tvde_colocado_data',
        'declaracao_amigavel_data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'vehicle_item_id',
        'user_id',
        'driver_id',
        'data_e_horario',
        'de_bateria_de_saida',
        'km_atual',
        'aspiracao_bancos_frente',
        'aspiracao_bancos_tras',
        'aspiracao_tapetes_e_chao_frente',
        'aspiracao_tapetes_e_chao_tras',
        'limpeza_e_brilho_de_plasticos_carro',
        'ambientador_de_carro',
        'limpeza_vidros_interiores',
        'retirar_os_objetos_pessoais_existentes_no_carro',
        'verificacao_de_luzes_no_painel',
        'verificacao_de_necessidade_de_lavagem_estofos',
        'check_list_aspiracao_obs',
        'copia_de_licenca_de_tvde',
        'copia_de_licenca_de_tvde_data',
        'copia_de_licenca_de_tvde_comentarios',
        'carta_verde_de_seguro_validade',
        'carta_verde_de_seguro_validade_data',
        'carta_verde_de_seguro_validade_comentarios',
        'dua_do_veiculo',
        'dua_do_veiculo_data',
        'dua_do_veiculo_comentarios',
        'inspecao_do_veiculo_validade',
        'inspecao_do_veiculo_validade_data',
        'inspecao_do_veiculo_validade_comentarios',
        'contratro_de_prestacao_de_servicos',
        'contratro_de_prestacao_de_servicos_data',
        'contratro_de_prestacao_de_servicos_comentarios',
        'distico_tvde_colocado',
        'distico_tvde_colocado_data',
        'distico_tvde_colocado_comentarios',
        'declaracao_amigavel',
        'declaracao_amigavel_data',
        'declaracao_amigavel_comentarios',
        'aplicacao_de_agua_por_todo_o_carro',
        'passagem_de_agua_em_todo_o_carro',
        'aplicacao_de_champo_em_todo_o_carro',
        'esfregar_todo_o_carro_com_a_escova',
        'retirar_com_agua',
        'verificar_sujidades_ainda_existentes',
        'limpeza_de_jantes',
        'possui_extintor',
        'banco_elevatorio_crianca',
        'colete',
        'tratado',
        'comentarios',
        'reparado',
        'possui_triangulo',
        'cinzeiro_minutos',
        'telemovel_sim',
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

    public function vehicle_item()
    {
        return $this->belongsTo(VehicleItem::class, 'vehicle_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function getCopiaDeLicencaDeTvdeDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setCopiaDeLicencaDeTvdeDataAttribute($value)
    {
        $this->attributes['copia_de_licenca_de_tvde_data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getCartaVerdeDeSeguroValidadeDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setCartaVerdeDeSeguroValidadeDataAttribute($value)
    {
        $this->attributes['carta_verde_de_seguro_validade_data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDuaDoVeiculoDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDuaDoVeiculoDataAttribute($value)
    {
        $this->attributes['dua_do_veiculo_data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getInspecaoDoVeiculoValidadeDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setInspecaoDoVeiculoValidadeDataAttribute($value)
    {
        $this->attributes['inspecao_do_veiculo_validade_data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getContratroDePrestacaoDeServicosDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setContratroDePrestacaoDeServicosDataAttribute($value)
    {
        $this->attributes['contratro_de_prestacao_de_servicos_data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDisticoTvdeColocadoDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDisticoTvdeColocadoDataAttribute($value)
    {
        $this->attributes['distico_tvde_colocado_data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDeclaracaoAmigavelDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDeclaracaoAmigavelDataAttribute($value)
    {
        $this->attributes['declaracao_amigavel_data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
