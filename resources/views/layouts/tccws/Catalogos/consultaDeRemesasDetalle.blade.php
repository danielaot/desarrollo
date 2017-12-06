<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
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
                          <input ng-disabled="true" class="form-control" ng-model="cambiaFecha(consulta.consulta.created_at)">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                          <label>Sucursal:</label>
                          <input type="text" ng-disabled="true" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                          <label>Numero de Remesa:</label>
                          <input ng-disabled="true" class="form-control" ng-model="consulta.consulta.rms_remesa">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" ng-if="consulta.consulta.boomerang != null">
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                          <label>Numero de Remesa Boomerang:</label>
                          <input ng-disabled="true" class="form-control" ng-model="consulta.consulta.boomerang.rms_remesa">
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
                            <input type="number" ng-model="consulta.consulta.rms_cajas" ng-disabled="true" class="form-control">
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Lios:</label>
                            <input type="number" ng-model="consulta.consulta.rms_lios" min="0" ng-disabled="true" class="form-control">
                          </div>
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Kilos Reales Lios:</label>
                            <input type="number" ng-model="consulta.consulta.rms_pesolios" ng-disabled="true" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Estibas:</label>
                            <input type="number" ng-model="consulta.consulta.rms_palets" ng-disabled="true" class="form-control">
                          </div>
                          <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                            <label>Kilos Reales Estibas:</label>
                            <input type="number" ng-model="consulta.consulta.rms_cajas" ng-disabled="true" class="form-control">
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
                <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
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