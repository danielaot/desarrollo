<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRemesa
 */
class TRemesa extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_remesa';

    protected $primaryKey = 'rem_id';

	public $timestamps = false;

    protected $fillable = [
        'ciu_id',
        'ter_id_crea',
        'tra_id',
        'rem_dat_creacion',
        'rem_num_codigo',
        'rem_num_tipodespacho',
        'rem_num_cuentaremite',
        'ter_id',
        'suc_id',
        'suc_txt_descripcion',
        'ter_txt_descripcion',
        'ter_txt_direccion',
        'ter_num_telefono',
        'ter_txt_ciudad',
        'rem_num_tipodocumento',
        'rem_ltxt_observaciones',
        'rem_num_unidades',
        'rem_num_estibas',
        'rem_num_lios',
        'rem_num_cajas',
        'rem_num_kilos',
        'rem_num_totalkilos',
        'rem_dat_entrega',
        'rem_num_estado',
        'rem_num_factura',
        'rem_num_flete',
        'rem_num_porflete',
        'rem_num_estadotrans',
        'rem_txt_estadotrans',
        'cau_id',
        'suc_num_codigoenvio',
        'rem_date_fechahora',
        'rem_date_fechacorte'
    ];

    protected $guarded = [];


}
