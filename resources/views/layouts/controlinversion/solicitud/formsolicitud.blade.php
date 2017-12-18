@extends('app')
@section('content')
@include('includes.titulo')
<style media="screen">
	md-select {
		margin-top:  5px !important;
	}
	.layout-column {
	  -webkit-box-orient: horizontal;
	  flex-direction: column !important;
		display: -webkit-inline-box;
	}
	md-checkbox:last-of-type {
    padding-right: 15px !important;
	}
	checkbox-enabled[selected] .md-icon {
    background-color: rgba(33,150,243,0.87) !important;
	}
	md-checkbox.md-checked .md-icon {
    background-color: rgba(33,150,243,0.87) !important;
	}
	md-checkbox.md-default-theme.md-checked .md-ink-ripple, md-checkbox.md-checked .md-ink-ripple {
	    color: rgba(33,150,243,0.87) !important;
	}
	md-checkbox.md-default-theme.md-checked .md-icon:after, md-checkbox.md-checked .md-icon:after {
    border-color: rgba(255,255,255,0.87);
	}
	md-checkbox .md-label {
    color: #3ea4f5;
	}
	.layout-wrap {
    padding-top: 4px !important;
	}
</style>
@if(isset($solicitud))
<div ng-controller='solicitudCtrl as ctrl' ng-cloak class="col-md-12" ng-init="inicializacion={{$solicitud}};getInfo();">
	@else
	<div ng-controller='solicitudCtrl as ctrl' ng-cloak class="col-md-12" ng-init="getInfo()">
		@endif

		<div class="panel panel-primary">
			<div class="panel-heading">
				Datos de la Solicitud
			</div>
			<form name="solicitudForm" ng-submit="solicitudForm.$valid && saveSolicitud()" novalidate >
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-2">
							<label>Fecha: </label>
							<input class="form-control" type="text" ng-model="solicitud.sci_fecha" disabled></input>
						</div>
					</div>
					<!-- Campo Facturar A -->
					<div class="form-group">
						<label>Facturar a: </label>
						<md-autocomplete
						ng-disabled="hab_ac_facturara"
						md-selected-item="solicitud.facturarA"
						md-search-text="buscar_ac_facturara"
						md-no-cache="true"
						md-item-text="item.tercero.razonSocialTercero"
						md-items="item in qs_facturara(buscar_ac_facturara)"
						md-min-length="1"
						placeholder="Ingrese el número documento de identidad o el nombre de la persona a la cual se le facturará"
						required
						>
						<md-item-template>
							<span md-highlight-text="buscar_ac_facturara" md-highlight-flags="^i">@{{item.fca_idTercero}} - @{{item.tercero.razonSocialTercero}}</span>
						</md-item-template>
						<md-not-found>
							No states matching "@{{buscar_ac_facturara}}" were found.
						</md-not-found>
					</md-autocomplete>
				</div>
				<!-- Campo Tipo de Salida y Motivo de Salida -->
				<div class="row">
					<div class="form-group col-md-6">
						<label>Tipo de Salida: </label>
						<select id="tsd_id" required class='form-control' ng-model='solicitud.tiposalida1' ng-options='opt.tsd_descripcion for opt in tiposalida track by opt.tsd_codigo'>
							<option value=''>Seleccione...</option>
						</select>
						<!-- @{{solicitud.tiposalida1}} -->
					</div>
					<div class="form-group col-md-6">
						<label>Motivo de Salida: </label>
						<select id="mts_id" required class='form-control' ng-model='solicitud.motivoSalida' ng-options='opt.descripcion for opt in motivoSalida track by opt.id'>
							<option value=''>Seleccione...</option>
						</select>
						<!-- @{{solicitud.tiposalida1}} -->
					</div>
				</div>
				<!-- Campo Cargar Gastos A y Linea -->
				<div class="row">
					<div class="form-group col-md-6">
						<label>Cargar Gastos a: </label>
						<select id="cga_id" required class='form-control' ng-model='solicitud.cargagasto1' ng-change="onChangeOpcionCargaGasto()" ng-options='opt2.cga_descripcion for opt2 in cargagasto track by opt2.cga_id'>
							<option value=''>Seleccione...</option>
						</select>
						<!-- @{{solicitud.tipopersona1}} -->
					</div>

					<div class="form-group col-md-6" ng-if="solicitud.cargagasto1.cga_descripcion == 'Linea'">
						<label>Línea: </label>
						<select id="linea_id" required class='form-control' ng-change="onChangeLineaCargaGasto()" ng-model='solicitud.lineas1' ng-options='opt3.lineas_producto.NomLinea for opt3 in lineasproducto track by opt3.lineas_producto.CodLinea'>
							<option value=''>Seleccione...</option>
						</select>
						<!-- @{{solicitud.tipopersona1}} -->
					</div>
				</div>
				<!--Campo canal de solicitud-->

				<div class="row">
					<div class="form-group col-md-6">
						<label>Canal: </label>
						<select id="cnl_id" ng-disabled="(solicitud.cargagasto1.cga_id == 1 && solicitud.lineas1 == undefined) || (solicitud.cargagasto1 == undefined)" required class='form-control' ng-change="onChangeCanal()" ng-model='solicitud.sci_canal' ng-options='opt.can_txt_descrip for opt in canales track by opt.can_id'>
							<option value=''>Seleccione...</option>
						</select>
						<!-- @{{solicitud.tiposalida1}} -->
					</div>
				</div>

				<!-- Campo Observaciones -->
				<div class="form-group">
					<label>Observaciones: </label>
					<textarea id="txtObservacion" class="form-control" ng-model="solicitud.sci_observaciones" cols="50" rows="3"></textarea>
				</div>
				<!-- Campo Tipo Persona -->

				<div class="row">

					<div class="form-group col-md-6">
						<label>Tipo de Persona: </label>
						<select id="tps_id" required class='form-control' ng-model='solicitud.tipopersona1' ng-change="filtrapersona()" ng-options='opt1.tpe_tipopersona == "Vendedor" ? opt1.tpe_tipopersona : "Otros..." for opt1 in tipopersona track by opt1.tpe_id'>
							<option value=''>Seleccione...</option>
						</select>
					</div>

					<div ng-if="solicitud.tipopersona1.tpe_tipopersona == 'Vendedor'" class="form-group col-md-6">

						<label>Zonas: </label>
						<md-select id="zonaSelect" ng-change="onZonaChange()" ng-model="solicitud.zonasSelected"
						aria-label="zonas de vendedores"
						data-md-container-class="selectdemoSelectHeader"
						multiple
						required
						>
						<md-optgroup label="zonas">
							<md-option ng-value="zona" ng-repeat="zona in zonas">@{{zona.descripcion}}</md-option>
						</md-optgroup>
					</md-select>

				</div>

			</div>


			<div ng-if="((solicitud.tipopersona1.tpe_tipopersona == 'Vendedor' && solicitud.zonasSelected.length > 0) || (solicitud.tipopersona1.tpe_tipopersona != 'Vendedor')) && solicitudForm.$valid" class="row">

				<div class="form-group col-md-12" ng-if="solicitud.tipopersona1.tpe_tipopersona == 'Vendedor'">
					<label>Seleccionar Todos Por Zona: </label>
					<br>
					<div layout="row" layout-wrap>
				    <div flex="100" layout="column">
				      <div>
				        <fieldset class="demo-fieldset" >
				          <div layout="column" layout-wrap flex>

										<div class="demo-select-all-checkboxes" flex="100" ng-repeat="zona in solicitud.zonasSelected | orderBy:'id'">
											 <md-checkbox ng-model="zona.isChecked" ng-change="seleccionarVendedoresZona(zona)">
												@{{ zona.descripcion }}
											 </md-checkbox>
										</div>

								 </div>
							 </fieldset>
						 </div>
						</div>
					</div>
			 </div>

				<div class="form-group col-md-12" ng-if="solicitud.tipopersona1.tpe_tipopersona != undefined">
					<label>Despachar a: </label>
					<md-chips ng-model="selectedColaboradores" md-autocomplete-snap
					md-transform-chip="transformChip($chip)"
					md-on-add="onAddColaboradores($chip)"
					md-on-remove="onRemoveColaboradores($chip)"
					md-require-match="autocompleteDemoRequireMatch">
					<md-autocomplete
					md-selected-item="selectedItem"
					md-search-text="colaboradorText"
					md-items="item in onSearchQueryChange(colaboradorText) | map: filtrarVendedorZona | remove: undefined"
					md-item-text="(solicitud.tipopersona1.tpe_id == 1) ? ['Z'+item.scz_zon_id, item.scl_nombre].join(' - ') : [item.scl_cli_id, item.scl_nombre].join(' - ')"
					md-min-length="1"
					md-no-cache="true"
					placeholder="Buscar un/a colaborador/a...">
					<span md-highlight-text="searchText">@{{(solicitud.tipopersona1.tpe_id == 1) ? ['Z'+item.scz_zon_id, item.scl_nombre].join(' - ') : [item.scl_cli_id, item.scl_nombre].join(' - ')}}</span>
				</md-autocomplete>
				<md-chip-template>
					<span>
						@{{(solicitud.tipopersona1.tpe_id == 1) ? ['Z'+$chip.scz_zon_id, $chip.scl_nombre].join(' - ') : [$chip.scl_cli_id, $chip.scl_nombre].join(' - ') }}
					</span>
				</md-chip-template>
			</md-chips>
		</div>
	</div>
	<!-- Tabla - Referencias Sugeridas -->
	<div class="panel panel-primary" ng-if="selectedColaboradores.length > 0">
		<div class="panel-heading" align="center">
			Referencias Sugeridas
		</div>
		<div class="panel-body">

			<div class="row">
				<div class="form-group col-md-12">
					<label style="display:inline-block;">Cargar Referencias:</label>&nbsp
					<div class="input-group" style="display:inline-block;">
						<!-- Esta es la directiva nueva marcillo, ya funciona carga cada fila del excel en un objeto en el controlador de angular -->
						<js-xls onread="read" onerror="error"></js-xls>
						<label for="file"><i class="glyphicon glyphicon-cloud-upload"></i> Subir Archivo</label>
						<!-- end directiva excel -->
					</div>
				</div>
			</div>


			<div class="row">
				<div class="form-group col-md-12">
					<label>Referencia:</label>
					<div class="input-group">
						<md-autocomplete
						md-selected-item = "objeto.referenciaGeneral"
						md-search-text = "searchReferencia"
						md-no-cache = "true"
						md-items = "item in qs_referencia(searchReferencia)"
						md-item-text = "[item.srf_referencia,item.referenciaDescripcion].join(' - ')"
						md-min-length = "1"
						placeholder = "Digite la referencia">
						<md-item-template>
							<span md-highlight-text="searchReferencia" md-highlight-flags="^i">@{{[item.srf_referencia,item.referenciaDescripcion].join(" - ")}}</span>
						</md-item-template>
						<md-not-found>
							No states matching "@{{searchReferencia}}" were found.
						</md-not-found>
					</md-autocomplete>
					<div class="input-group-btn">

						<button ng-disabled="!(objeto.referenciaGeneral != '' &&  objeto.referenciaGeneral != undefined)" class="btn btn-success" type="button" ng-click="agregarReferenciaTodos(referenciaGeneral)">
							<i class="glyphicon glyphicon-plus"></i>
						</button>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Tabla de resumen de detalles por Destinatario-->
