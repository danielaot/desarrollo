@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso2Ctrl" ng-cloak>
    <form name="paso2Form" ng-submit="paso2Form.$valid && saveProducto()" class="form-horizontal" novalidate>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <label class="col-sm-3 control-label">Referencia:</label>
            <p class="col-sm-6 control-label">{{$item['ite_referencia']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Ean Externo:</label>
            <p class="col-sm-6 control-label">{{$item['ite_eanext']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Descripción:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_deslarga']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Descripción Corta:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_descorta']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Descripción Completa:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_descompleta']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_origen')}">
            <label class="col-sm-3 control-label">Origen:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_origen']}} - {{$item['detalles']['origen']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Tipo de Inventario:</label>
            <p class="col-sm-6 control-label">1051 - Producto Terminado</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Clase:</label>
            <p class="col-sm-6 control-label">1101 - Manufacturado</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Estado Criterio:</label>
            <p class="col-sm-6 control-label">1201 - Activo</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_tmarca')}">
            <label class="col-sm-3 control-label">Tipo de Marca:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_tmarca']}} - {{$item['detalles']['tipomarcas']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row">
            <label class="col-sm-3 control-label">Tipo:</label>
            <p class="col-sm-6 control-label">{{$item['ite_tproducto']}} - {{$tipo}}</label>
          </div>
          @if($tipo != 'Regular')
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_toferta')}">
              <label class="col-sm-3 control-label">Tipo de Oferta:</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_toferta']}} - {{$item['detalles']['tipooferta']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_meprom')}">
              <label class="col-sm-3 control-label">Menú de Promociones:</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_meprom']}} - {{$item['detalles']['menuprom']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_tiprom')}">
              <label class="col-sm-3 control-label">Tipo de Promoción:</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_tiprom']}} - {{$item['detalles']['tipoprom']['descripcionItemCriterioMayor']}}</p>
            </div>
          @endif
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_presentacion')}">
            <label class="col-sm-3 control-label">Presentación:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_presentacion']}} - {{$item['detalles']['presentacion']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_varbesa')}">
            <label class="col-sm-3 control-label">Variedad:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_varbesa']}} - {{$item['detalles']['variedad']['descripcionItemCriterioMayor']}}</p>
          </div>
          @if($tipo != 'Regular')
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_comp1')}">
              <label class="col-sm-3 control-label">Ref Componente Principal:</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_comp1']}}</p>
            </div>
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_comp2')}">
              <label class="col-sm-3 control-label">Ref Componente 2:</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_comp2']}}</p>
            </div>
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_comp3')}">
              <label class="col-sm-3 control-label">Ref Componente 3:</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_comp3']}}</p>
            </div>
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_comp4')}">
              <label class="col-sm-3 control-label">Ref Componente 4:</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_comp4']}}</p>
            </div>
          @endif
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_categoria')}">
            <label class="col-sm-3 control-label">Categoria:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_categoria']}} - {{$categoria}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_linea')}">
            <label class="col-sm-3 control-label">Linea:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_linea']}} - {{$item['detalles']['linea']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_sublinea')}">
            <label class="col-sm-3 control-label">Sublinea:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_sublinea']}} - {{$item['detalles']['sublinea']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_sublineamer')}">
            <label class="col-sm-3 control-label">Sublinea Mercadeo:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_sublineamer']}} - {{$item['detalles']['submercadeo']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_sublineamer2')}">
            <label class="col-sm-3 control-label">Sublinea Mercadeo 2:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_sublineamer2']}} - {{$item['detalles']['submercadeo2']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_submarca')}">
            <label class="col-sm-3 control-label">Submarca:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_submarca']}} - {{$item['detalles']['submarca']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_contenido')}">
            <label class="col-sm-3 control-label">Tamaño/Contenido:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_contenido']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_umcont')}">
            <label class="col-sm-3 control-label">Unidad de Medida:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_umcont']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_regalias')}">
            <label class="col-sm-3 control-label">Regalias:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_regalias']}} - {{$item['detalles']['regalias']['descripcionItemCriterioMayor']}}</p>
          </div>
          @if($categoria == 'Accesorios')
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_segmento')}">
              <label class="col-sm-3 control-label">Segmento(ACC):</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_segmento']}} - {{$item['detalles']['segmento']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_clasificacion')}">
              <label class="col-sm-3 control-label">Clasificación(ACC):</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_clasificacion']}} - {{$item['detalles']['clasificacion']['descripcionItemCriterioMayor']}}</p>
            </div>
            <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_acondicionamiento')}">
              <label class="col-sm-3 control-label">Acondicionamiento(ACC):</label>
              <p class="col-sm-6 control-label">{{$item['detalles']['ide_acondicionamiento']}} - {{$item['detalles']['acondicionamiento']['descripcionItemCriterioMayor']}}</p>
            </div>
          @endif
          @if($tipo != 'Regular')
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_nomtemporada')}">
            <label class="col-sm-3 control-label">Nombre Temporada:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_nomtemporada']}} - {{$item['detalles']['nomtemporada']['descripcionItemCriterioMayor']}}</p>
          </div>
          <div class="row" ng-class="{'has-error' : (errores | contains: 'ide_anotemporada')}">
            <label class="col-sm-3 control-label">Año Temporada:</label>
            <p class="col-sm-6 control-label">{{$item['detalles']['ide_anotemporada']}}</p>
          </div>
          @endif
          <br>
          <div class="row">
            <div class="text-center">
              <input type="hidden" ng-model="producto.proy" ng-init="producto.proy = {{$idproyecto}}"/>
              <input type="hidden" ng-model="producto.act" ng-init="producto.act = {{$idactividad}}"/>
              <input type="hidden" ng-model="producto.item" ng-init="producto.item = {{$item['id']}}"/>
              <input type="hidden" ng-model="producto.referencia" ng-init="producto.referencia = '{{$item['ite_referencia']}}'"/>
              <button class="btn btn-primary" type="submit">Validar</button>
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
