<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TItem extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_items';

    protected $fillable = [
        'ite_proy',
        'ite_referencia',
        'ite_tproducto',
        'ite_eanext',
        'ite_ean13',
        'ite_estado',
        'ite_est_logyca',
        'ite_dat_captura'
    ];

    public function detalles()
  	{
  		  return $this->hasOne('App\Models\Pricat\TItemDetalle', 'ide_item');
  	}

    public function eanes()
  	{
  		  return $this->hasMany('App\Models\Pricat\TItemEan', 'iea_item');
  	}

    public function eanppal()
  	{
  		  return $this->hasOne('App\Models\Pricat\TItemEan', 'iea_item')->where('iea_principal', 1);
  	}

    public function patrones()
  	{
  		  return $this->hasOne('App\Models\Pricat\TItemPatron', 'ipa_item');
  	}

    public function proyectos()
  	{
  		  return $this->hasOne('App\Models\Pricat\TProyecto', 'id', 'ite_proy');
  	}

    public function tipo()
  	{
  		  return $this->hasOne('App\Models\Genericas\Itemcriteriomayor', 'idItemCriterioMayor', 'ite_tproducto')->where('idItemCriterioPlanItemCriterioMayor','130');
  	}

    public function solsubempaques()
  	{
  		  return $this->hasMany('App\Models\Pricat\TSolSubempaque', 'ssu_item');
  	}
}