@extends('app')

@section('content')
@include('includes.titulo')
<style>
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
<div class="container">
	<div ng-controller="pedidosAgrupaCtrl as ctrl"  layout="column" flex layout-fill ng-cloak>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label>Seleccionar cliente:</label>
				<select ng-model="cliente" class="form-control" ng-options="ter.razonSocialTercero for ter in terceros track by ter.idTercero">
					<option value="">Seleccione...</option>
				</select>
			</div>
		</div>
		<div ng-if="cliente != undefined" class="col-sm-12">
			<div class="form-group">
				 <md-input-container>
		        <label>Seleccionar sucursal:</label>
		        <md-select ng-model="sucursal"
		                   md-on-close="clearSearchTerm()"
		                   data-md-container-class="selectdemoSelectHeader"
		                   multiple>
		          <md-optgroup label="sucu.codigo">
		            <md-option ng-value="sucu.codigo" ng-model="sucursalesArray" ng-change="onChangeSucursales(sucu)" ng-repeat="sucu in  getSucursales() |
		              filter:searchTerm">@{{sucu.nombre}}</md-option>
		          </md-optgroup>
		        </md-select>
		      </md-input-container>

			</div>

		</div>
		<div class="col-sm-12">
		 	<div class="form-group">
				<button ng-if="cliente != undefined" class="btn btn-primary pull-right" ng-click="traerElementos()"><i class="glyphicon glyphicon-search"></i></button>
		 	</div>
		</div>
	</div>

	@{{agrupoCliente[cliente.idTercero]}}
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

	</div>
@endsection
</div>


@push('script_angularjs')
<script src="{{url('/js/tccws/pedidosAgrupaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
