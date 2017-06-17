@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="notificacionsanitariaCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-8">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="set()">
              <i class="glyphicon glyphicon-plus"></i> Crear
            </button>
          </div>
          <div class="col-sm-4 form-horizontal">
            <div class="row">
              <label class="col-sm-6 control-label" style="text-align: right;">Buscar:</label>
              <div class="col-sm-6">
                <input type="text" ng-model="searchtext" class="form-control"/>
              </div>
            </div>
          </div>
        </div>
        <br><br>
        <ul class="list-group">
          <li class="list-group-item" ng-repeat="notificacion in notificaciones | filter : {nosa_notificacion : searchtext}">
            <div class="row">
              <div class="col-sm-5">
                @{{notificacion.nosa_nombre}}
              </div>
              <div class="col-sm-2">
                @{{notificacion.nosa_notificacion}}
              </div>
              <div class="col-sm-2">
                @{{notificacion.nosa_fecha_inicio}}
              </div>
              <div class="col-sm-2">
                @{{notificacion.nosa_fecha_vencimiento}}
              </div>
              <div class="col-sm-1 text-right">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" ng-click="edit(notificacion.id)">
                  <i class="glyphicon glyphicon-pencil"></i> Editar
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    @include('layouts.pricat.notificacionsanitaria.createNotificacionesSanitarias')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/notificacionsanitariaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
