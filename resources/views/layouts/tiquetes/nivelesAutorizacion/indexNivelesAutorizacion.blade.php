@extends('app')

@section('content')
  @include('includes.titulo')
  <link rel="stylesheet" href="{{url('/css/tiqueteshotel/tiqueteshotel.css')}}">
    <div ng-controller="nivelesAutorizacionCtrl" ng-cloak class="cold-md-12">
      <div class="container-fluid">
        <md-tabs md-dynamic-height md-border-bottom>
          <!-- inicio nivel 1 -->
          <md-tab label="nivel 1">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(1)">
                <i class="glyphicon glyphicon-plus"></i>  Agregar Nivel
              </button>
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                <thead>
                  <tr>
                    <th>Tipo Persona</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody ng-repeat="usu in usuNivelUno">
                  <td>@{{usu.tipo_persona.tpp_descripcion}}</td>
                  <td>@{{usu.pen_cedula}}</td>
                  <td>@{{usu.pen_nombre}}</td>
                  <td>
                    <button class="btn btn-info btn-sm" ng-click="">
                      <i class="glyphicon glyphicon-eye-open"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="editNivelUno(usu)">
                      <i class="glyphicon glyphicon-edit"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivelUno(usu)">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                  </td>
                </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin nivel 1 -->
          <!-- inicio nivel 2 -->
          <md-tab label="nivel 2">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(2)">
                <i class="glyphicon glyphicon-plus"></i>  Agregar Nivel
              </button>
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                <thead>
                  <tr>
                    <th>Tipo Persona</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody ng-repeat="usuD in usuNivelDos">
                  <td>@{{usuD.tipo_persona.tpp_descripcion}}</td>
                  <td>@{{usuD.pen_cedula}}</td>
                  <td>@{{usuD.pen_nombre}}</td>
                  <td>
                    <button class="btn btn-info btn-sm" ng-click="">
                      <i class="glyphicon glyphicon-eye-open"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="editNivelUno(usuD)">
                      <i class="glyphicon glyphicon-edit"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivelUno(usuD)">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                  </td>
                </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin nivel 2 -->
          <!-- inicio nivel 3 -->
          <md-tab label="nivel 3">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(3)">
                <i class="glyphicon glyphicon-plus"></i>  Agregar Nivel
              </button>
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                <thead>
                  <tr>
                    <th>Tipo Persona</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody ng-repeat="usuT in usuNivelTres">
                  <td>@{{usuT.tipo_persona.tpp_descripcion}}</td>
                  <td>@{{usuT.pen_cedula}}</td>
                  <td>@{{usuT.pen_nombre}}</td>
                  <td>
                    <button class="btn btn-info btn-sm" ng-click="">
                      <i class="glyphicon glyphicon-eye-open"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="editNivelUno(usuT)">
                      <i class="glyphicon glyphicon-edit"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivelUno(usuT)">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                  </td>
                </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin nivel 3 -->
          <!-- inicio nivel 4 -->
          <md-tab label="nivel 4">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(4)">
                <i class="glyphicon glyphicon-plus"></i>  Agregar Nivel
              </button>
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                <thead>
                  <tr>
                    <th>Tipo Persona</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody ng-repeat="usu in usuNivelCuatro">
                  <td>@{{usuC.tipo_persona.tpp_descripcion}}</td>
                  <td>@{{usuC.pen_cedula}}</td>
                  <td>@{{usuC.pen_nombre}}</td>
                  <td>
                    <button class="btn btn-info btn-sm" ng-click="">
                      <i class="glyphicon glyphicon-eye-open"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="editNivelUno(usu)">
                      <i class="glyphicon glyphicon-edit"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivelUno(usu)">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                  </td>
                </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin nivel 4 -->
        </md-tabs>
      </div>
      @include('layouts.tiquetes.nivelesAutorizacion.createNivelAutorizacion')
      <div ng-if="progress" class="progress">
        <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
      </div>
    </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/tiquetes/nivelesAutorizacionCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