<div class="panel panel-primary" ng-if="selectedColaboradores.length > 0">
	<div class="panel-heading" align="center">
		Resumen de detalle por persona
	</div>
	<div class="panel-body">

		<div class="row">
			<div class="form-group col-md-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th style="text-align:center;">Despachar a</th>
								<th ng-if="esVendedor" style="text-align:center;">Zona</th>
								<th style="text-align:center;">Cantidad Referencias</th>
								<th style="text-align:center;">Cantidad Solicitada</th>
								<th style="text-align:center;">Valor</th>
								<!-- <th style="text-align:center;"></th> -->
								<th style="text-align:center;"></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="persona in selectedColaboradores">
								<td>@{{persona.scl_nombre}}</td>
								<td ng-if="esVendedor" style="text-align:center;">ZONA @{{persona.scz_zon_id}}</td>
								<td style="text-align:right;">@{{persona.cantidadTotalReferencias}}</td>
								<td style="text-align:right;">@{{sumaCantidadSolicitada(persona)}}</td>
								<td style="text-align:right;">@{{sumaValorTotal(persona) | currency: "$"}}</td>
								<!-- <td style="text-align:center;"><button type="button" class="btn btn-info"><i class="glyphicon glyphicon-eye-open"></i></button></td> -->
								<td style="text-align:center;"><button type="button" ng-click="eliminarPersona(persona)" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Tabla - Detalle por Destinatario -->
