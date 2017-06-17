@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="criteriosCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="setCriterio()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br><br>
        <ul class="list-group">
          <li class="list-group-item" ng-repeat="criterio in criterios">
            <div class="row">
              <div class="col-sm-4">
                <label class="control-label">@{{criterio.planes.nombreCriterioPlan}}</label>
              </div>
              <div class="col-sm-3">
                <span>@{{criterio.cri_col_unoe}}</span>
              </div>
              <div class="col-sm-1">
                <span ng-if="criterio.cri_regular">Regular</span>
              </div>
              <div class="col-sm-1">
                <span ng-if="criterio.cri_estuche">Estuche</span>
              </div>
              <div class="col-sm-1">
                <span ng-if="criterio.cri_oferta">Oferta</span>
              </div>
              <div class="col-sm-2 text-right">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal1" ng-click="editCriterio(criterio.id)">
                  <i class="glyphicon glyphicon-pencil"></i> Editar
                </button>
                <!--button class="btn btn-danger btn-sm" ng-click="deleteProyecto($event, proyecto.id)">
                  <i class="glyphicon glyphicon-trash"></i> Borrar
                </button-->
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createCriteriosItem')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/criteriosItemCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
