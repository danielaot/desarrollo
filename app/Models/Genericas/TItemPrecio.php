<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TItemPrecio extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_itemprecio';

    protected $primaryKey = 'pre_id';

    public $timestamps = false;

    protected $fillable = [
        'lis_id',
        'ite_id',
        'pre_dat_activacion',
        'pre_dat_inactivacion',
        'pre_num_dtopromocion',
        'pre_txt_unidadmedida',
        'pre_num_precio',
        'pre_num_preciosuge'
    ];
}
