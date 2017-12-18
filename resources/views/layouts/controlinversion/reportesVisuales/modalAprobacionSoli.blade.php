<!-- Modal -->
<style media="screen">
  .row{
    margin-bottom: 8px !important;
  }
  textarea {
    resize: none;
  }
</style>
<div class="modal fade" id="modalAprobar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form name="aprobacionForm" ng-submit="aprobacionForm.$valid && enviarAprobacion()" novalidate>
        <div class="modal-content panel-primary">


            <div class="modal-header panel-heading">
              <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Aprobación de Solicitud</h4>
            </div>

            <div class="modal-body">

              <div class="container-fluid">
                <div class="form-group">

                  <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label>Solicitud No.</label>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                      @{{solicitud.sci_id}}
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label>Fecha de Solicitud</label>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                      @{{solicitud.sci_fecha | date: 'dd/MM/yyyy'}}
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label>Facturar A:</label>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                      @{{solicitud.facturara.tercero.razonSocialTercero}}
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label>Evaluación:</label>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                      <select required class="form-control" ng-model="solicitud.estadoSolicitud" ng-options='opt.soe_descripcion for opt in estados track by opt.soe_id'>
                        <option value=''>Seleccione...</option>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <label>Observaciones:</label>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                      <textarea class="form-control" ng-model="solicitud.observacionEnvio" cols="50" rows="3"></textarea>
                    </div>
                  </div>


                </div>
              </div>


            </div>

            <div class="modal-footer">
              <button class="btn btn-success" type="submit">Enviar</button>
              <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
            </div>


        </div>
      </form>
  </div>
</div>
