<!--Modal-->
<div class="modal fade" id="modalinfo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog"  style="width: 70% !important;" role="document">
    <div class="modal-content panel-primary">
      <!--Titulo del modal-->
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Detalle de Tiquetes</h4>
      </div>
      <!--Fin Titulo del modal-->
      <div class="modal-body">
        <!--Encabezado del modal-->
        <h3>Solicitud No. @{{infoCompleta.sni_idsolicitud}}</h3>
        <div class="row">
          <div class="col-sm-6">
            <ul class="list-group">
              <li class="list-group-item">
                <label>Fecha de solicitud: </label>  @{{(infoCompleta.detallesolicitud.solIntFecha) * (1000) | date:'dd-MM-yyyy'}}
              </li>
            </ul>
          </div>
          <div class="col-sm-6">
            <ul class="list-group">
              <li class="list-group-item">
                <label>Estado: </label>  @{{infoCompleta.detallesolicitud.estados.estTxtNombre}}
              </li>
            </ul>
          </div>
        </div>
        <!--Fin Encabezado del modal-->
        <!--Empiezan las pestañas del modal-->
        <md-tabs md-dynamic-height md-border-bottom>
          <!--Pestaña No.1 Historial-->
          <md-tab label="Historial">
            <md-content class="md-padding">
              <div class="table-responsive" style="font-size: 11px;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Usuario Genera</th>
                      <th>Estado Actual</th>
                      <th>Usuario Revisa</th>
                      <th>Observaciones</th>
                    </tr>
                  </thead>
                    <!--Ingresar informacion historica de la solicitud-->
                  <tbody>
                    <tr ng-repeat="historial in infoCompleta.detallesolicitud.evaluaciones | orderBy : '-evaIntFecha'">
                      <td>@{{historial.evaIntFecha * (1000) | date:'dd-MM-yyyy'}}</td>
                      <td>@{{historial.evaTxtNomterAnt}}</td>
                      <td>@{{historial.estado.estTxtNombre}}</td>
                      <td>@{{historial.evaTxtnombreter}}</td>
                      <td>@{{historial.evatxtObservacione}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </md-content>
          </md-tab>
          <!--Pestaña No.2 Detalle. Solicitud-->
          <md-tab label="Detalle" md-active="reset == true" md-on-deselect="resetTab()">
            <md-content class="md-padding">
              <div class="col-sm-12">
                <!--Panel Informacion Viajero-->
                <div class="panel panel-primary">
                  <div class="panel-heading" style="text-align:center">Información Viajero</div>
                  <div class="panel-body">
                    <div class="form-group">
                      <div class="row">
                        <p class="col-sm-2"><label>Viajero :</label></p>
                        <p class="col-sm-4">@{{infoCompleta.detallesolicitud.solTxtNomtercero}}</p>
                        <p class="col-sm-3"><label>Nit o Cédula :</label></p>
                        <p class="col-sm-3">@{{infoCompleta.detallesolicitud.solTxtCedtercero}}</p>
                      </div>
                      <div class="row">
                        <p class="col-sm-2"><label>Email :</label></p>
                        <p class="col-sm-4">@{{infoCompleta.detallesolicitud.solTxtEmail}}</p>
                        <p class="col-sm-3"><label>Fecha de Nacimiento:</label></p>
                        <p class="col-sm-3">@{{(infoCompleta.detallesolicitud.solIntFNacimiento) * (1000) | date:'dd-MM-yyyy'}}</p>
                      </div>
                      <div class="row">
                        <p class="col-sm-2"><label>Teléfono :</label></p>
                        <p class="col-sm-4">@{{infoCompleta.detallesolicitud.solTxtNumTelefono}}</p>
                      </div>
                      <div class="row">
                        <p class="col-sm-2"><label>Motivo del Viaje:</label></p>
                        <p class="col-sm-10">@{{infoCompleta.detallesolicitud.solTxtObservacion}}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Panel Información del Viajero Externo -->
                <div class="panel panel-primary" ng-if="infoCompleta.per_externa != null">
                  <div class="panel-heading" style="text-align:center">Información del Viajero Externo</div>
                  <div class="panel-body">
                    <div class="form-group">
                      <div class="row">
                        <p class="col-sm-2"><label>Identificacion:</label></p>
                        <p class="col-sm-4">@{{infoCompleta.per_externa.pereTxtCedula}}</p>
                        <p class="col-sm-3"><label>Fecha Nacimiento :</label></p>
                        <p class="col-sm-3">@{{infoCompleta.per_externa.pereTxtFNacimiento}}</p>
                      </div>
                      <div class="row">
                        <p class="col-sm-2"><label>Nombre :</label></p>
                        <p class="col-sm-4">@{{infoCompleta.per_externa.pereTxtNombComple}}</p>
                        <p class="col-sm-3"><label>Número de Celular :</label></p>
                        <p class="col-sm-3">@{{infoCompleta.per_externa.pereTxtNumCelular}}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Panel Información detallada del vuelo -->
                <div class="panel panel-primary">
                  <div class="panel-heading" style="text-align:center">Información Detallada del Vuelo</div>
                  <div class="panel-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Origen</th>
                          <th>Destino</th>
                          <th>Fecha</th>
                          <th>Hotel</th>
                        </tr>
                      </thead>
                      <tbody ng-repeat = "det in infoCompleta.detallesolicitud.detalle">
                        <td>@{{det.ciu_origen.ciuTxtNom}}</td>
                        <td>@{{det.ciu_destino.ciuTxtNom}}</td>
                        <td>@{{(det.dtaIntFechaVuelo) * (1000) | date:'dd-MM-yyyy'}}</td>
                        <td>@{{det.dtaTxtHotel}}</td>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!--Panel Información general Creador de solicitud -->
                <div class="panel panel-primary">
                  <div class="panel-heading" style="text-align:center">Información General Creador de Solicitud</div>
                  <div class="panel-body">
                    <div class="form-group">
                      <div class="row">
                        <p class="col-sm-2"><label>Nombre :</label></p>
                        <p class="col-sm-4">@{{infoCompleta.detallesolicitud.per_crea.razonSocialTercero}}</p>
                        <p class="col-sm-3"><label>Nit o Cédula :</label></p>
                        <p class="col-sm-3">@{{infoCompleta.detallesolicitud.solTxtCedterceroCrea}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </md-content>
          </md-tab>
          <!--Pestaña No.3 Ruta Aprobacion-->
          <md-tab label="Ruta Aprobación">
            <md-content class="md-padding">
              <div class="container-fluid">
                <ul class="timeline" ng-repeat="(key, rutaAprobacion) in infoCompleta.detallesolicitud.evaluaciones">
                  <li class="@{{saberSiEsParClass(key)}}">
                    <div class="timeline-badge success">
                      <i class="glyphicon glyphicon-thumbs-up"></i>
                    </div>
                    <div class="timeline-panel">
                      <div class="timeline-heading">
                        <h5 class="timeline-title"><label>@{{key + 1}} - @{{rutaAprobacion.evaTxtNomterAnt}}</label></h5>
                        <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> @{{(rutaAprobacion.evaIntFecha) * (1000) | date:'yyyy-MM-dd HH:mm:ss'}}</small></p>
                      </div>
                      <div class="timeline-body">
                        <h6>@{{rutaAprobacion.eva_txt_observacion}}</h6>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </md-content>
          </md-tab>
          <!--Pestaña No.4 Reserva-->
          <md-tab label="Reserva">
            <md-content class="md-padding">
              <div class="panel panel-primary">
                <div class="panel-heading" style="text-align:center">Información Detallada del Vuelo
                </div>
                <div class="panel-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th>Aerolinea</th>
                        <th># Reserva / # Tiquete</th>
                      </tr>
                    </thead>
                    <tbody ng-repeat = "det in infoCompleta.detallesolicitud.detalle">
                      <td>@{{det.ciu_origen.ciuTxtNom}}</td>
                      <td>@{{det.ciu_destino.ciuTxtNom}}</td>
                      <td>@{{(det.dtaIntFechaVuelo) * (1000) | date:'dd-MM-yyyy'}} - @{{(det.dtaIntHoravuelo) * (1000) | date:'HH:mm:ss'}}</td>
                      <td>@{{det.aerolinea.aerTxtNombre}}</td>
                      <td>@{{det.dtaTxtResvuelo}}</td>
                    </tbody>
                  </table>
                </div>
              </div>
            </md-content>
          </md-tab>
          <!--Pestaña No.5 Info Facturacion-->
          <md-tab label="Info Facturación">
            <md-content class="md-padding">
              <div class="panel panel-primary">
                <div class="panel-heading" style="text-align:center">Información Facturación
                </div>
                <div class="panel-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Tipo de Pago</th>
                        <th>Factura / Ticket</th>
                        <th>Fecha</th>
                        <th>Nombre Proveedor</th>
                        <th>Identificacion</th>
                        <th>Observaciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <td>@{{infoCompleta.pago.tipo_pago.tipTxtNomTipo}}</td>
                      <td>@{{infoCompleta.pago.pagTxtFactura}}</td>
                      <td>@{{infoCompleta.pago.pagIntFecha}}</td>
                      <td>@{{infoCompleta.pago.pagTxtNomProveedor}}</td>
                      <td>@{{infoCompleta.pago.pagTxtCedProveedor}}</td>
                      <td>@{{infoCompleta.pago.pagTxtObservacion}}</td>
                    </tbody>
                  </table>
                </div>
              </div>
            </md-content>
          </md-tab>
        </md-tabs>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" type="button">Cerrar</button>
      </div>
    </div>
  </div>
</div>
