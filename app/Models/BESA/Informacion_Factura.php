<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Informacion_Factura extends Model
{
    protected $connection = 'besa';

    protected $table = 'BESA.dbo.601_Informacion_Factura';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'f_tipo_pedido',
        'f_num_pedido',
        'f_tipo_docto',
        'f_num_consecutivo',
        'f_num_rowidTercero',
        'f_nom_tercero',
        'f_num_sucursal',
        'f_desc_sucursal',
        'f_txt_direccion',
        'f_num_telefono',
        'f_num_codigoPais',
        'f_num_departamento',
        'f_num_ciudad',
        'f_desc_ciudad',
        'f_desc_departamento',
        'f_notas',
        'f_date_creacion',
        'f_nit_tercero',
        'f_num_factura'
    ];

    public function uplorder(){    	
        return $this->hasOne('App\Models\wms\UPL_ORDERS', 'A29', 'f_num_factura');
    }

}
