@extends('app')

@section('content')
@include('includes.titulo')
<style>
	.scroll-panel-obsvr{
		max-height: 55vh;
		height: 55vh;
		overflow-y: scroll;
	}
	.elementOfList{
		  height: 8vh !important;
	}
	.md-subheader .md-subheader-inner {
		background-color: #eceeef;
		color:#337ab7;
	}
	md-toolbar.md-default-theme:not(.md-menu-toolbar), md-toolbar:not(.md-menu-toolbar) {
		background-color: #337ab7;
	}
	.modal-footer2 {
	  border-top: 0px solid #e5e5e5;
		padding: 0px;
	}
	.panel-default>.panel-heading2 {
    background-color: transparent !important;
	}
	.md-list-item-text {
		margin-top: 10px !important;
	}
	md-list-item.md-3-line, md-list-item.md-3-line>.md-no-style{
		height: 40px;
		min-height: 3px;
	}
	.content-pane {
    padding: 15px;
    height: 100vh;
    min-height: 100vh;
    overflow-y: auto;
	}
</style>

<div class="container-fluid">
	<div ng-controller="pedidosAgrupaCtrl as ctrl"  layout="column" flex layout-fill ng-cloak>
<<<<<<< HEAD
		<div class="panel panel-default">
			<div class="panel-heading panel-heading2">
				<div class="modal-footer modal-footer2">
					<button type="button" ng-click="getUnidadesLogisticas()" ng-disabled="!puedeEnviar" class="btn btn-danger">Excluir Facturas</button>
					<button type="button" ng-click="getUnidadesLogisticas()" data-toggle="modal" data-target="#modal" ng-disabled="!puedeEnviar" name="button" class="btn btn-success">Generar Remesa(s)</button>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-6 col-lg-6 col-xl-6 col-sm-6">
						<div class="form-group">
							<label>Seleccionar cliente:</label>
							<md-select ng-model="cliente" ng-change="onChangeClienteSelected()" placeholder="Seleccione un cliente">
								<md-optgroup label="Clientes">
									<md-option ng-value="cliente" ng-repeat="cliente in terceros | filter:searchTerm">@{{cliente.razonSocialTercero}}
									</md-option>
								</md-optgroup>
							</md-select>
=======


				<div class="panel panel-default">
					<div class="panel-heading panel-heading2">
						<div class="modal-footer modal-footer2">
								<button type="button" ng-click="excluirFacturas()" ng-disabled="!puedeEnviar" class="btn btn-danger">Excluir Facturas</button>
								<button type="button" ng-click="getUnidadesLogisticas()" data-toggle="modal" data-target="#modal" ng-disabled="!puedeEnviar" name="button" class="btn btn-success">Generar Remesa(s)</button>
>>>>>>> 7bc09394f8e4ad266d6c391ff6e1ddbfe6438b20
						</div>
					</div>
					<div class="col-xs-6 col-md-6 col-lg-6 col-xl-6 col-sm-6">
						<div class="form-group">
							<label>Seleccionar sucursal:</label>
							<md-select ng-model="cliente.sucursales" ng-disabled = "cliente == undefined" ng-change= "onChangeSucursales()" placeholder="Seleccione una o mas sucursales" multiple>
								<md-optgroup label="Sucursales">
									<md-option ng-value="sucu" ng-repeat="sucu in  getSucursales() | filter:searchTerm">@{{sucu.nombre}}
									</md-option>
								</md-optgroup>
							</md-select>
						</div>
					</div>
				</div>
				<div class="row content-pane">
					<div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
						<div class="panel-group" ng-if="cliente.sucursales != undefined && cliente.sucursales.length > 0">
							<div class="panel panel-default" ng-repeat="(key, sucursal) in cliente.sucursales ">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" href="#collapse@{{key}}"> @{{sucursal.nombre}} 
										</a>
										<div class="pull-right">
											<md-checkbox ng-change="setSelectAllFacts(sucursal)" ng-model="sucursal.isSelectAll" aria-label="SelectAll">
												<strong>(@{{("0"+sucursal.cantSeleccionadas).slice(-2)}} / @{{sucursal.facturas.length}})
												</strong>
											</md-checkbox>
										</div>
									</h4>
								</div>
								<div id="collapse@{{key}}" class="panel-collapse collapse">
									<div class="panel-body">
										<div class="panel-group" ng-if="sucursal.facturas != undefined && sucursal.facturas.length > 0">
											<div class="panel panel-default elementOfList" ng-repeat="factura in sucursal.facturas">
												<div class="panel-body">
													<md-checkbox ng-model="factura.isSelect" ng-change="setSelectedFactura(factura,sucursal)" aria-label="SelectOne">@{{factura.num_factura}}
													</md-checkbox>
												</div>
											</div>
										</div>
										<div class="panel panel-default" ng-if="sucursal.facturas == undefined || sucursal.facturas.length == 0">
											<div class="panel-body">
												<center><h4>No hay facturas para esta sucursal</h4></center>
											</div>
										</div>
									</div>
								</div>
							</div>
<<<<<<< HEAD
=======


						</div>

					</div>
					<div class="panel-footer">
						<div class="modal-footer modal-footer2">
								<button type="button" ng-click="excluirFacturas()" ng-disabled="!puedeEnviar" class="btn btn-danger">Excluir Facturas</button>
								<button type="button" ng-click="getUnidadesLogisticas()" data-toggle="modal" data-target="#modal" ng-disabled="!puedeEnviar" name="button" class="btn btn-success">Generar Remesa(s)</button>
>>>>>>> 7bc09394f8e4ad266d6c391ff6e1ddbfe6438b20
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="modal-footer modal-footer2">
					<button type="button" ng-click="getUnidadesLogisticas()" ng-disabled="!puedeEnviar" class="btn btn-danger">Excluir Facturas</button>
					<button type="button" ng-click="getUnidadesLogisticas()" data-toggle="modal" data-target="#modal" ng-disabled="!puedeEnviar" name="button" class="btn btn-success">Generar Remesa(s)</button>
				</div>
			</div>
		</div>
	  	@include('layouts.tccws.Modales.unidadesLogisticas');
		<div ng-if="progress" class="progress">
			<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
		</div>
	</div>
</div>
@endsection

@push('script_angularjs')
<script src="{{url('/js/tccws/pedidosAgrupaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
