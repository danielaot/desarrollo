<?php

namespace App\Models\DigitacionRemesas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCiudadtcc
 */
class TCiudadtcc extends Model
{
    protected $connection = 'digitacionremesas';
    
    protected $table = 't_ciudadtcc';

    protected $primaryKey = 'ciu_id';

	public $timestamps = false;

    protected $fillable = [
        'tra_id',
        'ciu_txt_nomciudad',
        'ciu_num_coddepto',
        'ciu_num_cendis',
        'ciu_num_codzona',
        'ciu_txt_nomabreviado',
        'ciu_txt_tipoce',
        'ciu_num_rutddc',
        'ciu_txt_actret',
        'ciu_txt_indfce',
        'ciu_txt_filler',
        'ciu_num_entbod'
    ];

    protected $guarded = [];


}
