<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width: 60% !important;" role="document">
    <div class="modal-content panel-primary">
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Consulta de Remesas</h4>
      </div>

      <div class="modal-body">
        <div class="alert alert-info" ng-if="consulta.consulta.boomerang != null">
          <strong>¡Información!</strong> La remesa consultada presenta un Boomerang asociado.
        </div>
        <md-content>
          <md-tabs md-dynamic-height md-border-bottom>
            <md-tab label="Información general">
              <md-content class="md-padding">
                <md-content class="md-padding">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                          <label>Fecha de Remesa:</label>
                          <input ng-disabled="true" class="form-control" value="@{{consulta.consulta.created_at | date: 'shortDate'}}">

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                          <label>Sucursal:</label>
                          <input ng-disabled="true" class="form-control" value="EXITO">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                          <label>Número de Remesa:</label>
                          <input ng-disabled="true" class="form-control" value="@{{consulta.consulta.rms_remesa}}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" ng-if="consulta.consulta.boomerang != null">
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                          <label>Número de Remesa Boomerang:</label>
                          <input ng-disabled="true" class="form-control" value="@{{consulta.consulta.boomerang.rms_remesa}}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                      <label>Observaciones</label>
                      <textarea ng-disabled="true" class="form-control" maxlength="150" rows="5"></textarea>
                    </div>
                  </div>
                  </div>
                  </div>

                </md-content>
              </md-content>
            </md-tab>
            <md-tab label="Unidades Logisticas">
              <md-content class="md-padding">
                <md-content class="md-padding">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                            <label>Cajas:</label>
                            <input value="@{{consulta.consulta.rms_cajas}}" ng-disabled="true" class="form-control">
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Lios:</label>
                            <input value="@{{consulta.consulta.rms_lios}}" min="0" ng-disabled="true" class="form-control">
                          </div>
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Kilos Reales Lios:</label>
                            <input value="@{{consulta.consulta.rms_pesolios}}" ng-disabled="true" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Estibas:</label>
                            <input value="@{{consulta.consulta.rms_palets}}" ng-disabled="true" class="form-control">
                          </div>
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Kilos Reales Estibas:</label>
                            <input value="@{{consulta.consulta.rms_cajas}}" ng-disabled="true" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <h3 class="text-right" style="font-weight: bold;">Total Kilos: @{{consulta.consulta.rms_pesototal}}</h3>
                </md-content>
              </md-content>
            </md-tab>
            <md-tab label="Documentos Referentes">
              <md-content class="md-padding">
                <md-content class="md-padding">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                      <div class="form-group">
                        <div class="row">
                          <table class="table table-striped table-bordered">
                            <tr>
                              <th>Número de Remesa</th>
                              <th>Tipo de Documento</th>
                              <th>Número de Documento</th>
                            </tr>
                            <tr ng-repeat="factura in consulta.consulta.facturas">
                              <td>@{{consulta.consulta.rms_remesa}}</td>
                              <td>@{{factura.fxr_tipodocto}}</td>
                              <td>@{{factura.fxr_numerodocto}}</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </md-content>
              </md-content>
            </md-tab>
          </md-tabs>
        </md-content>
    </div>  
    <div class="modal-footer">
      <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
    </div> 
  </div>
</div>
</div>