<div class="table-responsive" ng-repeat="persona in selectedColaboradores">
	<table id="@{{persona.scl_cli_id}}" class="table">
		<thead>
			<tr>
				<th colspan="7">@{{[persona.scl_cli_id, persona.scl_nombre].join(' - ')}}</th>
			</tr>
			<tr>
				<td colspan="4">
					<md-autocomplete
					md-selected-item = "persona.referenciaSearchItem"
					md-search-text = "searchReferencia"
					md-no-cache = "true"
					md-items = "item in qs_referencia(searchReferencia)"
					md-item-text = "[item.srf_referencia,item.referenciaDescripcion].join(' - ')"
					md-min-length = "1"
					placeholder = "Digite la referencia">
					<md-item-template>
						<span md-highlight-text="searchReferencia" md-highlight-flags="^i">@{{[item.srf_referencia,item.referenciaDescripcion].join(" - ")}}</span>
					</md-item-template>
					<md-not-found>
						No states matching "@{{searchReferencia}}" were found.
					</md-not-found>
				</md-autocomplete>
			</td>
			<td>
				<button ng-disabled="!(persona.referenciaSearchItem != '' &&  persona.referenciaSearchItem != undefined)" class="btn btn-success" type="button" ng-click="agregarReferenciaVendedor(persona, $event)"><span class="glyphicon glyphicon-plus"></span></button>
			</td>
		</tr>
		<tr>
			<th>Referencia</th>
			<th>Estado</th>
			<th>Costo</th>
			<th>Cantidad</th>
			<th>Lineas a Cargar Gasto	</th>
			<th>Valor total</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-if="persona.solicitud.referencias == undefined"><td style="text-align:center;" colspan="7">No hay referencias para esta persona</td></tr>
		<tr ng-repeat="referencia in persona.solicitud.referencias">
			<td>@{{[referencia.srf_referencia,referencia.referenciaDescripcion].join(" - ")}}</td>
			<td>@{{referencia.srf_estadoref}}</td>
			<td style="text-align:right;">@{{referencia.srf_preciouni | currency: "$"}}</td>
			<td style="width: 76px;">
				<input class="form-control inputCantMinimized inputCantMinimized-success" type="number" ng-model="referencia.srf_unidades" ng-change="onCantidadChange(referencia)" min="1" maxlength="20" minlength="1"/>
			</td>
			<td>
				<select ng-disabled="true" required class='form-control' ng-model='referencia.linea' ng-change="onChangeLineaReferencia(referencia)" ng-options='opt3.lineas_producto.NomLinea for opt3 in lineasproducto track by opt3.lineas_producto.CodLinea'></select>
			</td>
			<td style="text-align:right;">@{{referencia.referenciaValorTotal  | currency: "$"}}</td>
			<td>
				<button type="button" ng-click="eliminarReferencia(persona,referencia)" class="btn btn-danger">
					<i class="glyphicon glyphicon-remove"></i>
				</buttom>
			</td>
		</tr>
	</tbody>
</table>
</div>

<div ng-if="selectedColaboradores.length > 0" class="modal-footer">
	<button class="btn btn-primary" ng-disabled="!solicitud.canBeProccess" type="submit">Guardar</button>
	<button class="btn btn-success" ng-click="enviarSolicitud()" ng-disabled="(!solicitud.canBeProccess)"  type="button">Guardar y Enviar</button>
	<button class="btn btn-secondary" onclick="window.location='{{route("misSolicitudes")}}'" type="button">Cerrar</button>
</div>

</div>

</form>
</div>
<div ng-if="progress" class="progress">
	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
</div>

</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/solicitudCtrl.js')}}"></script>
@endpush
