<!--Modal-->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:40%;" role="document">
    <form name="aprobSolicitudForm" ng-submit="aprobSolicitudForm.$valid && saveAprobSolicitud()" novalidate>
      <div class="modal-content panel-primary">
        <!--Titulo del modal-->
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Aprobación de Solicitud</h4>
        </div>
        <!--Fin Titulo del modal-->
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
              <div class="form-group">
                <label>Fecha de Solicitud:</label>
                <span>@{{(aprobacionSolicitud.detallesolicitud.solIntFecha) * (1000) | date:'dd-MM-yyyy'}}</span>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
              <div class="form-group">
                <label>Solicitante:</label>
                <span>@{{aprobacionSolicitud.detallesolicitud.solTxtNomtercero}}</span>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
              <div class="form-group">
                <label>Evaluacion:</label>
                <select class="form-control" ng-model="aprobacionSolicitud.estado" ng-options='opt.estTxtNombre for opt in estados track by opt.id'>
                  <option value="">Seleccione ..</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
              <div class="form-group">
                <label>Observaciones:</label>
                <input type="text" class="form-control" ng-model="aprobacionSolicitud.motivo" placeholder="Ingrese una descripción a la solicitud">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
