@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso2Ctrl" ng-cloak>
    <form name="paso2Form" ng-submit="paso2Form.$valid && saveProducto()" class="form-horizontal" novalidate>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <label class="col-sm-3">Referencia:</label>
            <p class="col-sm-6">{{$item['ite_referencia']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Ean Externo:</label>
            <p class="col-sm-6">{{$item['ite_eanext']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Descripción:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_deslarga']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Descripción Corta:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_descorta']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Descripción Completa:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_descompleta']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Origen:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_origen']}} - {{$item['detalles'][0]['origen']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Tipo de Inventario:</label>
            <p class="col-sm-6">1051 - Producto Terminado</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Clase:</label>
            <p class="col-sm-6">1101 - Manufacturado</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Estado Criterio:</label>
            <p class="col-sm-6">1201 - Activo</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Tipo de Marca:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_tmarca']}} - {{$item['detalles'][0]['tipomarcas']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Tipo:</label>
            <p class="col-sm-6">{{$item['ite_tproducto']}} - {{$tipo}}</label>
          </div>
          @if($tipo != 'Regular')
            <div class="row">
              <label class="col-sm-3">Tipo de Oferta:</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_toferta']}} - {{$item['detalles'][0]['tipooferta']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row">
              <label class="col-sm-3">Menú de Promociones:</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_meprom']}} - {{$item['detalles'][0]['menuprom']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row">
              <label class="col-sm-3">Tipo de Promoción:</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_tiprom']}} - {{$item['detalles'][0]['tipoprom']['descripcionItemCriterioMayor']}}</p>
            </div>
          @endif
          <div class="row">
            <label class="col-sm-3">Presentación:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_presentacion']}} - {{$item['detalles'][0]['presentacion']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Variedad:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_varbesa']}} - {{$item['detalles'][0]['variedad']['descripcionItemCriterioMayor']}}</p>
          </div>
          @if($tipo != 'Regular')
            <div class="row">
              <label class="col-sm-3">Ref Componente Principal:</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_comp1']}}</p>
            </div>
            <div class="row">
              <label class="col-sm-3">Ref Componente 2:</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_comp2']}}</p>
            </div>
            <div class="row">
              <label class="col-sm-3">Ref Componente 3:</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_comp3']}}</p>
            </div>
            <div class="row">
              <label class="col-sm-3">Ref Componente 4:</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_comp4']}}</p>
            </div>
          @endif
          <div class="row">
            <label class="col-sm-3">Categoria:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_categoria']}} - {{$categoria}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Linea:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_linea']}} - {{$item['detalles'][0]['linea']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Sublinea:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_sublinea']}} - {{$item['detalles'][0]['sublinea']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Sublinea Mercadeo:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_sublineamer']}} - {{$item['detalles'][0]['submercadeo']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Sublinea Mercadeo 2:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_sublineamer2']}} - {{$item['detalles'][0]['submercadeo2']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Submarca:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_submarca']}} - {{$item['detalles'][0]['submarca']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Tamaño/Contenido:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_contenido']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Unidad de Medida:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_umcont']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3">Regalias:</label>
            <p class="col-sm-6">{{$item['detalles'][0]['ide_regalias']}} - {{$item['detalles'][0]['regalias']['descripcionItemCriterioMayor']}}</p>
          </div>
          @if($categoria == 'Accesorios')
            <div class="row">
              <label class="col-sm-3">Segmento(ACC):</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_segmento']}} - {{$item['detalles'][0]['segmento']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row">
              <label class="col-sm-3">Clasificación(ACC):</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_clasificacion']}} - {{$item['detalles'][0]['clasificacion']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row">
              <label class="col-sm-3">Acondicionamiento(ACC):</label>
              <p class="col-sm-6">{{$item['detalles'][0]['ide_acondicionamiento']}} - {{$item['detalles'][0]['acondicionamiento']['descripcionItemCriterioMayor']}}</p>
            </div>
          @endif
          <div class="row">
            <div class="col-sm-1">
              <label class="control-label">EAN13:</label>
            </div>
            <div class="col-sm-3">
              <input type="number" class="form-control" ng-model="producto.ean13" required/>
            </div>
            <div class="col-sm-1">
              <label class="control-label">EAN14:</label>
            </div>
            <div class="col-sm-3">
              <input type="number" class="form-control" ng-model="producto.ean14" required/>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="text-center">
              <input type="hidden" ng-model="producto.proy" ng-init="producto.proy = {{$idproyecto}}"/>
              <input type="hidden" ng-model="producto.act" ng-init="producto.act = {{$idactividad}}"/>
              <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/paso2Ctrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
