<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicitudctlinv
 */
class TSolicitudctlinv extends Model
{

    protected $connection = "bd_controlinversion";

    protected $table = 't_solicitudctlinv';

    protected $primaryKey = 'sci_id';

	public $timestamps = false;

    protected $fillable = [
        'sci_tdc_id',
        'sci_soe_id',
        'sci_tsd_id',
        'sci_mts_id',
        'sci_can_id',
        'sci_fecha',
        'sci_solicitante',
        'sci_periododes_ini',
        'sci_periododes_fin',
        'sci_ventaesperada',
        'sci_descuentoestimado',
        'sci_usuario',
        'sci_tipo',
        'sci_tipono',
        'sci_tipononumero',
        'sci_toc_id',
        'sci_observaciones',
        'sci_tipopersona',
        'sci_cargara',
        'sci_planoprov',
        'sci_cargarlinea',
        'sci_planoprovfecha',
        'sci_totalref',
        'sci_planoobmu',
        'sci_planoobmufecha',
        'sci_cerradaautomatica',
        'sci_fechacierreautomatico',
        'sci_motivodescuento',
        'sci_duplicar',
        'sci_nduplicar',
        'sci_cduplicar',
        'sci_todocanal',
        'sci_nombre',
        'sci_ciudad',
        'sci_direccion',
        'sci_facturara',
        'sci_can_desc'
    ];

    protected $guarded = [];

    public function clientes(){
      return $this->hasMany('App\Models\controlinversion\TSolicliente', 'scl_sci_id', 'sci_id');
    }

    public function estado(){
      return $this->hasOne('App\Models\controlinversion\TSolestado', 'soe_id', 'sci_soe_id');
    }

    public function tipoSalida(){
      return $this->hasOne('App\Models\controlinversion\TTiposalida', 'tsd_id', 'sci_tsd_id');
    }

    public function tipoPersona(){
      return $this->hasOne('App\Models\controlinversion\TTipopersona', 'tpe_id', 'sci_tipopersona');
    }

    public function cargara(){
      return $this->hasOne('App\Models\controlinversion\TCargagasto', 'cga_id', 'sci_cargara');
    }

    public function facturara(){
      return $this->hasOne('App\Models\controlinversion\TFacturara', 'fca_idTercero', 'sci_facturara');
    }

    public function cargaralinea(){
      return $this->hasOne('App\Models\controlinversion\TLineascc', 'lcc_codigo', 'sci_cargarlinea');
    }

    public function tpernivel(){
      return $this->hasOne('App\Models\controlinversion\TPerniveles', 'pern_cedula', 'sci_usuario');
    }


    public function historico(){
      return $this->hasMany('App\Models\controlinversion\TSolhistorico', 'soh_sci_id', 'sci_id');
    }




}
