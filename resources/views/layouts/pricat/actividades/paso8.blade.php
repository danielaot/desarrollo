@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso8Ctrl" ng-cloak>
    <form name="paso8Form" ng-submit="paso8Form.$valid && saveProducto($event)" class="form-horizontal" novalidate>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-8">
              <div class="row">
                <label class="col-sm-3">Referencia :</label>
                <p class="col-sm-7">{{$item['ite_referencia']}} - {{$item['detalles']['ide_descompleta']}}</p>
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <label class="col-sm-4">Categoria :</label>
                <p class="col-sm-7">{{$item['detalles']['ide_categoria']}} - {{$item['detalles']['categoria']['descripcionItemCriterioMayor']}}</p>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <label class="col-sm-4">Línea :</label>
                <p class="col-sm-7">{{$item['detalles']['ide_linea']}} - {{$item['detalles']['linea']['descripcionItemCriterioMayor']}}</p>
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-sm-8">
              <div class="row">
                <label class="col-sm-4">Granel asociado en el ERP:</label>
                <p class="col-sm-7">{{trim($lista['Cod_Item_Componente'])}} - {{$lista['Nom_Item_Componente']}}</p>
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-sm-8">
              <div class="row">
                <label class="col-sm-3">Notificación Sanitaria :</label>
                <p class="col-sm-3">
                  {{$registro['nosa_notificacion']}}
                </p>
                <div class="col-sm-2">
                  <a href="../../storage/app{{$registro['nosa_documento']}}" target="_blank">
                    <button type="button" class="btn btn-info btn-sm">
                      <i class="glyphicon glyphicon-eye-open"></i>
                    </button>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="text-center">
              <input type="hidden" ng-model="producto.proy" ng-init="producto.proy = {{$idproyecto}}"/>
              <input type="hidden" ng-model="producto.act" ng-init="producto.act = {{$idactividad}}"/>
              <input type="hidden" ng-model="producto.item" ng-init="producto.item = {{$item}}"/>
              <input type="hidden" ng-model="producto.registro" ng-init="producto.registro = {{$registro}}"/>
              <button class="btn btn-primary" type="submit">Confirmar</button>
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
  <script src="{{url('/js/pricat/paso8Ctrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
