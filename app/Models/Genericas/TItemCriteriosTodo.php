<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TItemcriteriosTodo extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_itemcriterios_todos';

    protected $primaryKey = 'ite_id';

    public $timestamps = false;

    protected $fillable = [
        'ite_referencia',
        'ite_descripcion',
        'ite_tipo_inv',
        'ite_cod_acond_acc',
        'ite_nom_acond_acc',
        'ite_cod_clase',
        'ite_nom_clase',
        'ite_cod_categoria',
        'ite_nom_categoria',
        'ite_cod_clasificacion_acc',
        'ite_nom_clasificacion_acc',
        'ite_cod_estado',
        'ite_nom_estado',
        'ite_cod_familia',
        'ite_nom_familia',
        'ite_cod_linea',
        'ite_nom_linea',
        'ite_cod_origen',
        'ite_nom_origen',
        'ite_cod_prefijo_acc',
        'ite_nom_prefijo_acc',
        'ite_cod_presentacion',
        'ite_nom_presentacion',
        'ite_cod_presentacioncomercial',
        'ite_nom_presentacioncomercial',
        'ite_cod_refcomp2',
        'ite_nom_refcomp2',
        'ite_cod_refcomp3',
        'ite_nom_refcomp3',
        'ite_cod_refcomp4',
        'ite_nom_refcomp4',
        'ite_cod_refcompppal',
        'ite_nom_refcompppal',
        'ite_cod_refhomologo',
        'ite_nom_refhomologo',
        'ite_cod_segmento',
        'ite_nom_segmento',
        'ite_cod_sublinea',
        'ite_nom_sublinea',
        'ite_cod_sublinea_mercadeo',
        'ite_nom_sublinea_mercadeo',
        'ite_cod_sublinea_mercadeo2',
        'ite_nom_sublinea_mercadeo2',
        'ite_cod_tamano',
        'ite_nom_tamano',
        'ite_cod_tipo_promocion',
        'ite_nom_tipo_promocion',
        'ite_cod_tipoinv',
        'ite_nom_tipoinv',
        'ite_cod_tipomaterial_1',
        'ite_nom_tipomaterial_1',
        'ite_cod_tipomaterial_2',
        'ite_nom_tipomaterial_2',
        'ite_cod_tipo_pr',
        'ite_nom_tipo_pr',
        'ite_cod_undmedida',
        'ite_nom_undmedida',
        'ite_cod_variedad',
        'ite_nom_variedad',
        'ite_cod_nomtemporada',
        'ite_nom_nomtemporada',
        'ite_cod_anotemporada',
        'ite_nom_anotemporada',
        'ite_f121_ind_estado',
        'ite_desc_refhomologo',
        'ite_desc_refcompppal',
        'ite_desc_refcomp4',
        'ite_desc_refcomp3',
        'ite_desc_refcomp2'
    ];

    public function LineaItemCriterio(){
      return $this->hasOne('App\Models\controlinversion\TLineascc', 'lcc_codigo', 'ite_cod_linea');
    }

}
