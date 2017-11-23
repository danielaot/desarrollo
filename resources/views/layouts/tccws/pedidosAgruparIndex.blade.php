@extends('app')

@section('content')
@include('includes.titulo')
<style>

	.btn-success{
		margin-top: 20px;
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

	.md-list-item-text {
		margin-top: 10px !important;
	}

	md-list-item.md-3-line, md-list-item.md-3-line>.md-no-style{
		height: 40px;
		min-height: 3px;
	}
</style>
<div class="container-fluid">
	<div ng-controller="pedidosAgrupaCtrl as ctrl"  layout="column" flex layout-fill ng-cloak>
		<form id="frmRemesa" name="frmRemesa" ng-submit="frmRemesa.$valid && enviarRemesa()" >

				<div class="panel panel-default">
					<div class="panel-body">

							<div class="row">

								<div class="col-sm-12">
									<div class="form-group">
										<label>Seleccionar cliente:</label>
										<select ng-model="cliente" class="form-control" ng-options="ter.razonSocialTercero for ter in terceros track by ter.idTercero">
											<option value="">Seleccione...</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row">

								<div ng-if="cliente != undefined" class="col-xs-6 col-md-6 col-lg-6 col-xl-6 col-sm-6">

									<div class="form-group">


										<label>Seleccionar sucursal:</label>
										<md-select ng-model="cliente.sucursales"
										ng-change= "onChangeSucursales()"
										placeholder="Seleccione una o mas sucursales"
										multiple>
										<md-optgroup label="Sucursales">
											<md-option ng-value="sucu" ng-repeat="sucu in  getSucursales() |
											filter:searchTerm">@{{sucu.nombre}}</md-option>
										</md-optgroup>
									</md-select>

								</div>

							</div>

						</div>

						<div class="row">
							<div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">

								<div class="panel-group" ng-if="cliente.sucursales != undefined && cliente.sucursales.length > 0">
									<div class="panel panel-default" ng-repeat="(key, sucursal) in cliente.sucursales ">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#collapse@{{key}}"> @{{sucursal.nombre}} </a>
												<div class="pull-right">
													<md-checkbox ng-change="setSelectAllFacts(sucursal)" ng-model="sucursal.isSelectAll" aria-label="SelectAll"><strong>(@{{("0"+sucursal.cantSeleccionadas).slice(-2)}} / @{{sucursal.facturas.length}})</strong></md-checkbox>
												</div>
											</h4>



										</div>
										<div id="collapse@{{key}}" class="panel-collapse collapse">
											<div class="panel-body">

												<div class="panel-group" ng-if="sucursal.facturas != undefined && sucursal.facturas.length > 0">

													<div class="panel panel-default elementOfList" ng-repeat="factura in sucursal.facturas">
														<div class="panel-body">
															<md-checkbox ng-model="factura.isSelect" ng-change="setSelectedFactura(factura,sucursal)" aria-label="SelectOne">@{{factura.num_factura}}</md-checkbox>
														</div>
													</div>

												</div>

												<div class="panel panel-default" ng-if="sucursal.facturas == undefined || sucursal.facturas.length == 0">
													<div class="panel-body">
														<center><h4>No hay facturas para esta sucursal</h4></center>
													</div>
												</div>

											</div>
											<!-- <div class="panel-footer">Panel Footer</div> -->
										</div>
									</div>

								</div>

							</div>


						</div>

						<div class="row" ng-if="cliente.sucursales != undefined && cliente.sucursales.length > 0">

							<div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">

								<div class="form-group">
									<div class="pull-right">
										<button type="submit" ng-disabled="!puedeEnviar" name="button" class="btn btn-success">Generar Remesas</button>
									</div>
								</div>

							</div>

						</div>

					</div>
				</div>

		</form>
	<!-- @{{agrupoCliente[cliente.idTercero]}} -->
<!--
	<md-toolbar md-scroll-shrink>
	    <div class="md-toolbar-tools">Pendientes envio TCC</div>
	  </md-toolbar>

	  <md-content style="height: 600px;" md-theme="altTheme">

	    <section  ng-repeat="clien in retornaListaFiltrada()">
	      <md-subheader class="md-primary"><strong>@{{clien.nom_tercero}}</strong></md-subheader>
	      <md-list layout-padding>
	        <md-list-item class="md-3-line" ng-repeat="fact in clien">
	            <div class="md-list-item-text" style="margin-top: 10px;">
	              <p>
	              @{{fact.tipo_docto}} - @{{fact.num_consecutivo}}
	              </p>
	            </div>
	        </md-list-item>
	      </md-list>
	    </section>

	  </md-content> -->
		<div ng-if="progress" class="progress">
			<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
		</div>

	</div>
</div>
@endsection


@push('script_angularjs')
<script src="{{url('/js/tccws/pedidosAgrupaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
