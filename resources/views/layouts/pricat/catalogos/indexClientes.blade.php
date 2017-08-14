@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="clientesCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setCliente()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th>Nit Cliente</th>
              <th>Codificación</th>
              <th>Modificación</th>
              <th>Eliminación</th>
              <th>KAM</th>
              <th>GLN</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="cliente in clientes">
              <td>@{{cliente.cli_nit}}</td>
              <td class="text-center"><span ng-if="cliente.cli_codificacion">X</span></td>
              <td class="text-center"><span ng-if="cliente.cli_modificacion">X</span></td>
              <td class="text-center"><span ng-if="cliente.cli_eliminacion">X</span></td>
              <td>@{{cliente.cli_kam}}</td>
              <td>@{{cliente.cli_gln}}</td>
              <td class="text-right">
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editCliente(cliente.id)">
                  <i class="glyphicon glyphicon-edit"></i> Editar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createClientes')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/clientesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
