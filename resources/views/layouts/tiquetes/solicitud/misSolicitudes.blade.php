@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="misSolicitudesCtrl" ng-cloak class="cold-md-12">
     <div class="container-fluid">
       <md-tabs md-dynamic-height md-border-bottom>
         <!-- inicio Todas -->
         <md-tab label="Todas (@{{todas.length}})">
             <md-content class="md-padding">
               <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Estado</th>
                      <th>Beneficiario</th>
                      <th>Fecha Solicitud</th>
                      <th>Ver</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="tod in todas">
                       <td>@{{tod.solIntSolId}}</td>
                       <td>@{{tod.estados.estTxtNombre}}</td>
                       <td>@{{tod.solTxtNomtercero}}</td>
                       <td>@{{tod.solIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                       <td>
                         <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(tod)">
                           <i class="glyphicon glyphicon-eye-open"></i>
                         </button>
                       </td>
                    </tr>
                  </tbody>
               </table>
             </md-content>
           </md-tab>
           <!-- fin Todas -->
          <!-- inicio En Elaboracion -->
          <md-tab label="En Elaboración (@{{elaboracion.length}})">
            <md-content class="md-padding">
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                 <thead>
                   <tr>
                     <th>No.</th>
                     <th>Estado</th>
                     <th>Beneficiario</th>
                     <th>Fecha Solicitud</th>
                     <th>Editar</th>
                     <th>Ver</th>
                     <th>Enviar</th>
                     <th>Anular</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr ng-repeat="elab in elaboracion">
                     <td>@{{elab.solIntSolId}}</td>
                          <td>@{{elab.estados.estTxtNombre}}</td>
                          <td>@{{elab.solTxtNomtercero}}</td>
                          <td>@{{elab.solIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                          <td>
                            <button class="btn btn-warning btn-sm" ng-click="editSolicitud(elab)">
                              <i class="glyphicon glyphicon-edit"></i>
                            </button>
                          </td>
                          <td>
                            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(elab)">
                              <i class="glyphicon glyphicon-eye-open"></i>
                            </button>
                          </td>
                          <td>
                            <button class="btn btn-primary btn-sm" type="button" ng-click="enviarSolicitud(elab)">
                              <i class="glyphicon glyphicon-send"></i>
                            </button>
                          </td>
                          <td>
                            <button class="btn btn-danger btn-sm" type="button" ng-click="anularSolicitud(elab)">
                              <i class="glyphicon glyphicon-remove"></i>
                            </button>
                          </td>
                   </tr>
                 </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin En Elaboracion -->
          <!-- inicio Correcciones -->
          <md-tab label="Correcciones (@{{correcciones.length}})">
            <md-content class="md-padding">
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                 <thead>
                   <tr>
                     <th>No.</th>
                     <th>Estado</th>
                     <th>Beneficiario</th>
                     <th>Fecha Solicitud</th>
                     <th>Ver</th>
                     <th>Editar</th>
                     <th>Enviar</th>
                    <th>Anular</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr ng-repeat="corr in correcciones">
                      <td>@{{corr.solIntSolId}}</td>
                      <td>@{{corr.estados.estTxtNombre}}</td>
                      <td>@{{corr.solTxtNomtercero}}</td>
                      <td>@{{corr.solIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                      <td>
                        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(corr)">
                          <i class="glyphicon glyphicon-eye-open"></i>
                        </button>
                      </td>
                      <td>
                        <button class="btn btn-warning btn-sm" ng-click="">
                          <i class="glyphicon glyphicon-edit"></i>
                        </button>
                      </td>
                      <td>
                        <button class="btn btn-primary btn-sm" type="button" ng-click="enviarSolicitud(corr)">
                          <i class="glyphicon glyphicon-send"></i>
                        </button>
                      </td>
                      <td>
                        <button class="btn btn-danger btn-sm" type="button" ng-click="anularSolicitud(corr)">
                          <i class="glyphicon glyphicon-remove"></i>
                        </button>
                      </td>
                   </tr>
                 </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin Correcciones -->
          <!-- inicio Anuladas -->
          <md-tab label="Anuladas (@{{anuladas.length}})">
            <md-content class="md-padding">
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                 <thead>
                   <tr>
                     <th>No.</th>
                     <th>Estado</th>
                     <th>Beneficiario</th>
                     <th>Fecha Solicitud</th>
                     <th>Ver</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr ng-repeat="anu in anuladas">
                     <td>@{{anu.solIntSolId}}</td>
                     <td>@{{anu.estados.estTxtNombre}}</td>
                     <td>@{{anu.solTxtNomtercero}}</td>
                     <td>@{{anu.solIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                     <td>
                       <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(anu)">
                         <i class="glyphicon glyphicon-eye-open"></i>
                       </button>
                     </td>
                   </tr>
                 </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin Anuladas -->
          <!-- inicio Por Aprobación -->
          <md-tab label="Por Aprobación (@{{paprobacion.length}})">
            <md-content class="md-padding">
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                 <thead>
                   <tr>
                     <th>No.</th>
                     <th>Estado</th>
                     <th>Beneficiario</th>
                     <th>Fecha Solicitud</th>
                     <th>Ver</th>
                     <th>Anular</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr ng-repeat="papro in paprobacion">
                     <td>@{{papro.solIntSolId}}</td>
                     <td>@{{papro.estados.estTxtNombre}}</td>
                     <td>@{{papro.solTxtNomtercero}}</td>
                     <td>@{{papro.solIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                     <td>
                       <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(papro)">
                         <i class="glyphicon glyphicon-eye-open"></i>
                       </button>
                     </td>
                     <td>
                       <button class="btn btn-danger btn-sm" type="button" ng-click="anularSolicitud(papro)">
                         <i class="glyphicon glyphicon-remove"></i>
                       </button>
                     </td>
                   </tr>
                 </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin Por Aprobación -->
          <!-- inicio Aprobadas -->
          <md-tab label="Aprobadas (@{{aprobadas.length}})">
            <md-content class="md-padding">
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                 <thead>
                   <tr>
                     <th>No.</th>
                     <th>Estado</th>
                     <th>Beneficiario</th>
                     <th>Fecha Solicitud</th>
                     <th>Ver</th>
                     <th>Impresión</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr ng-repeat="apro in aprobadas">
                      <td>@{{apro.solIntSolId}}</td>
                      <td>@{{apro.estados.estTxtNombre}}</td>
                      <td>@{{apro.solTxtNomtercero}}</td>
                      <td>@{{apro.solIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                      <td>
                        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(apro)">
                          <i class="glyphicon glyphicon-eye-open"></i>
                        </button>
                      </td>
                      <td>

                      </td>
                   </tr>
                 </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin Aprobadas -->
          <!-- inicio Cerradas -->
          <md-tab label="Cerradas (@{{cerradas.length}})">
            <md-content class="md-padding">
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                 <thead>
                   <tr>
                     <th>No.</th>
                     <th>Estado</th>
                     <th>Beneficiario</th>
                     <th>Fecha Solicitud</th>
                     <th>Ver</th>
                     <th>PDF</th>
                   </tr>
                 </thead>
                 <tbody>
                   <tr ng-repeat="cerr in cerradas">
                     <td>@{{cerr.solIntSolId}}</td>
                     <td>@{{cerr.estados.estTxtNombre}}</td>
                     <td>@{{cerr.solTxtNomtercero}}</td>
                     <td>@{{cerr.solIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                     <td>
                       <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(cerr)">
                         <i class="glyphicon glyphicon-eye-open"></i>
                       </button>
                     </td>
                     <td>
                       <button class="btn btn-primary btn-sm" ng-click="">
                         <i class="glyphicon glyphicon-download-alt"></i>
                       </button>
                     </td>
                   </tr>
                 </tbody>
              </table>
            </md-content>
          </md-tab>
          <!-- fin Cerradas -->
        </md-tabs>
      </div>
      @include('layouts.tiquetes.solicitud.misSolicitudesDet')
      <div ng-if="progress" class="progress">
        <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
      </div>
    </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/tiquetes/misSolicitudesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
