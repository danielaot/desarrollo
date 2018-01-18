<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCliente
 */
class TCliente extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_clientes';

    protected $primaryKey = 'suc_id';

	public $timestamps = false;

    protected $fillable = [
        'suc_nit_id',
        'suc_num_codigo',
        'suc_txt_nombre',
        'suc_txt_direccion',
        'suc_txt_telefono',
        'suc_txt_ciudad',
        'suc_txt_estado',
        'suc_num_codigoenvio'
    ];

    protected $guarded = [];


}
