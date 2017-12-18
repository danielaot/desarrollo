<!-- Modal -->
<style>
.col-sm-6{
  padding-right: 0px;
  padding-left: 0px;
}

.md-tab {
    max-width: min-content !important;
}
</style>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;" role="document">
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Detalle de la Solicitud - @{{solicitud.tipo_salida.tsd_descripcion}}</h4>
        </div>

        <div class="modal-body">

          <h3>Solicitud No. @{{solicitud.sci_id}} / Estado:  @{{solicitud.estado.soe_descripcion}}</h3>
          <p></p>

          <md-tabs md-dynamic-height md-border-bottom>
            <md-tab label="Historial de proceso">
              <md-content class="md-padding">
                <div class="table-responsive">
                <table class="table table-striped">
    	          	<thead>
                    <tr>
                      <th>Fecha Envio</th>
                      <th>Estado</th>
                      <th>Usuario Envia</th>
                      <th>Usuario Recibe</th>
                      <th>Observaciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="hist in solicitud.historico | orderBy : hist.soh_fechaenvio : true">
                      <td>@{{hist.soh_fechaenvio  | date: 'dd/MM/yyyy HH:mm a'}}</td>
                      <td>@{{hist.estado.soe_descripcion}}</td>
                      <td>
                         @{{hist.per_nivel_envia.razonSocialTercero}}
                      </td>
                      <td>
                        @{{hist.per_nivel_recibe.razonSocialTercero}}
                      </td>
                      <td>@{{hist.soh_observacion}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              </md-content>
            </md-tab>
            <md-tab label="Info. de Solicitud">
              <md-content class="md-padding">
                <md-tabs>
                  <md-tab label="Datos Básicos">
                    <md-content class="md-padding">
                      <div class="row">
                        <div class="col-sm-6">
                          <ul class="list-group">
                            <li class="list-group-item">
                              <label>No. Solicitud: </label> @{{solicitud.sci_id}}
                            </li>
                            <li class="list-group-item">
                              <label>Fecha de solicitud: </label> @{{solicitud.sci_fecha | date: 'dd/MM/yyyy' }}
                            </li>
                            <li class="list-group-item">
                              <label>Tipo de Salida: </label> @{{solicitud.tipo_salida.tsd_descripcion}}
                            </li>
                            <li class="list-group-item">
                              <label>Tipo de Persona: </label> @{{solicitud.tipo_persona.tpe_tipopersona}}
                            </li>
                            <li class="list-group-item">
                              <label>Observaciones: </label> @{{solicitud.sci_observaciones}}
                            </li>
                          </ul>
                        </div>
                        <div class="col-sm-6">
                          <ul class="list-group">
                            <li class="list-group-item">
                              <label>Estado: </label> @{{solicitud.estado.soe_descripcion}}
                            </li>
                            <li class="list-group-item">
                              <label>Facturar a: </label> @{{solicitud.facturara.tercero.razonSocialTercero}}
                            </li>
                            <li class="list-group-item">
                              <label>Motivo: </label>
                              <span ng-if="solicitud.sci_mts_id == 7"> Salida de obsequios y muestras mercadeo</span>
                              <span ng-if="solicitud.sci_mts_id == 8"> Salida Eventos de Mercadeo</span>
                              <span ng-if="solicitud.sci_mts_id == 10"> Salida Probadores Mercadeo</span>
                            </li>
                            <li class="list-group-item">
                              <label>Carga a gasto: </label>@{{solicitud.cargara.cga_descripcion}}
                            </li>
                            <li class="list-group-item">
                              <label>Canal: </label> @{{solicitud.sci_can_desc}}
                            </li>
                          </ul>
                        </div>
                      </div>
                    </md-content>
                  </md-tab>
                  <md-tab label="Gasto Cargado a Lineas">
                    <md-content class="md-padding">

                      <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center">Linea Codigo</th>
                            <th class="text-center">Nombre de Linea</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="linea in lineasSolicitud">
                            <td class="text-center">@{{linea.linea_producto.lineas_producto.CodLinea}}</td>
                            <td class="text-center">@{{linea.linea_producto.lineas_producto.NomLinea}}</td>
                          </tr>
                          <!-- <tr ng-if="solicitud.cargaralinea != null">
                            <td class="text-center">@{{solicitud.cargaralinea.lineas_producto.CodLinea}}</td>
                            <td class="text-center">@{{solicitud.cargaralinea.lineas_producto.NomLinea}}</td>
                          </tr> -->
                        </tbody>
                      </table>
                    </div>

                    </md-content>
                  </md-tab>
                  <md-tab ng-if="solicitud.sci_tipopersona == 1" label="Zonas">
                    <md-content class="md-padding">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th colspan="2" class="text-center">Zonas</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr ng-repeat="zona in zonasSolicitud">
                              <td class="text-center">ZONA @{{zona.scz_zon_id}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </md-content>
                  </md-tab>
                  <md-tab label="Vendedores o Colaboradores">
                    <md-content class="md-padding">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th class="text-center">Colaborador ID</th>
                              <th class="text-center">Nombre Colaborador</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr ng-repeat="colaborador in solicitud.clientes">
                              <td class="text-center">@{{colaborador.scl_cli_id}}</td>
                              <td class="text-center">@{{colaborador.scl_nombre}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </md-content>
                  </md-tab>
                  <md-tab label="Referencias">
                    <md-content class="md-padding">

                      <md-tabs md-no-pagination="false">

                        <md-tab
                          ng-repeat="cliente in solicitud.clientes"
                          label="@{{cliente.scl_nombre}}">
                          <md-content>
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th class="text-center">Referencia</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Precio Unit.</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Linea a Cargar Gasto</th>
                                    <th class="text-center">Valor Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="referencia in cliente.clientes_referencias">
                                    <td class="text-left">@{{[referencia.referencia.ite_referencia,referencia.referencia.ite_descripcion].join(' - ')}}</td>
                                    <td class="text-left">@{{referencia.srf_estadoref}}</td>
                                    <td class="text-right">@{{referencia.srf_preciouni | currency: '$'}}</td>
                                    <td class="text-right">@{{referencia.srf_unidades}}</td>
                                    <td class="text-left">@{{referencia.linea_producto.lineas_producto.NomLinea}}</td>
                                    <td class="text-right">@{{(referencia.srf_preciouni * referencia.srf_unidades) | currency: '$'}}</td>
                                  </tr>
                                </tbody>
                              </table>
                              <hr>
                              <h3 class="text-right" style="font-weight: bold;">Total: @{{cliente.scl_ventaesperada | currency: '$' }}</h3>
                            </div>

                          </md-content>
                        </md-tab>

                      </md-tabs>

                    </md-content>
                  </md-tab>
                </md-tabs>
              </md-content>
            </md-tab>
          </md-tabs>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
  </div>
</div>
