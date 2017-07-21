@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="clientesCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setCliente()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br><br>
        <ul class="list-group">
          <li class="list-group-item" ng-repeat="cliente in clientes">
            <div class="row">
              <div class="col-sm-3">
                <label class="control-label">@{{cliente.cli_nit}}</label>
              </div>
              <div class="col-sm-1">
                <span ng-if="cliente.cli_codificacion">Codificación</span>
              </div>
              <div class="col-sm-1">
                <span ng-if="cliente.cli_modificacion">Modificación</span>
              </div>
              <div class="col-sm-1">
                <span ng-if="cliente.cli_eliminacion">Eliminación</span>
              </div>
              <div class="col-sm-2">
                <span>@{{cliente.cli_kam}}</span>
              </div>
              <div class="col-sm-2">
                <span>@{{cliente.cli_gln}}</span>
              </div>
              <div class="col-sm-2 text-right">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" ng-click="editCliente(cliente.id)">
                  <i class="glyphicon glyphicon-pencil"></i> Editar
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createClientes')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/clientesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
