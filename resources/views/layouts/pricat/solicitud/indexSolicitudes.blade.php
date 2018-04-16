@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="missolicitudesCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <table id="tabla" class="display" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th class="text-center">No.</th>
              <th class="text-center">Nit Cliente</th>
              <th class="text-center">Tipo Novedad</th>
              <th class="text-center">Fecha Solicitud</th>
              <th class="text-center">Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($solicitudes as $solicitud)
              <tr>
                <td class="text-center">{{ $solicitud->id }}</td>
                <td>{{ $solicitud->clientes->cli_nit }} - {{ $solicitud->clientes->terceros->razonSocialTercero }}</td>
                <td class="text-center">{{ ucfirst($solicitud->sop_tnovedad) }}</td>
                <td class="text-center">{{ Carbon\Carbon::parse($solicitud->created_at)->format('d/M/Y') }}</td>
                <td class="text-center">{{ ucfirst($solicitud->sop_estado) }}</td>
                <td class="text-center">
                  <button type="button" class="btn btn-info btn-sm">
                    <i class="glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#modal" ng-click="show({{$solicitud->id}})"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @include('layouts.pricat.solicitud.showSolicitud')
    </div>
  </div>
@endsection

@push('script_data_table')
  <script type="text/javascript">
    $(document).ready(function () {
      $("#tabla").DataTable();
    })
  </script>
@endpush

@push('script_angularjs')
  <script src="{{url('/js/pricat/missolicitudesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
