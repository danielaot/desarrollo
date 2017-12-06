@extends('app')

@section('content')
@include('includes.titulo')

<div ng-controller="consultaRemesasCtrl" ng-cloak class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
	<div class="panel panel-default">
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
      				<tr ng-repeat="consulta in consultas"> 
      				<td class="text-left">@{{consulta.consulta.rms_remesa}}</td>
      				<td class="text-left">@{{consulta.fxr_tipodocto}}-@{{consulta.fxr_numerodocto}}</td>
      				<td class="text-left">@{{cambiaFecha(consulta.consulta.created_at)}}</td>
    				<td class="text-right">
        				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal" ng-click="setFactura(consulta)">
              			<i class="glyphicon glyphicon-eye-open"></i>
          				</button>
          			</td>
    				</tr>
    			</tbody>
    		</table>
		</div>
	</div>
	@include('layouts.tccws.Catalogos.consultaDeRemesasDetalle')
</div>

@endsection


@push('script_angularjs')
<script src="{{url('/js/tccws/consultaRemesasCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
