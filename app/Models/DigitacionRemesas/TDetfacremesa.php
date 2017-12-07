<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDetfacremesa
 */
class TDetfacremesa extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_detfacremesa';

    protected $primaryKey = 'det_id';

	public $timestamps = false;

    protected $fillable = [
        'rem_id',
        'det_num_tipodocto',
        'det_num_factura',
        'det_num_ordencompra',
        'det_dat_vencimiento1',
        'det_dat_vencimiento2',
        'det_txt_valorfactura',
        'det_num_unidadesfactura',
        'det_num_itemsfactura',
        'can_id'
    ];

    protected $guarded = [];


}
