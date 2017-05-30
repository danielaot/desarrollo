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

    public function origen()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_origen')->where('idItemCriterioPlanItemCriterioMayor','100');
  	}

    public function tipomarcas()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_tmarca')->where('idItemCriterioPlanItemCriterioMayor','129');
  	}

    public function tipooferta()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_toferta')->where('idItemCriterioPlanItemCriterioMayor','131');
  	}

    public function menuprom()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_meprom')->where('idItemCriterioPlanItemCriterioMayor','132');
  	}

    public function tipoprom()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_tiprom')->where('idItemCriterioPlanItemCriterioMayor','140');
  	}

    public function presentacion()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_presentacion')->where('idItemCriterioPlanItemCriterioMayor','141');
  	}

    public function variedad()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_varbesa')->where('idItemCriterioPlanItemCriterioMayor','142');
  	}

    public function categoria()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_categoria')->where('idItemCriterioPlanItemCriterioMayor','200');
  	}

    public function linea()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_linea')->where('idItemCriterioPlanItemCriterioMayor','300');
  	}

    public function sublinea()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_sublinea')->where('idItemCriterioPlanItemCriterioMayor','400');
  	}

    public function submercadeo()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_sublineamer')->where('idItemCriterioPlanItemCriterioMayor','405');
  	}

    public function submercadeo2()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_sublineamer2')->where('idItemCriterioPlanItemCriterioMayor','406');
  	}

    public function submarca()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_submarca')->where('idItemCriterioPlanItemCriterioMayor','409');
  	}

    public function regalias()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_regalias')->where('idItemCriterioPlanItemCriterioMayor','420');
  	}

    public function segmento()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_segmento')->where('idItemCriterioPlanItemCriterioMayor','406');
  	}

    public function clasificacion()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_clasificacion')->where('idItemCriterioPlanItemCriterioMayor','409');
  	}

    public function acondicionamiento()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ide_acondicionamiento')->where('idItemCriterioPlanItemCriterioMayor','420');
  	}
}
