@extends('app')

@section('content')
@include('includes.titulo')

<div ng-controller="consultaRemesasCtrl" ng-cloak class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
	<div class="panel panel-default">
    <br>
    <div class="panel-head">
      <div class="col-md-12">
        <div class="col-md-4">
          <label>Busqueda por factura/remesa</label>
          <input class="form-control">
        </div>
        <div class="col-md-4">
          <label>Busqueda por fecha</label>
          <input class="form-control">
        </div>
      </div>
    </div>
		<div class="panel-body">
			<table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
        <thead>
        	<tr>
					  <th class="text-center">Número de Remesa</th>
 					  <th class="text-center">Factura</th>
					  <th class="text-center">Fecha</th>
          	<th></th>
					</tr>
       	</thead>
      	<tbody>
      		<tr ng-repeat="(key, value) in consultas | groupBy : 'consulta.rms_remesa'"> 
            <td>@{{ key }} @{{ imprimir(key) }}</td>
            <td>
              @{{ retornarCadena(value[0].consulta.facturas) }}
            </td>
      		  <td class="text-left">@{{value[0].consulta.created_at | date: 'shortDate'}}</td>
    		    <td class="text-right">
        		  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal" ng-click="setFactura(value[0])">
                <i class="glyphicon glyphicon-eye-open"></i>
         			</button>
            </td>
    			</tr>
    		</tbody>
    	</table>
		</div>
	</div>
	@include('layouts.tccws.Catalogos.consultaDeRemesasDetalle')
  <div ng-if="progress" class="progress">
    <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
  </div>
</div>

@endsection


@push('script_angularjs')
<script src="{{url('/js/tccws/consultaRemesasCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
