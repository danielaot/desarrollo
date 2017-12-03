<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;

use App\Models\Pricat\TProyecto as Proyecto;
use App\Models\Pricat\TProceso as Proceso;
use App\Models\Pricat\TDesarrolloActividad as Desarrollo;
use App\Models\Pricat\TItem as Item;
use App\Models\Pricat\TItemDetalle as ItemDetalle;
use App\Models\Pricat\TNotificacionSanitaria as NotiSanitaria;
use App\Models\BESA\AppwebListaMateriales as ListaMateriales;
ini_set('memory_limit', '-1');

class ConsultaController extends Controller
{
    public function index()
    {
        $ruta = 'Calidad de Datos y Homologación // Catalogos // Administrar Proyectos';
        $titulo = 'Consulta de Referencias';

        return view('layouts.pricat.actividades.indexConsulta', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $proyectos = Proyecto::with('procesos')->get();

        $referencias = Item::with('detalles.notificacionsanitaria', 'tipo', 'detalles.uso',
                                  'detalles.logcategorias', 'detalles.origen', 'detalles.tipomarcas',
                                  'detalles.variedad', 'detalles.linea', 'detalles.submercadeo',
                                  'detalles.submarca', 'detalles.clase', 'detalles.presentacion',
                                  'detalles.categoria', 'detalles.sublinea', 'detalles.submercadeo2',
                                  'detalles.regalias', 'detalles.tipooferta', 'detalles.tipoprom',
                                  'detalles.menuprom','detalles.segmento', 'detalles.nomtemporada',
                                  'detalles.tipomarcas', 'detalles.posicionarancelaria', 'detalles.grupoimpositivo',
                                  'eanppal.tembalaje', 'detalles.tipoempaque', 'detalles.condmanipulacion', 'patrones')
                                  ->get();

        $response = compact('proyectos', 'referencias');

        return response()->json($response);
    }

    public function generarExcel(){
      $referencias = Item::with('detalles.notificacionsanitaria', 'tipo', 'detalles.uso',
                                'detalles.logcategorias', 'detalles.origen', 'detalles.tipomarcas',
                                'detalles.variedad', 'detalles.linea', 'detalles.submercadeo',
                                'detalles.submarca', 'detalles.clase', 'detalles.presentacion',
                                'detalles.categoria', 'detalles.sublinea', 'detalles.submercadeo2',
                                'detalles.regalias', 'detalles.tipooferta', 'detalles.tipoprom',
                                'detalles.menuprom','detalles.segmento', 'detalles.nomtemporada',
                                'detalles.tipomarcas', 'detalles.posicionarancelaria', 'detalles.grupoimpositivo',
                                'eanppal.tembalaje', 'detalles.tipoempaque', 'detalles.condmanipulacion', 'patrones')
                                ->get();

      $response = compact('proyectos', 'referencias');

      return response()->json($response);
    }

    public function consulta(Request $request){

      $info = $request->all();

      foreach ($info as $key => $value) {
        $idproyecto = $value['ite_proy'];
      }

      $item = Item::with('detalles')
                  ->where('ite_proy', $idproyecto)
                  ->get()->first();

      $componente = ItemDetalle::where('ide_item', $item->id)
                                ->get()->first();

      if ($item->ite_tproducto == '1301') {

          $lista = ListaMateriales::where(['Cod_Item' => $item->ite_referencia.'P', 'Tipo_Item_Componente' => 'INVPROCEG', 'metodo' => '0001'])
          ->get()->first();

          $registro = NotiSanitaria::whereHas('graneles', function($query) use($lista){
            $query->where('rsg_ref_granel', trim($lista->Cod_Item_Componente));
          })
          ->get()->first();
      }else {

          $lista = ListaMateriales::where(['Cod_Item' => $componente->ide_comp1.'P', 'Tipo_Item_Componente' => 'INVPROCEG', 'metodo' => '0001'])
          ->get()->first();

          $registro = NotiSanitaria::whereHas('graneles', function($query) use($lista){
            $query->where('rsg_ref_granel', trim($lista->Cod_Item_Componente));
          })
          ->get()->first();
      }

      $response = compact('lista');

      return response()->json($response);
    }
}
