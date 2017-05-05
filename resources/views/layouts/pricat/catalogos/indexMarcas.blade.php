@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="marcasCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setMarca()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br><br>
        <ul class="list-group">
          <li class="list-group-item" ng-repeat="(marca, info) in marcas">
            <div class="row">
              <div class="col-sm-3">
                @{{marca}}
              </div>
              <div class="col-sm-5">
                <ul class="list-group">
                  <li class="list-group-item" ng-repeat="linea in info">
                    <div class="row">
                      <div class="col-sm-8">
                        @{{linea.descripcionItemCriterioMayor}}
                      </div>
                      <div class="col-sm-4 text-right">
                        <button class="btn btn-danger btn-sm" ng-click="deleteLinea($event, info.idItemCriterioMayor)">
                          <i class="glyphicon glyphicon-trash"></i>
                        </button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-sm-4 text-right">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" ng-click="editMarca(marca)">
                  <i class="glyphicon glyphicon-pencil"></i> Editar
                </button>
                <button class="btn btn-danger btn-sm" ng-click="deleteMarca($event, marca)">
                  <i class="glyphicon glyphicon-trash"></i> Borrar
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createMarcas')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/marcasCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
