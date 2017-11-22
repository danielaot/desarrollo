@extends('app')

@section('content')
	@include('includes.titulo')

	<div ng-controller="parametrosCtrl" ng-cloak>
		<div class="panel panel-default">
			<div class="panel-body">
				<button type="button" class="btn btn-success btn-sm">
          <i class="glyphicon glyphicon-plus"></i> Crear
          <md-tooltip>Agregar
        </button><br>
        <table class="row-border hover">
        <thead>
        <tr>
					<th>Nombre</th>
					<th>Valor</th>
					<th></th>
				</tr>
        </thead>
      	<tbody>
      	<tr>
      		<td class="text-center">Prueba</td>
      		<td class="text-center">Dato</td>
    			<td class="text-right">
        		<button type="button" class="btn btn-warning btn-sm">
              <i class="glyphicon glyphicon-edit"></i>
            	<md-tooltip>Editar
          	</button>
         		<button type="button" class="btn btn-danger btn-sm">
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
<script src="{{url('/js/tccws/parametrosCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
