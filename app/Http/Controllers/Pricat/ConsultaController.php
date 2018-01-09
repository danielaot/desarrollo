<?php

namespace App\Http\Controllers\Pricat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Excel;

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
        $ruta = 'Plataforma Integral de Creación de Items // Catalogos // Administrar Proyectos';
        $titulo = 'Consulta de Referencias';

        return view('layouts.pricat.actividades.indexConsulta', compact('ruta', 'titulo'));
    }

    public function getInfo()
    {
        $proyectos = Proyecto::with('procesos')->get();

        $referencias = Item::with('detalles.notificacionsanitaria', 'tipo', 'detalles.uso',
                                  'detalles.logcategorias','detalles.exicategorias' ,'detalles.origen', 'detalles.tipomarcas',
                                  'detalles.variedad', 'detalles.linea', 'detalles.submercadeo',
                                  'detalles.submarca', 'detalles.clase', 'detalles.presentacion',
                                  'detalles.categoria', 'detalles.sublinea', 'detalles.submercadeo2',
                                  'detalles.regalias', 'detalles.tipooferta', 'detalles.tipoprom',
                                  'detalles.menuprom','detalles.segmento', 'detalles.nomtemporada',
                                  'detalles.tipomarcas', 'detalles.posicionarancelaria', 'detalles.grupoimpositivo',
                                  'eanppal.tembalaje', 'detalles.tipoempaque', 'detalles.condmanipulacion', 'patrones',
                                  'detalles.estadoref', 'detalles.presentacion', 'detalles.comp1', 'detalles.comp2',
                                  'detalles.comp3', 'detalles.comp4', 'detalles.comp5', 'detalles.comp6',
                                  'detalles.comp7', 'detalles.comp8', 'detalles.tempaques')
                                  ->get();

        $response = compact('proyectos', 'referencias');

        return response()->json($response);
    }

    public function generarExcel(Request $request){

      $infocomp = $request->all();

    return Excel::create('Pricat', function($excel) use ($infocomp){
        $excel->sheet('Hoja 1', function($sheet) use($infocomp){
          $sheet->row(1,[
            'No. ITEM','Categoría LogycaSync', 'EAN 13', 'EAN 14', 'Referencia', 'Descripción Interna', 'Descripción LogycaSync (CABASnet)',
            'Descripción Completa', 'Marca', 'ORIGEN', 'ESTADO', 'TIPO DE MARCA', 'TIPO', 'TIPO OFERTA', 'MENU DE PROMOCION', 'TIPO PROMOCION',
            'PRESENTACION', 'VARIEDAD', 'REF COMPONENTE PPAL', 'DESC.COMP PPAL', 'REF COMPONENTE  2', 'DESC.COMP 2', 'REF COMPONENTE  3', 'DESC.COMP 3',
            'REF COMPONENTE  4', 'DESC.COMP 4', 'REF HOMOLOGO', 'DESC.REF HOMOLOGO', 'CATEGORIA', 'LINEA PPAL', 'SUBLINEA', 'SUBLINEA MERCADEO', 'SUBLINEA MERCADEO 2',
            'TAMAÑO/CONTENIDO', 'UND DE MEDIDA', 'REGALIAS', 'SEGMENTO (ACC)', 'Embalaje', 'Fabricante', 'Precio Bruto (Lista)', 'Precio Neto (PVP)', 'GRUPO IMPOSITIVO',
            '% IVA', 'Posición Arancelaria', 'Alto', 'UM', 'Ancho', 'UM', 'Profundidad', 'UM', 'Peso Neto', 'UM', 'Peso Bruto', 'UM', 'Volumen', 'UM', 'TARA (Peso del Empaque)',
            'UM', 'Tipo de Empaque', 'Alto', 'UM', 'Ancho', 'UM', 'Profundidad', 'UM', 'Peso Neto', 'UM', 'Peso Bruto', 'UM', 'Volumen', 'UM', 'TARA (Peso del Empaque)',
            'UM', 'Código Corrugado', 'Cantidad contenida en el envase', 'UM', 'No Cajas por Estiba', 'No Unidades por estiba', 'No Cajas por tendido', 'No tendidos por estiba',
            'NOTIFICACION SANITARIA'
          ]);
          $sheet->row(2, [
            '1', '2'
          ]);
        });
      })->export('xlsx');
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
