<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TSucursal extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_sucursal';

    protected $primaryKey = 'suc_id';

    public $timestamps = false;

    protected $fillable = [
        'cli_id',
        'ven_id',
        'zon_id',
        'suc_txt_ciudad',
        'suc_txt_depto',
        'suc_num_codigo',
        'suc_txt_nombre',
        'suc_txt_direccion',
        'suc_txt_telefono',
        'suc_txt_contacto',
        'cen_factura_id',
        'cen_movimiento_id',
        'suc_txt_unidadnegocio',
        'suc_txt_formapago',
        'suc_txt_estado',
        'suc_num_codigoenvio',
        'codcanal'
    ];

    public function clientetcc(){
      return $this->hasOne('App\Models\Genericas\TCliente','cli_id','cli_id');
    }

    public function boomerangtcc(){
      return $this->hasOne('App\Models\tccws\TClientesBoomerang','clb_cod_sucursal','suc_num_codigo');
    }
}
