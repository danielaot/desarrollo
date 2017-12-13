@extends('app') 

@section('content')
  @include('includes.titulo')
    <link rel="stylesheet" type="text/css" href="{{url('/css/tccws/ciudades.css')}}">
  	<div ng-controller="ciudadesCtrl" ng-cloak class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
    	<div class="panel panel-default">
      		<div class="panel-body">
      			<button type="button" class="btn btn-success btn-sm" ng-click="resetForm()" data-toggle="modal" data-target="#modal">
              <i class="glyphicon glyphicon-plus"></i>Agregar
              </button>
              <div class="panel-group">

        		<table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
        			<thead>
        				<tr>
          					<th class="text-center">Codigo Dane</th>
          					<th class="text-center">Departamento</th>
          					<th class="text-center">Ciudad TCC</th>
          					<th class="text-center">Ciudad ERP</th>
          					<th></th>
        				</tr>
        			</thead>
        			<tbody>
        				<tr ng-repeat="ciudad in ciudades"> 
          					<td class="text-left">@{{ciudad.ctc_cod_dane}}</td>
          					<td class="text-left">@{{ciudad.ctc_dept_erp}}</td>
          					<td class="text-left">@{{ciudad.ctc_ciu_tcc}}</td>
          					<td class="text-left">@{{ciudad.ctc_ciu_erp == '' ? 'Sin información': ciudad.ctc_ciu_erp}}</td>
          					<td class="text-right">
          						<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editarCiudad(ciudad)">
              					<i class="glyphicon glyphicon-pencil"></i>
              					<md-tooltip>Editar
            					</button>
          					</td>
        				</tr>
        			</tbody>
        		</table>
      		</div>
      		</div>
      		@include('layouts.tccws.Catalogos.ciudadesCreate')
    	</div>

    	<div ng-if="progress" class="progress">
      		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    	</div>
  	</div>
  

  @endsection

@push('script_angularjs')
<script src="{{url('/js/tccws/ciudadesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush