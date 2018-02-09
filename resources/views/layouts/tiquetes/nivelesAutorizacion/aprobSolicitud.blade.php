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
            <p class="col-sm-4"><label>Fecha de Solicitud:</label></p>
            <p class="col-sm-8">@{{aprobacionSolicitud.detallesolicitud.solIntFecha}}</p>
          </div>
          <div class="row">
            <p class="col-sm-2"><label>Solicitante:</label></p>
            <p class="col-sm-10">@{{aprobacionSolicitud.detallepernivel.pen_nombre}}</p>
          </div>
          <div class="row">
            <p class="col-sm-2"><label>Evaluacion:</label></p>
            <p class="col-sm-10">Evaluacion</p>
          </div>
          <div class="row">
            <p class="col-sm-2"><label>Observaciones:</label></p>
            <p class="col-sm-10">Observaciones</p>
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
