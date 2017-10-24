@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="proyectosCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="setProyecto()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Proceso</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="proyecto in proyectos">
              <td>@{{proyecto.proy_nombre}}</td>
              <td>@{{proyecto.procesos.pro_nombre}}</td>
              <td>@{{proyecto.proy_estado}}</td>
              <td class="text-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal1" ng-click="editProyecto(proyecto)">
                  <i class="glyphicon glyphicon-edit"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createProyectos')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/proyectosCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
