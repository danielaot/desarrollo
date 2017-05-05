@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="procesosCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br><br>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default" ng-repeat="proceso in procesos track by $index">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title row">
                <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{$index}}">
                  <div class="col-sm-3">
                    @{{proceso.pro_nombre}}
                  </div>
                  <div class="col-sm-5">
                    @{{proceso.pro_descripcion}}
                  </div>
                </a>
                <div class="col-sm-4 text-right">
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal2" ng-click="setProceso(proceso.id)">
                    <i class="glyphicon glyphicon-plus"></i> Agregar
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" ng-click="editProceso(proceso.id)">
                    <i class="glyphicon glyphicon-pencil"></i> Editar
                  </button>
                  <button type="button" class="btn btn-danger btn-sm" ng-click="deleteProceso($event, proceso.id)">
                    <i class="glyphicon glyphicon-trash"></i> Borrar
                  </button>
                </div>
              </h4>
            </div>
            <div id="collapse@{{$index}}" class="panel-collapse collapse in" role="tabpanel">
              <div class="panel-body">
                <ul class="list-group">
                  <li class="list-group-item" ng-repeat="actividad in proceso.actividades">
                    <div class="row">
                      <div class="col-sm-3">
                        @{{actividad.act_titulo}}
                      </div>
                      <div class="col-sm-4">
                        @{{actividad.act_descripcion}}
                      </div>
                      <div class="col-sm-3">
                        @{{actividad.areas.ar_nombre}}
                      </div>
                      <div class="col-sm-2 text-right">
                        <button class="btn btn-primary btn-sm" ng-click="editActividad(actividad.id)">
                          <i class="glyphicon glyphicon-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" ng-click="deleteActividad($event, actividad.id)">
                          <i class="glyphicon glyphicon-trash"></i>
                        </button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createProcesos')
    @include('layouts.pricat.catalogos.createActividades')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/procesosCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
