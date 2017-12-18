@extends('app')

@section('content')
  @include('includes.titulo')
    <div ng-controller="vendedorCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setVendedor()">
          <i class="glyphicon glyphicon-plus"></i> Crear Nuevos Vendedores
        </button><br><br>

          <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
            <thead>
              <tr>
                <th>Nit Vendedor</th>
                <th>Nombre Vendedor</th>
                <th>Zona de Vendedor</th>
                <th>Sub-Zona de Vendedor</th>
                <th>Gerente de Zona</th>
                <th>Dir. Territoro</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="vendedor in vendedoresZona">

                <td>@{{vendedor.NitVendedor}}</td>
                <td>@{{vendedor.NomVendedor}}</td>
                <td>@{{vendedor.NomZona}}</td>
                <td>@{{vendedor.NomSubZona}}</td>
                <td>@{{vendedor.ger_zona}}</td>
                <td>@{{vendedor.dir_territorio}}</td>

                <td class="text-center">
                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="inhabilitarVendedor(vendedor)">
                    <i class="glyphicon glyphicon-pencil"></i>
                  </button>
                </td>


              </tr>
            </tbody>
          </table>

      </div>
    </div>
    @include('layouts.controlinversion.vendedores.createVendedores')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>

@endsection

@push('script_angularjs')
  <script src="{{url('/js/controlinversion/vendedores/vendedorCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
