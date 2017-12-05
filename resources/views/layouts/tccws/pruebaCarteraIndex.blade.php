@extends('app') 

@section('content')
  @include('includes.titulo')

  <div ng-controller="pruebaCarteraCtrl" ng-cloak class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
    <form name="reporteForm" method="GET" action="{{$url}}">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="panel-group">
          <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
              <div class="pull-right">             
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal">
                  <i class="glyphicon glyphicon-plus"></i> Crear
                </button>
              </div>
              <button type="submit" class="btn btn-info btn-sm">
                <i class="glyphicon glyphicon-export"></i> Generar Excel
              </button>
            </div>
          </div>
        </div>
        <br>
        <div class="panel-group">
          <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
          <div class="panel panel-default" ng-repeat="(key, prueba) in pruebas">
            <div class="panel-heading">
              <h4 class="panel-title">
              <a data-toggle="collapse" href="#collapse@{{key}}">Mes(@{{prueba.prc_numero}})</a>
              </h4>
            </div>
            <div id="collapse@{{key}}" class="panel-collapse collapse">
              <div class="panel-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Número</th>
                      <th>Suma</th>
                      <th>Formula</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>@{{prueba.prc_numero}}</td>
                      <td>@{{prueba.prc_suma}}</td>
                      <td>@{{prueba.prc_formulas}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>  
    </div>
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
    @include('layouts.tccws.pruebaCarteraCreate')
  </div>



@endsection

@push('script_angularjs')
<script src="{{url('/js/tccws/pruebaCarteraCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush