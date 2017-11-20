@extends('app')

@section('content')
  @include('includes.titulo')
  <div class="panel panel-default" ng-controller="desarrolloactividadCtrl" ng-cloak>
    <div class="panel-body">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <!-- Foreach -->
          <div class="panel panel-default" ng-repeat="(key, desarrollo) in desarrollos">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title row">
                <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{key}}">
                  <div class="col-sm-12">
                    @{{desarrollo[0].proyectos.proy_nombre}}
                  </div>
                </a>
              </h4>
            </div>
            <div id="collapse@{{key}}" class="panel-collapse collapse" role="tabpanel">
              <div class="panel-body">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-4">
                        @{{desarrollo[0].actividades.act_titulo}}
                      </div>
                      <div class="col-sm-6">
                        @{{desarrollo[0].actividades.act_descripcion}}
                      </div>
                      <div class="col-sm-2 text-right">
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" ng-click="regresar(desarrollo[0])" data-target="#modal1">
                          <i class="fa fa-arrow-circle-left"></i> Regresar
                        </button>
                        <a href="@{{desarrollo[0].url}}">
                          <button class="btn btn-primary btn-sm">
                            <i class="glyphicon glyphicon-pencil"></i> Realizar
                          </button>
                        </a>
                      </div>
                    </div>
                  </li>
                    <li ng-if="desarrollo.length > 1" class="list-group-item">
                      <div class="row">
                        <div class="col-sm-4">
                          @{{desarrollo[1].actividades.act_titulo}}
                        </div>
                        <div class="col-sm-6">
                          @{{desarrollo[1].actividades.act_descripcion}}
                        </div>
                        <div class="col-sm-2 text-right">
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" ng-click="regresar(desarrollo[1])" data-target="#modal1" ng-click="setSolicitud()">
                            <i class="fa fa-arrow-circle-left"></i> Regresar
                          </button>
                          <a href="@{{desarrollo[1].url}}">
                            <button class="btn btn-primary btn-sm">
                              <i class="glyphicon glyphicon-pencil"></i> Realizar
                            </button>
                          </a>
                        </div>
                      </div>
                    </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- end foreach -->
      </div>
        @include('layouts.pricat.actividades.regresarPaso')
      <div ng-if="progress" class="progress">
        <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
      </div>
    </div>
  </div>
@endsection


@push('script_angularjs')
  <script src="{{url('/js/pricat/desarrolloactividadCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
