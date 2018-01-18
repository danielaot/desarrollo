@extends('app')

@section('content')
@include('includes.titulo')

<div ng-controller="consultaRemesasCtrl" ng-cloak class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
	<div class="panel panel-default">
    <br>

    <div class="panel-head">
      <div class="row">

        <div class="col-xs-6 col-md-6 col-lg-6 col-xl-6 col-sm-6">
          <div class="container-fluid">
            <div class="row">          
              <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
                <label>Busqueda:</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    Facturas &nbsp;<input type="radio" ng-model="criterioBusqueda" value="facturas">
                  </span>
                  <span class="input-group-addon">
                    Remesas &nbsp;<input type="radio" ng-model="criterioBusqueda" value="remesas">
                  </span>
                  <input type="text" class="form-control" ng-model="searchText" ng-disabled="criterioBusqueda == NULL" placeholder="Busqueda...">
                  <span class="input-group-btn">
                    <button class="btn btn-info" type="button" ng-click="getConsultaBusquedas(searchText, criterioBusqueda)">
                      <i class="glyphicon glyphicon-search"></i>
                      <md-tooltip>Buscar
                    </button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-6 col-md-6 col-lg-6 col-xl-6 col-sm-6">
          <label>Busqueda entre fechas:</label>
          <div flex-gt-xs>
            <md-datepicker ng-model="fechaInicial" md-placeholder="Fecha inicial"></md-datepicker>
            <md-datepicker ng-model="fechaFinal" md-placeholder="Fecha Final"></md-datepicker>
            &nbsp;&nbsp;
            <button class="btn btn-info" type="button" ng-click="getConsultaFechas(fechaInicial, fechaFinal)">
              <i class="glyphicon glyphicon-search"></i>
              <md-tooltip>Buscar
            </button>
            &nbsp;
          </div>
        </div>

      </div>
    </div>

    <hr>

		<div class="panel-body">
			<table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
        <thead>
        	<tr> 
            <th class="text-center">Cliente</th>
            <th class="text-center">Sucursal</th>
            <th class="text-center">Ciudad de Destino</th>
					  <th class="text-center">Número de Remesa</th>
            <th class="text-center">Placa de vehiculo</th>
 					  <th class="text-center">Factura</th>
					  <th class="text-center">Fecha de Creación</th>
          	<th></th>
            <th></th>
					</tr>
       	</thead>
      	<tbody>
      		<tr ng-repeat="(key, value) in consultas | groupBy : 'consulta.rms_remesa'"> 
            <td>@{{value[0].consulta.nombre_cliente.razonSocialTercero}}</td>
            <td>@{{value[0].consulta.rms_nom_sucursal}}</td>
            <td>@{{value[0].consulta.rms_ciud_sucursal}}</td>
            <td>@{{ key }} @{{ imprimir(key) }}</td>
            <td>@{{value[0].consulta.rms_txt_vehiculo}}</td>
            <td>
              @{{ retornarCadena(value[0].consulta.facturas) }}
            </td>
      		  <td class="text-left">@{{value[0].consulta.created_at | date: 'shortDate'}}</td>
    		    <td class="text-right">
        		  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal" ng-click="setFactura(value[0])">
                <i class="glyphicon glyphicon-eye-open"></i>
                <md-tooltip>Ver
         			</button>
            </td>
            <td class="text-center">  
              <form action="@{{value[0].rutaInforme}}">
                <button type="submit" class="btn btn-success btn-sm">
                  <i class="glyphicon glyphicon glyphicon-cloud-download"></i>
                  <md-tooltip>Generar Reporte</md-tooltip>
                </button>
              </form>
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
