@extends('app')

@section('content')
  @include('includes.titulo')
  <link rel="stylesheet" href="{{url('/css/tiqueteshotel/tiqueteshotel.css')}}">
  <div ng-controller="crearSolicitudCtrl" ng-cloak class="cold-md-12">
    <hr>
    <form name="solicitudForm" ng-submit="solicitudForm.$valid && saveSolicitud()" novalidate>
    <div class="panel panel-primary">
      <div class="panel-heading" style="text-align:center">Información Solicitante</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6 form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Fecha Creación :</label>
                  <p>{{ date('Y-m-d H:i:s') }}</p>
                </div>
              </div>
              <div class="col-sm-6 form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Tipo Solicitud <span class="required">*</span>:</label>
                  <div class="col-sm-5">
                    <select class="form-control" ng-model="solicitud.tipo" ng-change="validateTipo()">
                      <option value="">Seleccione ...</option>
                      <option value="nuevo">Nuevo</option>
                      <option value="modificacion">Modificacion</option>
                    </select>
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
                               md-item-text="nombre.infopersona.perTxtNomtercero"
                               md-selected-item="solicitud.nombre"
                               md-selected-item-change="createInfo()"
                               md-min-length="0"
                               required>
                    <md-item-template>
                      <span md-highlight-text="nombreSearchText" md-highlight-flags="^i">@{{nombre.infopersona.perTxtNomtercero}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{nombreSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
                <div class="col-sm-6">
                  <label>Identificacion :</label>
                  <input type="text" class="form-control" ng-model="solicitud.nombre.infopersona.perTxtCedtercero" placeholder="Número de Identificacion" disabled>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <label>Email :</label>
                  <input type="text" class="form-control" ng-model="solicitud.nombre.infopersona.perTxtEmailter" placeholder="Email del Solicitante" disabled>
                </div>
                <div class="col-sm-6" ng-if = "solicitud.nombre != null">
                  <label>Fecha Nacimiento<span class="required">*</span>:</label>
                  <p>@{{(solicitud.nombre.infopersona.perTxtFechaNac) * (1000) | date:'dd-MM-yyyy'}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <label>Número Teléfono <span class="required">*</span>:</label>
                  <input type="number" class="form-control" ng-model="solicitud.numtelefono">
                </div>
                <div class="col-sm-6" ng-if = "solicitud.nombre != null">
                  <label>Aprobador <span class="required">*</span>:</label>
                  <select class="form-control" ng-model="solicitud.aprobador" ng-options='opt.aprueba.perTxtNomtercero for opt in persona track by opt.aprueba.perTxtNomtercero'>
                    <option value="">Seleccione aprobador ..</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <label>Tipo Viajero <span class="required">*</span>:</label>
                    <select class="form-control" ng-model="solicitud.tviajero">
                      <option value="">Seleccione el tipo de viajero ..</option>
                      <option value="interno">Interno Belleza</option>
                      <option value="externo">Persona Externa</option>
                    </select>
                </div>
                  <div class="col-sm-6">
                    <label>Tipo de Viaje <span class="required">*</span>:</label>
                    <select class="form-control" ng-model="solicitud.tviaje">
                      <option value="">Seleccione el tipo de viaje ..</option>
                      <option value="nacional">Nacional</option>
                      <option value="internacional">Internacional</option>
                    </select>
                  </div>
              </div>
              <div class="row" ng-if = "solicitud.tviajero == 'externo'">
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
              <div class="row" ng-if = "solicitud.tviajero == 'externo'">
                  <div class="col-sm-6">
                    <label>Nombre Completo <span class="required">*</span>:</label>
                    <input type="text" class="form-control" ng-model="solicitud.nomexterno">
                  </div>
                  <div class="col-sm-6">
                    <label>Correo Electronico <span class="required">*</span>:</label>
                    <input type="number" class="form-control" ng-model="solicitud.corexterno">
                  </div>
              </div>
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
                <div class="form-group">
                  <!-- Detalle Solicitud Viaje Nacional -->
                    <div class="row" ng-if = "solicitud.tviaje == 'nacional'">
                      <div class="col-sm-2">
                        <label>Origen <span class="required">*</span>:</label>
                        <select class="form-control" ng-model="detsoli.origen" ng-options='opt.ciuTxtNom for opt in ciudad track by opt.ciuIntId'>
                          <option value="">Seleccione Ciudad Origen ..</option>
                        </select>
                      </div>
                      <div class="col-sm-2">
                        <label>Destino <span class="required">*</span>:</label>
                        <select class="form-control" ng-model="detsoli.destino" ng-options='opt.ciuTxtNom for opt in ciudad track by opt.ciuIntId'>
                          <option value="">Seleccione Ciudad Destino ..</option>
                        </select>
                      </div>
                      <div class="col-sm-2">
                        <label>Fecha <span class="required">*</span>:</label>
                        <input class="form-control" mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
                          placeholder="Fecha y Hora de Viaje" show-todays-date="" min-date="date" ng-model="detsoli.fviaje" class=" md-input" short-time ="true"
                          readonly="readonly">
                      </div>
                      <div class="col-sm-2">
                        <label>Hotel <span class="required">*</span>:</label>
                        <select class="form-control" ng-model="detsoli.hotel">
                          <option value="">Seleccione ..</option>
                          <option value="si">Si</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                      <div class="col-sm-2">
                        <label>No. Días <span class="required">*</span>:</label>
                        <input type="number" class="form-control" ng-model="detsoli.nodias">
                    </div>
                  </div>
                  <!-- fin Detalle Solicitud Viaje Nacional -->
                  <!-- Detalle Solicitud Viaje Internacional -->
                  <div class="row" ng-if = "solicitud.tviaje == 'internacional'">
                    <div class="col-sm-2">
                      <label>Pais Origen <span class="required">*</span>:</label>
                      <md-autocomplete md-search-text="paisoriSearchText"
                                   md-items="pais in paisoriSearch(paisoriSearchText)"
                                   md-item-text="pais.Pais"
                                   md-selected-item="detsoli.porigen"
                                   md-min-length="0"
                                   required>
                        <md-item-template>
                          <span md-highlight-text="paisSearchText" md-highlight-flags="^i">@{{pais.Pais}}</span>
                        </md-item-template>
                        <md-not-found>
                          No se encontraron resultados para "@{{paisoriSearchText}}".
                        </md-not-found>
                      </md-autocomplete>
                    </div>
                    <div class="col-sm-2">
                      <label>Ciudad Origen <span class="required">*</span>:</label>
                      <md-autocomplete md-search-text="ciupaisoriSearchText"
                                   md-items="ciudad in ciupaisoriSearch(ciupaisoriSearchText)"
                                   md-item-text="ciudad.Ciudad"
                                   md-selected-item="detsoli.ciuorigen"
                                   md-min-length="0"
                                   required>
                        <md-item-template>
                          <span md-highlight-text="ciupaisoriSearchText" md-highlight-flags="^i">@{{ciudad.Ciudad}}</span>
                        </md-item-template>
                        <md-not-found>
                          No se encontraron resultados para "@{{ciupaisoriSearchText}}".
                        </md-not-found>
                      </md-autocomplete>
                    </div>
                    <div class="col-sm-2">
                      <label>Pais Destino <span class="required">*</span>:</label>
                      <md-autocomplete md-search-text="paisdestSearchText"
                                   md-items="paisdest in paisdestSearch(paisdestSearchText)"
                                   md-item-text="paisdest.Pais"
                                   md-selected-item="detsoli.pdestino"
                                   md-min-length="0"
                                   required>
                        <md-item-template>
                          <span md-highlight-text="paisSearchText" md-highlight-flags="^i">@{{paisdest.Pais}}</span>
                        </md-item-template>
                        <md-not-found>
                          No se encontraron resultados para "@{{paisdestSearchText}}".
                        </md-not-found>
                      </md-autocomplete>
                    </div>
                    <div class="col-sm-2">
                      <label>Ciudad Destino <span class="required">*</span>:</label>
                      <md-autocomplete md-search-text="ciupaisdestSearchText"
                                   md-items="ciudaddest in ciupaisdestSearch(ciupaisdestSearchText)"
                                   md-item-text="ciudaddest.Ciudad"
                                   md-selected-item="detsoli.ciudestino"
                                   md-min-length="0"
                                   required>
                        <md-item-template>
                          <span md-highlight-text="ciupaisdestSearchText" md-highlight-flags="^i">@{{ciudaddest.Ciudad}}</span>
                        </md-item-template>
                        <md-not-found>
                          No se encontraron resultados para "@{{ciupaisdestSearchText}}".
                        </md-not-found>
                      </md-autocomplete>
                    </div>
                    <div class="col-sm-2">
                      <label>Fecha <span class="required">*</span>:</label>
                      <input class="form-control" mdc-datetime-picker="" date="true" time="true" type="text" id="datetime"
                        placeholder="Fecha y Hora de Viaje" show-todays-date="" min-date="date" ng-model="detsoli.fviaje" class=" md-input" short-time ="true"
                        readonly="readonly">
                    </div>
                    <div class="col-sm-1">
                      <label>Hotel <span class="required">*</span>:</label>
                      <select class="form-control" ng-model="detsoli.hotel">
                        <option value="">Seleccione ..</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                      </select>
                    </div>
                    <div class="col-sm-1" ng-if = "detsoli.hotel == 'si'">
                      <label>No. Días <span class="required">*</span>:</label>
                      <input type="number" class="form-control" ng-model="detsoli.nodias">
                  </div>
                </div>
                <!-- fin Detalle Solicitud Viaje Internacional -->
              </div>
            </div>
          </div>
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>

  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/tiquetes/crearSolicitudCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
