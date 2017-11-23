@extends('app')

@section('content')
	@include('includes.titulo')

	<div ng-controller="parametrosCtrl" ng-cloak>
		<div class="panel panel-default">
			<div class="panel-body">
				<button type="button" class="btn btn-success btn-sm" ng-click="resetForm()" data-toggle="modal" data-target="#modal">
          <i class="glyphicon glyphicon-plus"></i> Crear
          <md-tooltip>Agregar
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
        <thead>
        <tr>
					<th>Nombre</th>
					<th>Valor</th>
					<th></th>
				</tr>
        </thead>
      	<tbody>
      	<tr ng-repeat="parametro in parametros">
          <!---->
      		<td class="text-center">@{{parametro.par_campoTcc}}</td>
      		<td class="text-center">@{{parametro.par_valor}}</td>
    			<td class="text-right">
        		<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editarParametro(parametro)">
              <i class="glyphicon glyphicon-edit"></i>
            	<md-tooltip>Editar
          	</button>
         		<button type="button" class="btn btn-danger btn-sm" ng-disabled="isDelete = true" ng-click="eliminarParametro(parametro)">
          		<i class="glyphicon glyphicon-trash"></i>
          		<md-tooltip>Eliminar
        		</button>
      		</td>
    		</tr>
    		</tbody>
    		</table>
			</div>
		</div>
    @include('layouts.tccws.parametrosCreate')
	</div>
@endsection

@push('script_angularjs')
<script src="{{url('/js/tccws/parametrosCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
