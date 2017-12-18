@extends('app')
@section('content')
@include('includes.titulo')

<div ng-controller='autorizacionCtrl' ng-cloak class="col-md-12">

  <md-content class="md-padding">

    <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
      <thead>
        <tr>
          <td class="text-center">No. Solicitud</td>
          <td class="text-center">Tipo de Solicitud</td>
          <td class="text-center">Usuario</td>
          <td class="text-center">Fecha de Solicitud</td>
          <td class="text-center">Costo Total</td>
          <td class="text-center">Ver</td>
          <td class="text-center">Aprobar</td>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="solicitud in solicitudes">
          <td>@{{solicitud.solicitud.sci_id}}</td>
          <td>@{{solicitud.solicitud.tipo_salida.tsd_descripcion}}</td>
          <td>@{{solicitud.solicitud.tpernivel.pern_nombre}}</td>
          <td>@{{solicitud.solicitud.sci_fecha  | date: 'dd/MM/yyyy'}}</td>
          <td class="text-right">@{{solicitud.solicitud.sci_ventaesperada | currency: "$"}}</td>
          <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(solicitud.solicitud)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
          <td><button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalAprobar" ng-click="setSolicitud(solicitud.solicitud, 1)"><i class="glyphicon glyphicon-check"></i></button></td>
        </tr>
      </tbody>
    </table>

  </md-content>

  @include('layouts.controlinversion.reportesVisuales.mostrarSolicitud')
  @include('layouts.controlinversion.reportesVisuales.modalAprobacionSoli')

<div ng-if="progress" class="progress">
	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
</div>

</div>

@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/autorizacionCtrl.js')}}"></script>
@endpush
