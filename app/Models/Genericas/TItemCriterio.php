<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

class TItemCriterio extends Model
{
    protected $connection = 'genericas';

    protected $table = 't_itemcriterio';

    protected $primaryKey = 'ite_id';

	  public $timestamps = false;

    protected $fillable = [
        'ite_txt_referencia',
        'ite_txt_descripcion',
        'ite_num_tipoinventario',
        'ite_num_proveedor',
        'ite_num_estado',
        'ite_txt_estado',
        'ite_num_linea',
        'ite_num_slinmercadeo',
        'ite_num_slinmercadeo2',
        'ite_num_categoria',
        'ite_txt_regsanitario',
        'ite_txt_indsanitario',
        'ite_txt_nomsanitario',
        'ite_num_tipomaterial',
        'ite_num_tipomaterial2',
        'ite_num_sublinea',
        'ite_num_centrocostos',
        'ite_num_tipo',
        'ite_num_origen',
        'ite_num_clase',
        'ite_txt_unidadorden',
        'ite_num_tipopromocion',
        'ite_num_tamanocontenido',
        'ite_num_costo'
    ];
}
