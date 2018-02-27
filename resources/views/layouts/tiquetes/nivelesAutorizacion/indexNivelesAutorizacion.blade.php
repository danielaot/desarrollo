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
                      <th>Editar</th>
                      <th>Eliminar</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr ng-repeat="usu in usuNivelUno">
                     <td>@{{usu.tipo_persona.tpp_descripcion}}</td>
                     <td>@{{usu.pen_cedula}}</td>
                     <td>@{{usu.pen_nombre}}</td>
                     <td>
                       <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal1" ng-click="setEditPernivel(usu)">
                         <i class="glyphicon glyphicon-edit"></i>
                       </button>
                     </td>
                     <td>
                       <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivel(usu)">
                         <i class="glyphicon glyphicon-remove"></i>
                       </button>
                     </td>
                   </tr>
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
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="usuD in usuNivelDos">
                    <td>@{{usuD.tipo_persona.tpp_descripcion}}</td>
                    <td>@{{usuD.pen_cedula}}</td>
                    <td>@{{usuD.pen_nombre}}</td>
                    <td>
                      <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal1" ng-click="setEditPernivel(usuD)">
                        <i class="glyphicon glyphicon-edit"></i>
                      </button>
                    </td>
                    <td>
                      <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivel(usuD)">
                        <i class="glyphicon glyphicon-remove"></i>
                      </button>
                    </td>
                  </tr>
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
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="usuT in usuNivelTres">
                    <td>@{{usuT.tipo_persona.tpp_descripcion}}</td>
                    <td>@{{usuT.pen_cedula}}</td>
                    <td>@{{usuT.pen_nombre}}</td>
                    <td>
                      <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal1" ng-click="setEditPernivel(usuT)">
                        <i class="glyphicon glyphicon-edit"></i>
                      </button>
                    </td>
                    <td>
                      <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivel(usuT)">
                        <i class="glyphicon glyphicon-remove"></i>
                      </button>
                    </td>
                  </tr>
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
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr  ng-repeat="usuC in usuNivelCuatro">
                    <td>@{{usuC.tipo_persona.tpp_descripcion}}</td>
                    <td>@{{usuC.pen_cedula}}</td>
                    <td>@{{usuC.pen_nombre}}</td>
                    <td>
                      <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal1" ng-click="setEditPernivel(usuC)">
                        <i class="glyphicon glyphicon-edit"></i>
                      </button>
                    </td>
                    <td>
                      <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivel(usuC)">
                        <i class="glyphicon glyphicon-remove"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin nivel 4 -->
          <!-- inicio nivel Serv. Administrativos -->
          <md-tab label="Serv. Administrativos">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal"  ng-click="cambiarNivel(5)">
                <i class="glyphicon glyphicon-plus"></i>  Crear Aprobador Serv. Administrativos
              </button>
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                <thead>
                  <tr>
                    <th>Tipo Persona</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="usuSA in usuSerAdmin">
                    <td>@{{usuSA.tipo_persona.tpp_descripcion}}</td>
                    <td>@{{usuSA.pen_cedula}}</td>
                    <td>@{{usuSA.pen_nombre}}</td>
                    <td>
                      <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal1" ng-click="setEditPernivel(usuSA)">
                        <i class="glyphicon glyphicon-edit"></i>
                      </button>
                    </td>
                    <td>
                      <button class="btn btn-danger btn-sm" type="button" ng-click="eliminarNivel(usuSA)">
                        <i class="glyphicon glyphicon-remove"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin nivel Serv. Administrativos -->
        </md-tabs>
        <div ng-if="progress" class="progress">
          <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
        </div>
      </div>
      @include('layouts.tiquetes.nivelesAutorizacion.createNivelAutorizacion')
      @include('layouts.tiquetes.nivelesAutorizacion.editNivelAutorizacion')
    </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/tiquetes/nivelesAutorizacionCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
