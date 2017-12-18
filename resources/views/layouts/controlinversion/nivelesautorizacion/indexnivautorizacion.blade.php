@extends('app')
@section('content')
@include('includes.titulo')
<div ng-controller="nivelesautorizacionCtrl as ctrl" ng-cloak class="container-fluid">
	<link rel="stylesheet" href="{{url('/css/controlinversion/nivelesAutorizacion.css')}}">
	<md-content>
	<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal"><i class="glyphicon glyphicon-plus"></i>&nbsp;Agregar</button>
		<md-tabs md-dynamic-height md-border-bottom>
			<!-- Tab nivel 4 -->
			<md-tab label="Nivel 4">
				<md-content class="md-padding">
					<table  datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
						<thead>
							<tr>
								<th>Usuario</th>
								<th>Nombre</th>
								<th>No. identificacion</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="nivel in nivelCuatro">
								<td>@{{nivel.pern_usuario}}</td>
								<td>@{{nivel.pern_nombre}}</td>
								<td>@{{nivel.pern_cedula}}</td>
								<td>
									<button  ng-click="inactivar(nivel)" class="btn btn-danger">
										<i class="glyphicon glyphicon-remove"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</md-content>
			</md-tab>
			<!-- End tab nive4 -->
			
			<!-- Tab nivel 3 -->
			<md-tab label="Nivel 3">
				<md-content class="md-padding">
					<table  datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
						<thead>
							<tr>
								<th>Usuario</th>
								<th>Nombre</th>
								<th>No. identificacion</th>
								<th>Jefe Inmediato</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="nivel in nivelTres">
								<td>@{{nivel.pern_usuario}}</td>
								<td>@{{nivel.pern_nombre}}</td>
								<td>@{{nivel.pern_cedula}}</td>
								<td>@{{nivel.children.pern_nombre}}</td>
								<td>
									<button  ng-click="inactivar(nivel)" class="btn btn-danger">
										<i class="glyphicon glyphicon-remove"></i>
									</button>
									<button   data-toggle="modal" data-target="#modal" ng-click="actualizar(nivel)" class="btn btn-warning">
										<i class="glyphicon glyphicon-edit"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</md-content>
			</md-tab>
			<!-- End tab nivel 3 -->
			
			<!-- Tab nivel 2 -->	
			<md-tab label="Nivel 2">
				<md-content class="md-padding">
					<table  datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
						<thead>
							<tr>
								<th>Usuario</th>
								<th>Nombre</th>
								<th>No. identificacion</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="nivel in nivelDos">
								<td>@{{nivel.pern_usuario}}</td>
								<td>@{{nivel.pern_nombre}}</td>
								<td>@{{nivel.pern_cedula}}</td>
								<td>
									<button  ng-click="inactivar(nivel)" class="btn btn-danger">
										<i class="glyphicon glyphicon-remove"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</md-content>
			</md-tab>
			<!-- End tab nivel 2 -->

			<!-- Tab nivel 1 -->
			<md-tab label="Nivel 1">
				<md-content class="md-padding">
					<table  datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
						<thead>
							<tr>
								<th>Usuario</th>
								<th>Nombre</th>
								<th>No. identificacion</th>
								<th>Tipo Persona</th>
								<th>Jefe Inmediato</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="nivel in nivelUno">
								<td>@{{nivel.pern_usuario}}</td>
								<td>@{{nivel.pern_nombre}}</td>
								<td>@{{nivel.pern_cedula}}</td>
								<td>@{{pintarTipoPersona(nivel.pern_tipopersona)}}</td>
								<td>@{{nivel.children.pern_nombre}}</td>
								<td>
									<button  ng-click="inactivar(nivel)" class="btn btn-danger">
										<i class="glyphicon glyphicon-remove"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</md-content>
			</md-tab>
			<!-- End tab nivel 1 -->
		</md-tabs>
	</md-content>
	@include('layouts.controlinversion.nivelesautorizacion.modalcreatepersona')
	<div ng-if="progress" class="progress">
		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>
</div>
@endsection


@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/nivelesautorizacionCtrl.js')}}"></script>
@endpush
