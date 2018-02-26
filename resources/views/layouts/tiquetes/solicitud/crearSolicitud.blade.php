@extends('app')

@section('content')
  @include('includes.titulo')
  <link rel="stylesheet" href="{{url('/css/tiqueteshotel/tiqueteshotel.css')}}">
  @if(isset($solicitudes))
    <div ng-controller="crearSolicitudCtrl" ng-cloak ng-init="solicitudes = {{$solicitudes}};getInfo();getInfoPaises();" class="cold-md-12">
      <form name="solicitudForm" ng-submit="solicitudForm.$valid && editarSolicitud(true)" novalidate>
    @else
      <div ng-controller="crearSolicitudCtrl" ng-cloak ng-init="getInfo();getInfoPaises();" class="cold-md-12">
        <form name="solicitudForm" ng-submit="solicitudForm.$valid && saveSolicitud(true)" novalidate>
    @endif
    <hr>
    <div class="panel panel-primary">
      <div class="panel-heading" style="text-align:center">Información Solicitante</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-4 form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Fecha Creación :</label>
                  <p>{{ date('Y-m-d H:i:s') }}</p>
                </div>
              </div>
              <div class="col-sm-4 form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Tipo Solicitud <span class="required">*</span>:</label>
                  <div class="col-sm-5">
                    <select class="form-control" ng-model="solicitud.tipo" ng-change="validateTipo()" required>
                      <option value="">Seleccione ...</option>
                      <option value=1>Nuevo</option>
                      <option value=2>Modificacion</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 form-group" ng-if="solicitud.tipo == 2">
                <div class="row">
                  <label class="col-sm-4 control-label">Solicitud Ant. <span class="required">*</span>:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" ng-model="solicitud.solAnterior" placeholder="Solicitud Anterior" disabled>
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#modal1" ng-click="solicitudesMod()">
                          <i class="glyphicon glyphicon-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label>Nombre <span class="required">*</span>:</label>
                  <md-autocomplete md-search-text="nombreSearchText"
                               md-items="nombre in nombreSearch(nombreSearchText)"
                               md-item-text="nombre.pen_nombre"
                               md-selected-item="solicitud.nombre"
                               md-selected-item-change="onBeneficiarioChange(beneficiario)"
                               md-min-length="0">
                    <md-item-template>
                      <span md-highlight-text="nombreSearchText" md-highlight-flags="^i">@{{nombre.pen_nombre}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{nombreSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
                <div class="col-sm-6">
                  <label>Identificacion :</label>
                  <input type="text" class="form-control" ng-model="solicitud.nombre.pen_cedula" placeholder="Número de Identificacion" disabled>
                </div>

              </div>
              <div class="row">
                <div class="col-sm-6">
                  <label>Email :</label>
                  <!-- <input type="text" class="form-control" ng-if="solicitud.nombre.detpersona.perTxtEmailter == null " ng-model="solicitud.nombre.correo" placeholder="Email del Solicitante"> -->
                  <input type="text" class="form-control" ng-model="solicitud.nombre.detpersona.perTxtEmailter" placeholder="Email del Solicitante" disabled>
                </div>
                <div class="col-sm-6" ng-if = "solicitud.nombre != null">
                  <label>Fecha Nacimiento<span class="required">*</span>:</label>
                  <p>@{{(solicitud.nombre.detpersona.perTxtFechaNac) * (1000) | date:'dd-MM-yyyy'}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <label>Número Teléfono <span class="required">*</span>:</label>
                  <input type="number" class="form-control" ng-model="solicitud.numtelefono">
                </div>
                <div class="col-sm-6" ng-if = "solicitud.nombre != null">
                  <label ng-if="solicitud.nombre.pen_idtipoper != '3' || solicitud.nombre.pen_idtipoper != '4'">Aprobador <span class="required">*</span>:</label>
                  <select ng-if="solicitud.nombre.pen_idtipoper != '3' || solicitud.nombre.pen_idtipoper != '4'" class="form-control" ng-model="solicitud.aprobador" ng-options='opt.aprobador.perTxtNomtercero for opt in aprobador track by opt.aprobador.perTxtNomtercero'>
                    <option value="">Seleccione aprobador ..</option>
                  </select>
                  <label ng-if="solicitud.nombre.pen_idtipoper == 3 || solicitud.nombre.pen_idtipoper == 4">Aprobador</label>
                  <p ng-if="solicitud.nombre.pen_idtipoper == 3 || solicitud.nombre.pen_idtipoper == 4">@{{solicitud.nombre.grupos[0].gru_responsable}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <label>Tipo de Viaje <span class="required">*</span>:</label>
                    <select class="form-control" ng-change="validarTipoViajeCargarData()" ng-model="solicitud.tviaje">
                      <option value="">Seleccione el tipo de viaje ..</option>
                      <option value=1>Nacional</option>
                      <option value=2>Internacional</option>
                    </select>
                </div>
                <div class="col-sm-6">
                  <label>Tipo Viajero <span class="required">*</span>:</label>
                    <select class="form-control" ng-model="solicitud.tviajero">
                      <option value="">Seleccione el tipo de viajero ..</option>
                      <option value="1">Interno Belleza</option>
                      <option value="2">Persona Externa</option>
                    </select>
                </div>
              </div>
              <div class="row" ng-if = "solicitud.tviajero == 2">
                <div class="col-sm-4">
                  <label>Cedula Externo <span class="required">*</span>:</label>
                  <input type="number" class="form-control" ng-model="solicitud.ccexterno">
                </div>
                  <div class="col-sm-4">
                    <label>Fecha Nacimiento <span class="required">*</span>:</label>
                    <input type="date" class="form-control" ng-model="solicitud.fnacimientoext">
                  </div>
                  <div class="col-sm-4">
                    <label>Numero Celular <span class="required">*</span>:</label>
                    <input type="number" class="form-control" ng-model="solicitud.numcelexter">
                  </div>
              </div>
              <div class="row" ng-if = "solicitud.tviajero == 2">
                  <div class="col-sm-6">
                    <label>Nombre Completo <span class="required">*</span>:</label>
                    <input type="text" class="form-control" ng-model="solicitud.nomexterno">
                  </div>
                  <div class="col-sm-6">
                    <label>Correo Electronico <span class="required">*</span>:</label>
                    <input type="text" class="form-control" ng-model="solicitud.corexterno">
                  </div>
              </div>
              <div ng-if="mostrarSelectCanal || mostrarSelectGrupo || mostrarSelectTerritorio" class="form-group">
                <div class="row">
                  <div ng-if="mostrarSelectTerritorio" class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                    <label>Territorio de Aprobación:</label>
                    <select required class="form-control" name="territorioaprobacion" id="territorioaprobacion" ng-change="onChangeTerritorio()" ng-model="solicitud.territorioaprobacion" ng-options="[territorioAprobacion.id, territorioAprobacion.tnw_descripcion].join(' - ') for territorioAprobacion in solicitud.nombre.territorios track by territorioAprobacion.id" require>
                    <option value="">-- Seleccione el territorio de aprobación --</option>
                    </select>
                  </div>

                  <div ng-if="mostrarSelectGrupo" class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                    <label>Grupo de Aprobación:</label>
                    <select required class="form-control" name="grupoaprobacion" id="grupoaprobacion" ng-change="onChangeGrupo()" ng-model="solicitud.grupoaprobacion" ng-options="[grupoAprobacion.gru_sigla, grupoAprobacion.gru_responsable].join(' - ') for grupoAprobacion in solicitud.nombre.grupos track by grupoAprobacion.id" require>
                    <option value="">-- Seleccione el grupo de aprobación --</option>
                    </select>
                  </div>

                  <div ng-if="mostrarSelectCanal" class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                    <label>Canal de Aprobación:</label>
                    <select class="form-control" name="canalaprobacion" id="canalaprobacion" ng-model="solicitud.canalaprobacion" ng-disabled="(mostrarSelectGrupo == true && solicitud.grupoaprobacion == undefined) ? true : (mostrarSelectTerritorio == true && solicitud.territorioaprobacion == undefined) ? true : deshabilitarSelectCanal == true ? true : false" ng-options="[canalAprobacion.can_id,canalAprobacion.can_txt_descrip].join(' - ') for canalAprobacion in canalesAprobacion track by canalAprobacion.can_id">
                    <option value="">-- Seleccione el canal de aprobación --</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12">
                  <label>Motivo de Viaje <span class="required">*</span>:</label>
                  <textarea class="form-control" rows="4" cols="71" style="resize: none;" placeholder="Motivo del viaje" ng-model="solicitud.motivo"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-primary" ng-if = "solicitud.tviaje != null">
          <div class="panel-heading" style="text-align:center">Detalle Solicitud de Viaje</div>
              <div class="panel-body">
                <div class="">
                  <!-- Detalle Solicitud Viaje Nacional -->
                  <table class="table table-striped table-bordered" ng-if = "solicitud.tviaje == '1'">
                    <thead>
                      <tr>
                        <th>Origen :</th>
                        <th>Destino :</th>
                        <th>Fecha :</th>
                        <th>Hotel :</th>
                        <th ng-if = "solicitud.detsoli.hotel == 'S'">No. Días :</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><select class="form-control" ng-model="solicitud.detsoli.origen" ng-options='opt.ciuTxtNom for opt in ciudad track by opt.ciuIntId'>
                          <option value="">Seleccione Ciudad Origen ..</option>
                        </select></td>
                        <td><select class="form-control" ng-model="solicitud.detsoli.destino" ng-options='opt.ciuTxtNom for opt in ciudad track by opt.ciuIntId'>
                          <option value="">Seleccione Ciudad Destino ..</option>
                        </select></td>
                        <td><input class="form-control" mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
                          placeholder="Fecha y Hora de Viaje" show-todays-date="" min-date="date" ng-model="solicitud.detsoli.fviaje" class=" md-input" short-time ="true"
                          readonly="readonly" ng-change="validarFecha(fecha)"></td>
                        <td><select class="form-control" ng-model="solicitud.detsoli.hotel">
                          <option value="">Seleccione ..</option>
                          <option value="S">Si</option>
                          <option value="N">No</option>
                        </select></td>
                        <td ng-if = "detsoli.hotel == 'S'"><input type="number" class="form-control" ng-model="solicitud.detsoli.nodias"></td>
                        <td><button class="btn btn-success btn-sm" type="button" ng-click="AgregarTramo(solicitud.detsoli)">
                              <i class="glyphicon glyphicon-plus"></i>
                            </button></td>
                      </tr>
                      <tr ng-repeat="detalle in detallesol">
                        <td>@{{detalle.origen}}</td>
                        <td>@{{detalle.destino}}</td>
                        <td>@{{detalle.fviaje}}</td>
                        <td>@{{detalle.hotel}}</td>
                        <td >@{{detalle.hotel != 'N' ? detalle.nodias : 'N/A'}}</td>
                        <td><button class="btn btn-danger btn-sm" type="button" ng-click="QuitarTramo(detalle)">
                              <i class="glyphicon glyphicon-remove"></i>
                            </button></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- Fin Detalle Solicitud Viaje Nacional -->
                  <!-- Detalle Solicitud Viaje Internacional -->
                  <table class="table table-striped table-bordered" ng-if = "solicitud.tviaje == '2' && paises != undefined">
                    <thead>
                      <tr>
                        <th>País Origen :</th>
                        <th>Ciudad Origen :</th>
                        <th>País Destino :</th>
                        <th>Ciudad Destino :</th>
                        <th>Fecha :</th>
                        <th>Hotel :</th>
                        <th ng-if = "solicitud.detsoliInt.hotel == 'S'">No. Días :</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><md-autocomplete md-search-text="paisoriSearchText"
                                     md-items="pais in paisoriSearch(paisoriSearchText)"
                                     md-item-text="pais.Pais"
                                     md-selected-item="solicitud.detsoliInt.porigen"
                                     md-min-length="0"
                                     >
                          <md-item-template>
                            <span md-highlight-text="paisSearchText" md-highlight-flags="^i">@{{pais.Pais}}</span>
                          </md-item-template>
                          <md-not-found>
                            No se encontraron resultados para "@{{paisoriSearchText}}".
                          </md-not-found>
                        </md-autocomplete></td>
                        <td><md-autocomplete md-search-text="ciupaisoriSearchText"
                                     md-items="ciudad in ciupaisoriSearch(ciupaisoriSearchText)"
                                     md-item-text="ciudad.Ciudad"
                                     md-selected-item="solicitud.detsoliInt.ciuorigen"
                                     md-min-length="0"
                                     >
                          <md-item-template>
                            <span md-highlight-text="ciupaisoriSearchText" md-highlight-flags="^i">@{{ciudad.Ciudad}}</span>
                          </md-item-template>
                          <md-not-found>
                            No se encontraron resultados para "@{{ciupaisoriSearchText}}".
                          </md-not-found>
                        </md-autocomplete></td>
                        <td><md-autocomplete md-search-text="paisdestSearchText"
                                     md-items="paisdest in paisdestSearch(paisdestSearchText)"
                                     md-item-text="paisdest.Pais"
                                     md-selected-item="solicitud.detsoliInt.pdestino"
                                     md-min-length="0"
                                     >
                          <md-item-template>
                            <span md-highlight-text="paisSearchText" md-highlight-flags="^i">@{{paisdest.Pais}}</span>
                          </md-item-template>
                          <md-not-found>
                            No se encontraron resultados para "@{{paisdestSearchText}}".
                          </md-not-found>
                        </md-autocomplete></td>
                        <td><md-autocomplete md-search-text="ciupaisdestSearchText"
                                     md-items="ciudaddest in ciupaisdestSearch(ciupaisdestSearchText)"
                                     md-item-text="ciudaddest.Ciudad"
                                     md-selected-item="solicitud.detsoliInt.ciudestino"
                                     md-min-length="0"
                                     >
                          <md-item-template>
                            <span md-highlight-text="ciupaisdestSearchText" md-highlight-flags="^i">@{{ciudaddest.Ciudad}}</span>
                          </md-item-template>
                          <md-not-found>
                            No se encontraron resultados para "@{{ciupaisdestSearchText}}".
                          </md-not-found>
                        </md-autocomplete></td>
                        <td><input class="form-control" mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
                          placeholder="Fecha y Hora de Viaje" show-todays-date="" min-date="date" ng-model="solicitud.detsoliInt.fviaje" class=" md-input" short-time ="true"
                          readonly="readonly"></td>
                        <td><select class="form-control" ng-model="solicitud.detsoliInt.hotel">
                          <option value="">Seleccione ..</option>
                          <option value="S">Si</option>
                          <option value="N">No</option>
                        </select></td>
                        <td ng-if = "solicitud.detsoliInt.hotel == 'S'"><input type="number" class="form-control" ng-model="detsoliInt.nodias"></td>
                        <td><button type="button" class="btn btn-success btn-sm" ng-click="AgregarTramoInternacional(solicitud.detsoliInt)">
                              <i class="glyphicon glyphicon-plus"></i>
                            </button></td>
                      </tr>
                      <tr ng-repeat="detInt in detallesolInt">
                          <td>@{{detInt.porigen}}</td>
                          <td>@{{detInt.ciuorigen}}</td>
                          <td>@{{detInt.pdestino}}</td>
                          <td>@{{detInt.ciudestino}}</td>
                          <td>@{{detInt.fviaje}}</td>
                          <td>@{{detInt.hotel}}</td>
                          <td >@{{detInt.hotel != 'N' ? detInt.nodias : 'N/A'}}</td>
                          <td><button class="btn btn-danger btn-sm" type="button" ng-click="QuitarTramoInt(detInt)">
                                <i class="glyphicon glyphicon-remove"></i>
                              </button></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- Fin Detalle Solicitud Viaje Internacional -->
                </div>
            </div>
          </div>
        @if(isset($solicitudes))
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
            <button type="button" ng-click="editarSolicitud(false)" class="btn btn-success pull-right">Guardar y Enviar</button>
          </div>
          @else
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
            <button type="button" ng-click="saveSolicitud(false)" class="btn btn-success pull-right">Guardar y Enviar</button>
          </div>
        @endif
        @include('layouts.tiquetes.solicitud.modifica')
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>

  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/tiquetes/crearSolicitudCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
