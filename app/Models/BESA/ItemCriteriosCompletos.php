<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class ItemCriteriosCompletos extends Model
{
    protected $connection = 'besa';

    protected $table = '888_Item_Criterios_Completos';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'referencia',
        'descripcion',
        'tipo_inv',
        'cod_acond_acc',
        'nom_acond_acc',
        'cod_clase',
        'nom_clase',
        'cod_categoria',
        'nom_categoria',
        'cod_clasificacion_acc',
        'nom_clasificacion_acc',
        'cod_estado',
        'nom_estado',
        'cod_familia',
        'nom_familia',
        'cod_linea',
        'nom_linea',
        'cod_origen',
        'nom_origen',
        'cod_prefijo_acc',
        'nom_prefijo_acc',
        'cod_presentacion',
        'nom_presentacion',
        'cod_presentacioncomercial',
        'nom_presentacioncomercial',
        'cod_refcomp2',
        'nom_refcomp2',
        'cod_refcomp3',
        'nom_refcomp3',
        'cod_refcomp4',
        'nom_refcomp4',
        'cod_refcompppal',
        'nom_refcompppal',
        'cod_refhomologo',
        'nom_refhomologo',
        'cod_segmento',
        'nom_segmento',
        'cod_sublinea',
        'nom_sublinea',
        'cod_sublinea_mercadeo',
        'nom_sublinea_mercadeo',
        'cod_sublinea_mercadeo2',
        'nom_sublinea_mercadeo2',
        'cod_tamano',
        'nom_tamano',
        'cod_tipo_promocion',
        'nom_tipo_promocion',
        'cod_tipoinv',
        'nom_tipoinv',
        'cod_tipomaterial_1',
        'nom_tipomaterial_1',
        'cod_tipomaterial_2',
        'nom_tipomaterial_2',
        'cod_tipo_pr',
        'nom_tipo_pr',
        'cod_undmedida',
        'nom_undmedida',
        'cod_variedad',
        'nom_variedad',
        'f120_rowid',
        'cod_nomtemporada',
        'nom_nomtemporada',
        'cod_anotemporada',
        'nom_anotemporada',
        'f121_ind_estado',
        'desc_refhomologo',
        'desc_refcompppal',
        'desc_refcomp4',
        'desc_refcomp3',
        'desc_refcomp2',
        'und_inv',
        'cod_tipomarca',
        'nom_tipomarca',
        'empaque_ppal',
        'f284_id',
        'cod_tipooft',
        'nom_tipooft',
        'cod_menuprom',
        'nom_menuprom',
        'cod_submarca',
        'nom_submarca',
        'cod_regalia',
        'nom_regalia'
    ];
}
