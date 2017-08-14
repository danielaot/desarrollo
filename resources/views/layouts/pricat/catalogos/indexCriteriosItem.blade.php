@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="criteriosCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setCriterio()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th>Criterio</th>
              <th>Columna UnoE</th>
              <th>Regular</th>
              <th>Estuche</th>
              <th>Oferta</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="criterio in criterios">
              <td>@{{criterio.planes.nombreCriterioPlan}}</td>
              <td>@{{criterio.cri_col_unoe}}</td>
              <td class="text-center"><span ng-if="criterio.cri_regular">X</span></td>
              <td class="text-center"><span ng-if="criterio.cri_estuche">X</span></td>
              <td class="text-center"><span ng-if="criterio.cri_oferta">X</span></td>
              <td class="text-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editCriterio(criterio.id)">
                  <i class="glyphicon glyphicon-edit"></i> Editar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createCriteriosItem')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/criteriosItemCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
