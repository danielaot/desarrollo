@extends('app')

@section('content')
  @include('includes.titulo')
  <div class="panel panel-default" ng-controller="rechazoactividadCtrl" ng-cloak>
    <div class="panel-body">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <!-- Foreach -->
          <div class="panel panel-default" ng-repeat="(key, dato) in datos">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title row">
                <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{key}}">
                  <div class="col-sm-12">
                    @{{dato.infoCompleta.proyecto.proyectos.proy_nombre}}
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
                        @{{dato.infoCompleta.actividades.act_titulo}}
                      </div>
                      <div class="col-sm-4">
                        @{{dato.infoCompleta.actividades.areas.ar_nombre}}
                      </div>
                      <div class="col-sm-3">
                        @{{dato.infoCompleta.actividades.areas.responsables[0].res_usuario}}
                      </div>
                      <div class="col-sm-12">
                        <md-radio-group ng-model="dato.paso" ng-repeat="mostrar in actividad">
                          <md-radio-button ng-value="@{{mostrar}}" class="md-primary">@{{mostrar.act_titulo}}</md-radio-button>
                        </md-radio-group>
                      </div>
                      <div class="col-sm-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" ng-click="aceptarPaso(dato)" data-target="#modal1">
                              Aceptar
                        </button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <!-- end foreach -->
      </div>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/rechazoactividadCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
