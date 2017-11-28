@extends('app') 

@section('content')
  @include('includes.titulo')

  <div ng-controller="clientesBoomerangCtrl" ng-cloak class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="panel-group">
          <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">             
              <md-chips ng-model="clientesSelected" md-autocomplete-snap
              md-transform-chip="transformChip($chip)"
              md-require-match="autocompleteDemoRequireMatch">
                <md-autocomplete
                md-selected-item="selectedTercero"
                md-search-text="searchText"
                md-items="tercero in buscarTercero(searchText) | orderBy:'razonSocialTercero'"
                md-no-cache="true"
                md-item-text="tercero.razonSocialTercero"
                placeholder="Buscar clientes">
                  <span md-highlight-text="searchText">@{{tercero.razonSocialTercero}}</span>
                </md-autocomplete>
                <md-chip-template>
                  <span>
                    <strong>@{{$chip.razonSocialTercero}} (@{{$chip.idTercero}})</strong>
                  </span>
              </md-chips>
              </md-chip-template>
              <button type="button" class="btn btn-success btn-sm" ng-disabled="clientesSelected.length == 0" style="margin-top: 15px" ng-click="agregarCliente()">
              <i class="glyphicon glyphicon-plus"></i> Guardar
              </button>
            </div>
          </div>
        </div>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
        <thead>
        <tr>
          <th class="text-center">Nombre del Cliente</th>
          <th class="text-center">Nit del Cliente</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="clientea in clientesAgregados"> 
          <td class="text-left">@{{clientea.tercero.razonSocialTercero}}</td>
          <td class="text-left">@{{clientea.clb_idTercero}}</td>
          <td class="text-right">
            <button type="button" class="btn btn-danger btn-sm" ng-click="eliminar(clientea)">
              <i class="glyphicon glyphicon-remove"></i>
              <md-tooltip>Eliminar
            </button>
          </td>
        </tr>
        </tbody>
        </table>
      </div>
    </div>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection


@push('script_angularjs')
<script src="{{url('/js/tccws/clientesBoomerangCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush