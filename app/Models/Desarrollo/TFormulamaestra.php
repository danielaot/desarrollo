<?php

namespace App\Models\Desarrollo;

use Illuminate\Database\Eloquent\Model;

class TFormulamaestra extends Model
{
    protected $connection = 'desarrollo';

    protected $table = 't_formulamaestra';

    protected $primaryKey = 'frm_int_id';

	  public $timestamps = false;

    protected $fillable = [
        'frm_int_idportafolionuevo',
        'frm_int_idproductonuevo',
        'frm_int_idensayo',
        'frm_int_idlinea',
        'frm_txt_identificacion',
        'frm_txt_nombreproducto',
        'frm_txt_fechavigencia',
        'frm_txt_idusuario',
        'frm_txt_fechacreacion',
        'frm_txt_codigounoe',
        'frm_txt_fechaunoe',
        'frm_txt_idusuariounoe',
        'frm_txt_estado',
        'frm_txt_estadocreacion',
        'frm_txt_obsaprobacion',
        'frm_txt_usuarioaprobacion',
        'frm_txt_estadoaprobacion',
        'frm_txt_fechaaprobacion',
        'frm_txt_grupocosmetico',
        'frm_txt_estadoespecificacion',
        'frm_txt_obsaproesp',
        'frm_txt_usuarioaproesp',
        'frm_txt_estadoaprobespecificacion',
        'frm_txt_estadoinstructivo',
        'frm_txt_usuarioinstructivo',
        'frm_txt_obsaproinst',
        'frm_txt_estadoaproinstructivo',
        'frm_txt_usuarioaproinstructivo',
        'frm_txt_notificacionsanitaria',
        'frm_int_idcategoria',
        'frm_int_idsublinea',
        'frm_txt_densidad',
        'frm_txt_tamanolote',
        'frm_txt_idcentrotrabajo',
        'frm_txt_usomaterial',
        'frm_txt_eptestadodesarrollo',
        'frm_txt_eptfechadesarrollo',
        'frm_txt_eptusuariodesarrollo',
        'frm_txt_eptapdestadoesarrollo',
        'frm_txt_eptapusuario',
        'frm_txt_eptapfecha'
    ];
}
