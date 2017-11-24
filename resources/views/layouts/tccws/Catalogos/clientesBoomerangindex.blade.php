@extends('app') 

@section('content')
  @include('includes.titulo')

  <div ng-controller="clientesBoomerangCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="panel-group">

          







        <button type="button" class="btn btn-success btn-sm">
          <i class="glyphicon glyphicon-plus"></i> Agregar
        </button><br>
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
        <tr ng-repeat="parametro in parametros"> 
          <td class="text-left">Dato</td>
          <td class="text-left">Prueba</td>
          <td class="text-right">
            <button type="button" class="btn btn-warning btn-sm">
              <i class="glyphicon glyphicon-edit"></i>
              <md-tooltip>Editar
            </button>
            <button type="button" class="btn btn-danger btn-sm" >
              <i class="glyphicon glyphicon-trash"></i>
              <md-tooltip>Eliminar
            </button>
          </td>
        </tr>
        </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection


@push('script_angularjs')
<script src="{{url('/js/tccws/clientesBoomerangCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush