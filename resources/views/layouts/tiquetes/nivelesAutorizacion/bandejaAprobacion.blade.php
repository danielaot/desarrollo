@extends('app')

@section('content')
  @include('includes.titulo')
  <link rel="stylesheet" type="text/css" href="{{url('/css/tiqueteshotel/misSolicitudes.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('/css/timeline.css')}}">
   <div ng-controller="bandejaAprobacionCtrl" ng-cloak class="cold-md-12">
      <div class="container-fluid">
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th class="text-center">No.</th>
              <th class="text-center">Cedula Solicitante</th>
              <th class="text-center">Nombre Solicitante</th>
              <th class="text-center">Fecha Solicitud</th>
              <th class="text-center">Estado Solicitud</th>
              <th class="text-center">Ver</th>
              <th class="text-center">Aprobar</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="sol in solipernivel">
              <td class="text-center">@{{sol.sni_idsolicitud}}</td>
              <td class="text-center">@{{sol.detallesolicitud.solTxtCedtercero}}</td>
              <td class="text-center">@{{sol.detallesolicitud.solTxtNomtercero}}</td>
              <td class="text-center">@{{(sol.detallesolicitud.solIntFecha) * (1000) | date:'dd-MM-yyyy'}}</td>
              <td class="text-center">@{{sol.detallesolicitud.estados.estTxtNombre}}</td>
              <td class="text-right">
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modalinfo" ng-click="infosolicitud(sol)">
                  <i class="glyphicon glyphicon-eye-open"></i>
                  <md-tooltip>Ver
                  </button>
              </td>
              <td class="text-right">
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal1" ng-click="aprosolicitud(sol)">
                  <i class="glyphicon glyphicon-ok"></i>
                  <md-tooltip>Aprobar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        @include('layouts.tiquetes.nivelesAutorizacion.aprobSolicitud')
      </div>
      @include('layouts.tiquetes.solicitud.infoSolicitudesDet')
    </div>
@endsection

@push('script_angularjs')
  <script src="{{url('js/tiquetes/bandejaAprobacionCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
