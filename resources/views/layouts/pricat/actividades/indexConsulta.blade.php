@extends('app')

@section('content')
  @include('includes.titulo')

  <div ng-controller="consultaCtrl" ng-cloak>
    <form name="consultaForm" ng-submit="consultaForm.$valid && consultaReferencia($event)" class="form-horizontal" novalidate>
      <div class="panel-default">
        <hr>
        <div class="row">
          <label class="col-sm-1 control-label">Referencia:</label>
          <div class="col-sm-6">
            <md-chips ng-model="consultaref" md-autocomplete-snap
               md-transform-chip="transformChip($chip)"
               md-on-add="onAddReferencia($chip)"
               md-on-remove="onRemoveReferencia($chip)"
               md-require-match="autocompleteDemoRequireMatch">
               <md-autocomplete md-search-text="referenciasSearchText"
                               md-items="referencia in referenciasSearch(referenciasSearchText)"
                               md-item-text="referencia.ite_referencia"
                               md-no-cache="true"
                               md-min-length="0">
                  <md-item-template>
                    <span md-highlight-text="referenciasSearchText">@{{referencia.ite_referencia}}</span>
                  </md-item-template>
                </md-autocomplete>
              <md-chip-template>
                <span>@{{$chip.ite_referencia}}</span>
             </md-chip-template>
           </md-chips>
          </div>
          <button type="submit" class="btn btn-primary">Consultar</button>
          <button type="button" class="btn btn-success" ng-click="generarExcel()">Generar Excel</button>
        </div>
        <hr>
        <div class="form-group">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Referencia</th>
                <th>Línea</th>
                <th>Registro Sanitario</th>
                <th></th>
              </tr>
            </thead>
            <tbody ng-if="ref !== undefined">
              <tr ng-repeat ="referencia in ref">
                <td>@{{referencia.ite_referencia}} - @{{referencia.detalles.ide_descompleta}}</td>
                <td>@{{referencia.detalles.linea.descripcionItemCriterioMayor}}</td>
                <td>@{{referencia.detalles.notificacionsanitaria.nosa_notificacion}}</td>
                <td>
                  <button type="button" class="btn btn-info btn-sm glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#modal1" ng-click="setReferencia(referencia)"></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
      @include('layouts.pricat.actividades.detalleReferencia')
  </div>
@endsection

@push('script_data_table')
  <script src="{{url('/js/pricat/consultaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
