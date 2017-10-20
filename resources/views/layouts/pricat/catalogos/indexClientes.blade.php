@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="clientesCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setCliente()">
          <i class="glyphicon glyphicon-plus"></i> Crear
          <md-tooltip md-direction="top">Crear cliente</md-tooltip>
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
              <td>@{{cliente.cli_nit}} - @{{cliente.terceros.razonSocialTercero}}</td>
              <td class="text-center"><span ng-if="cliente.cli_codificacion">X</span></td>
              <td class="text-center"><span ng-if="cliente.cli_modificacion">X</span></td>
              <td class="text-center"><span ng-if="cliente.cli_eliminacion">X</span></td>
              <td class="text-center">@{{cliente.cli_kam}}</td>
              <td class="text-center">@{{cliente.cli_gln}}</td>
              <td class="text-right">
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editCliente(cliente)">
                  <i class="glyphicon glyphicon-edit"></i>
                  <md-tooltip md-direction="left">Actualizar @{{cliente.terceros.razonSocialTercero}}</md-tooltip>
                </button>
                <button ng-if="cliente.deleted_at == NULL" type="button" class="btn btn-danger btn-sm" ng-click="inactivarCliente(cliente)">
                  <i class="glyphicon glyphicon-trash"></i>
                  <md-tooltip md-direction="left">Inactivar @{{cliente.terceros.razonSocialTercero}}</md-tooltip>
                </button>
                <button ng-if="cliente.deleted_at != NULL" type="button" class="btn btn-success btn-sm" ng-click="inactivarCliente(cliente)">
                  <i class="glyphicon glyphicon-ok"></i>
                  <md-tooltip md-direction="left">Activar @{{cliente.terceros.razonSocialTercero}}</md-tooltip>
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
