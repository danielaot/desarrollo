<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolipernivel
 */
class TSolipernivel extends Model
{
    protected $connection = "bd_controlinversion";

    protected $table = 't_solipernivel';

    public $timestamps = true;

    protected $fillable = [
        'sni_usrnivel',
        'sni_sci_id',
        'sni_estado',
        'sni_orden',
        'sni_cedula'
    ];

    protected $guarded = [];

    public function tpernivel(){
      return $this->hasOne('App\Models\controlinversion\TPerniveles', 'id', 'sni_usrnivel');
    }

    public function solicitud(){
      return $this->hasOne('App\Models\controlinversion\TSolicitudctlinv', 'sci_id', 'sni_sci_id');
    }


    public static function getSolicitudesPorAceptar($unaSolaReferencia, $idSolcitud = null, $idUsuario = null){

      $solicitudesPorAceptar = [];

      if($unaSolaReferencia == false){

        $solicitudesPorAceptar = TSolipernivel::where('sni_usrnivel', $idUsuario )
        ->where('sni_estado',0)->with(
          'solicitud.tipoSalida',
          'solicitud.tpernivel',
          'solicitud.cargara',
          'solicitud.cargaralinea.lineasProducto',
          'solicitud.clientes.clientesReferencias.referencia',
          'solicitud.clientes.clientesReferencias.lineaProducto.lineasProducto',
          'solicitud.clientes.clientesZonas',
          'solicitud.estado',
          'solicitud.facturara.tercero',
          'solicitud.tipoPersona',
          'solicitud.clientes.clientesReferencias',
          'solicitud.historico',
          'solicitud.historico.estado',
          'solicitud.historico.perNivelEnvia',
          'solicitud.historico.perNivelRecibe'
          )->get();

      }elseif($unaSolaReferencia == true && $idSolcitud != null){

        $solicitudesPorAceptar = TSolipernivel::where('sni_usrnivel', $idUsuario)
        ->where('sni_sci_id', $idSolcitud)->whereIn('sni_estado',[1,0])->with(
          'solicitud.tipoSalida',
          'solicitud.tpernivel',
          'solicitud.cargara',
          'solicitud.cargaralinea.lineasProducto',
          'solicitud.clientes.clientesReferencias.referencia',
          'solicitud.clientes.clientesReferencias.lineaProducto.lineasProducto',
          'solicitud.clientes.clientesZonas',
          'solicitud.estado',
          'solicitud.facturara.tercero',
          'solicitud.tipoPersona',
          'solicitud.clientes.clientesReferencias',
          'solicitud.historico',
          'solicitud.historico.estado',
          'solicitud.historico.perNivelEnvia',
          'solicitud.historico.perNivelRecibe'
          )->get();

      }

      return $solicitudesPorAceptar;

    }


}
