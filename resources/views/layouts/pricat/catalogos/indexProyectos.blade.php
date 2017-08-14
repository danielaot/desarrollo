@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="proyectosCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="setProyecto()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br><br>
        <ul class="list-group">
          <li class="list-group-item" ng-repeat="proyecto in proyectos">
            <div class="row">
              <div class="col-sm-6">
                @{{proyecto.proy_nombre}}
              </div>
              <div class="col-sm-2">
                @{{proyecto.procesos.pro_nombre}}
              </div>
              <div class="col-sm-2">
                @{{proyecto.proy_estado}}
              </div>
              <div class="col-sm-2 text-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal1" ng-click="editProyecto(proyecto.id)">
                  <i class="glyphicon glyphicon-edit"></i> Editar
                </button>
                <!--button class="btn btn-danger btn-sm" ng-click="deleteProyecto($event, proyecto.id)">
                  <i class="glyphicon glyphicon-trash"></i> Borrar
                </button-->
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createProyectos')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/proyectosCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
