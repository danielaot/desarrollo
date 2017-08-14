@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="responsablesCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setArea()">
          <i class="glyphicon glyphicon-plus-sign"></i> Crear
        </button><br><br>
        <ul class="list-group">
          <li class="list-group-item" ng-repeat="area in areas">
            <div class="row">
              <div class="col-sm-3">
                @{{area.ar_nombre}}
              </div>
              <div class="col-sm-3">
                @{{area.ar_descripcion}}
              </div>
              <div class="col-sm-3">
                <span ng-repeat="responsable in area.responsables">
                  @{{responsable.usuarios.dir_txt_nombre}}
                </span>
              </div>
              <div class="col-sm-3 text-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editArea(area.id)">
                  <i class="glyphicon glyphicon-edit"></i> Editar
                </button>
                <button class="btn btn-danger btn-sm" ng-click="deleteArea($event, area.id)">
                  <i class="glyphicon glyphicon-trash"></i> Borrar
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createResponsables')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/responsablesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
