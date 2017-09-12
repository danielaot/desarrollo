@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="responsablesCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setArea()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Responsables</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="area in areas">
              <td>@{{area.ar_nombre}}</td>
              <td>@{{area.ar_descripcion}}</td>
              <td>
                <span ng-repeat="responsable in area.responsables">
                  @{{responsable.usuarios.dir_txt_nombre}}<br>
                </span>
              </td>
              <td class="text-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editArea(area.id)">
                  <i class="glyphicon glyphicon-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm" ng-click="deleteArea($event, area.id)">
                  <i class="glyphicon glyphicon-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createResponsables')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/responsablesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
