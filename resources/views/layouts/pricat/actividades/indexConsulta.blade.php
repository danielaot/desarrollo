@extends('app')

@section('content')
  @include('includes.titulo')

  <div ng-controller="consultaCtrl" ng-cloak>
    <form name="consultaForm" ng-submit="consultaForm.$valid && consultaReferencia($event)" class="form-horizontal" novalidate>
      <div class="panel-default">
        <hr>
        <div class="row">
          <label class="col-sm-1 control-label">Referencia:</label>
          <div class="col-sm-6">
            <md-chips ng-model="consultaref" md-autocomplete-snap
               md-transform-chip="transformChip($chip)"
               md-on-add="onAddReferencia($chip)"
               md-on-remove="onRemoveReferencia($chip)"
               md-require-match="autocompleteDemoRequireMatch">
               <md-autocomplete md-search-text="referenciasSearchText"
                               md-items="referencia in referenciasSearch(referenciasSearchText)"
                               md-item-text="referencia.ite_referencia"
                               md-no-cache="true"
                               md-min-length="0">
                  <md-item-template>
                    <span md-highlight-text="referenciasSearchText">@{{referencia.ite_referencia}}</span>
                  </md-item-template>
                </md-autocomplete>
              <md-chip-template>
                <span>@{{$chip.ite_referencia}}</span>
             </md-chip-template>
           </md-chips>
          </div>
          <button type="submit" class="btn btn-primary">Consultar</button>
          <button type="button" class="btn btn-success" ng-click="generarExcel('#tablamostraruno')" ng-if="ref !== undefined">Generar Excel</button>
          <!-- <a ng-href="@{{urlDescarga}}" download="Pricat.xlsx">
          </a> -->
        </div>
        <hr>
        <div class="form-group">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Referencia</th>
                <th>Línea</th>
                <th>Registro Sanitario</th>
                <th></th>
              </tr>
            </thead>
            <tbody ng-if="ref !== undefined">
              <tr ng-repeat ="referencia in ref">
                <td>@{{referencia.ite_referencia}} - @{{referencia.detalles.ide_descompleta}}</td>
                <td>@{{referencia.detalles.linea.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.notificacionsanitaria.nosa_notificacion}}</td>
                <td>
                  <button type="button" class="btn btn-info btn-sm glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#modal2" ng-click="setReferencia(referencia)"></button>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal1" ng-click="regresar()">Solicitar Regresar Paso</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div id="tablamostraruno" ng-show="false" class="form-group">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="2"></th>
                <th colspan="3">AUX. DOCUMENTACION</th>
                <th colspan="42">MERCADEO / GERENCIA MANUFACTURA</th>
                <th colspan="3">COMERCIO EXTERIOR</th>
                <th colspan="15">DEL PRODUCTO POR UNIDAD</th>
                <th colspan="14">DEL EMPAQUE</th>
                <th colspan="2">CANTIDAD</th>
                <th colspan="4">LOGISTICA</th>
                <th colspan="4">NOTIFICACION SANITARIA</th>
              </tr>
                <th>No. Item</th>
                <th>Categoria LogycaSync</th>
                <th>EAN 13</th>
                <th>EAN 14</th>
                <th>Referencia</th>
                <th>Descripcion Interna</th>
                <th>Descripcion LogycaSync (CABASnet)</th>
                <th>Descripcion Completa</th>
                <th>Marca</th>
                <th>Origen</th>
                <th>Estado</th>
                <th>Tipo de Marca</th>
                <th>Tipo</th>
                <th>Tipo Oferta</th>
                <th>Menu de Promocion</th>
                <th>Tipo Promocion</th>
                <th>Presentacion</th>
                <th>Variedad</th>
                <th>Ref Componente Ppal</th>
                <th>Desc.Comp Ppal</th>
                <th>Ref Componente  2</th>
                <th>Desc.Comp 2</th>
                <th>Ref Componente  3</th>
                <th>Desc.Comp 3</th>
                <th>Ref Componente  4</th>
                <th>Desc.Comp 4</th>
                <th>Ref Componente  5</th>
                <th>Desc.Comp 5</th>
                <th>Ref Componente  6</th>
                <th>Desc.Comp 6</th>
                <th>Ref Componente  7</th>
                <th>Desc.Comp 7</th>
                <th>Ref Componente  8</th>
                <th>Desc.Comp 8</th>
                <th>Categoria</th>
                <th>Linea Ppal</th>
                <th>Sublinea</th>
                <th>Sublinea Mercadeo</th>
                <th>Sublinea Mercadeo 2</th>
                <th>Tamano/Contenido</th>
                <th>Und De Medida</th>
                <th>Regalias</th>
                <th>Segmento (Acc)</th>
                <th>Embalaje</th>
                <th>Fabricante</th>
                <th>Precio Bruto (Lista)</th>
                <th>Precio Neto (Pvp)</th>
                <th>Grupo Impositivo</th>
                <th>% Iva</th>
                <th>Posicion Arancelaria</th>
                <th>Alto</th>
                <th>Um</th>
                <th>Ancho</th>
                <th>Um</th>
                <th>Profundidad</th>
                <th>Um</th>
                <th>Peso Neto</th>
                <th>Um</th>
                <th>Peso Bruto</th>
                <th>Um</th>
                <th>Volumen</th>
                <th>Um</th>
                <th>Tara (Peso Del Empaque)</th>
                <th>Um</th>
                <th>Tipo De Empaque</th>
                <th>Alto</th>
                <th>Um</th>
                <th>Ancho</th>
                <th>Um</th>
                <th>Profundidad</th>
                <th>Um</th>
                <th>Peso Neto</th>
                <th>Um</th>
                <th>Peso Bruto</th>
                <th>Um</th>
                <th>Volumen</th>
                <th>Um</th>
                <th>Tara (Peso Del Empaque)</th>
                <th>Um</th>
                <th>Cantidad Contenida en el Envase</th>
                <th>Um</th>
                <th>No Cajas Por Estiba</th>
                <th>No Unidades Por Estiba</th>
                <th>No Cajas Por Tendido</th>
                <th>No Tendidos Por Estiba</th>
                <th>Notificacion Sanitaria</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat ="(key, referencia) in ref">
                <td>@{{key+1}}</td>
                <td>@{{referencia.detalles.ide_catlogyca}}</td>
                <td>@{{referencia.ite_ean13}}</td>
                <td>@{{"'" + referencia.eanppal.iea_ean}}</td>
                <td>@{{referencia.ite_referencia}}</td>
                <td>@{{referencia.detalles.ide_deslarga}}</td>
                <td>@{{referencia.detalles.ide_deslarga}}</td>
                <td>@{{referencia.detalles.ide_descompleta}}</td>
                <td>@{{referencia.detalles.ide_marca}}</td>
                <td>@{{referencia.detalles.origen.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.estadoref.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.tipomarcas.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.tipo.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.tipooferta.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.menuprom.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.tipoprom.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.presentacion.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.variedad.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.comp1.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp1.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.comp2.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp2.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.comp3.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp3.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.comp4.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp4.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.comp5.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp5.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.comp6.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp6.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.comp7.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp7.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.comp8.ite_txt_referencia}}</td>
                <td>@{{referencia.detalles.comp8.ite_txt_descripcion}}</td>
                <td>@{{referencia.detalles.categoria.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.linea.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.sublinea.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.submercadeo.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.submercadeo2.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.ide_contenido}}</td>
                <td>@{{referencia.detalles.ide_umcont}}</td>
                <td>@{{referencia.detalles.regalias.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.segmento.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.eanppal.iea_cantemb}}</td>
                <td>@{{referencia.detalles.ide_nomfab}}</td>
                <td>Pend</td>
                <td>Pend</td>
                <td>@{{referencia.detalles.grupoimpositivo.cod_grupoimpo}} - @{{referencia.detalles.grupoimpositivo.desc_grupoimpo}}</td>
                <td>@{{referencia.detalles.grupoimpositivo.f_tasa}}</td>
                <td>@{{referencia.detalles.posicionarancelaria.desc_pos_arancelaria}}</td>
                <td>@{{referencia.detalles.ide_alto}}</td>
                <td>mm-milimetros</td>
                <td>@{{referencia.detalles.ide_ancho}}</td>
                <td>mm-milimetros</td>
                <td>@{{referencia.detalles.ide_profundo}}</td>
                <td>mm-milimetros</td>
                <td>@{{referencia.detalles.ide_pesoneto}}</td>
                <td>kg-kilogramo</td>
                <td>@{{referencia.detalles.ide_pesobruto}}</td>
                <td>kg-kilogramo</td>
                <td>@{{referencia.detalles.ide_volumen}}</td>
                <td>mm-cubicos</td>
                <td>@{{referencia.detalles.ide_tara}}</td>
                <td>kg-kilogramo</td>
                <td>@{{referencia.detalles.tempaques.temp_nombre}}</td>
                <td>@{{referencia.eanppal.iea_alto}}</td>
                <td>mm-milimetros</td>
                <td>@{{referencia.eanppal.iea_ancho}}</td>
                <td>mm-milimetros</td>
                <td>@{{referencia.eanppal.iea_profundo}}</td>
                <td>mm-milimetros</td>
                <td>@{{referencia.eanppal.iea_pesoneto}}</td>
                <td>kg-kilogramo</td>
                <td>@{{referencia.eanppal.iea_pesobruto}}</td>
                <td>kg-kilogramo</td>
                <td>@{{referencia.eanppal.iea_volumen}}</td>
                <td>mm-cubicos</td>
                <td>@{{referencia.eanppal.iea_tara}}</td>
                <td>kg-kilogramo</td>
                <td>@{{referencia.detalles.ide_contenido}}</td>
                <td>@{{referencia.detalles.ide_umcont}}</td>
                <td>@{{referencia.patrones.ipa_caest}}</td>
                <td>@{{referencia.patrones.ipa_undest}}</td>
                <td>@{{referencia.patrones.ipa_cajten}}</td>
                <td>@{{referencia.patrones.ipa_tenest}}</td>
                <td>@{{referencia.detalles.notificacionsanitaria.nosa_notificacion}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
      @include('layouts.pricat.actividades.detalleReferencia')
  </div>
@endsection

@push('script_data_table')
  <script src="{{url('/js/pricat/consultaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
