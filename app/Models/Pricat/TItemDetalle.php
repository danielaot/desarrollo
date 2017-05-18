<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TItemDetalle extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_item_detalle';

    protected $fillable = [
        'ide_item',
        'ide_uso',
        'ide_marca',
        'ide_variedad',
        'ide_contenido',
        'ide_umcont',
        'ide_descorta',
        'ide_desclarga',
        'ide_descompleta',
        'ide_catlogyca',
        'ide_nomfab',
        'ide_origen',
        'ide_tmarca',
        'ide_toferta',
        'ide_meprom',
        'ide_tiprom',
        'ide_presentacion',
        'ide_varbesa',
        'ide_comp1',
        'ide_comp2',
        'ide_comp3',
        'ide_comp4',
        'ide_categoria',
        'ide_linea',
        'ide_sublinea',
        'ide_sublineamer',
        'ide_sublineamer2',
        'ide_submarca',
        'ide_regalias',
        'ide_segmento',
        'ide_clasificacion',
        'ide_acondicionamiento'
    ];

    public function items()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TItem', 'ide_item');
  	}
}
