<?php

namespace App\Models\tccws;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCiudadestcc
 */
class TCiudadestcc extends Model
{
    protected $connection = 'conectortccws';
    protected $table = 't_ciudadestcc';

    public $timestamps = true;

    protected $fillable = [
        'ctc_tipo_geo',
        'ctc_cod_sion',
        'ctc_dept_id',
        'ctc_depa_desc',
        'ctc_cod_dane',
        'ctc_ciu_tcc',
        'ctc_dept_erp',
        'ctc_ciu_erp',
        'ctc_ciu_abrv',
        'ctc_pais_id',
        'ctc_pais_abrv',
        'ctc_ticg_id_int',
        'ctc_ticg_desc',
        'ctc_loca_id_int',
        'ctc_cop',
        'ctc_reex',
        'ctc_estado'
    ];

    protected $guarded = [];


}
