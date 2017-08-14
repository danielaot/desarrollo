@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="notificacionsanitariaCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="set()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Notificación</th>
              <th>Inicio</th>
              <th>Fin</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="notificacion in notificaciones">
              <td>@{{notificacion.nosa_nombre}}</td>
              <td>@{{notificacion.nosa_notificacion}}</td>
              <td>@{{notificacion.nosa_fecha_inicio | date : 'dd/MM/yy'}}</td>
              <td>@{{notificacion.nosa_fecha_vencimiento | date : 'dd/MM/yy'}}</td>
              <td class="text-center">
                <button type="button" class="btn btn-info btn-sm" ng-if="notificacion.nosa_documento">
                  <i class="glyphicon glyphicon-eye-open"></i>
                </button>
              </td>
              <td class="text-right">
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="edit(notificacion.id)">
                  <i class="glyphicon glyphicon-edit"></i> Editar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @include('layouts.pricat.notificacionsanitaria.createNotificacionesSanitarias')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/notificacionsanitariaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
