@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="notiactividadCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setNotificacion()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th>Actividad</th>
              <th>Responsables</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="notificaciones in notificacion">
              <td>@{{notificaciones.act_titulo}}</td>
              <td><span ng-repeat="responsable in notificaciones.notiactividad">
                @{{[responsable.usuarios.dir_txt_cedula,responsable.usuarios.dir_txt_nombre].join(' - ')}}<br>
              </span></td>
              <td class="text-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editNotificacion(notificaciones)">
                  <i class="glyphicon glyphicon-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm" ng-click="deleteNotificacion($event, notificacion.id)">
                  <i class="glyphicon glyphicon-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createNotiactividad')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/notiactividadCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
