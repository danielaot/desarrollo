<!-- Modal -->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="actividadForm" ng-submit="actividadForm.$valid && saveActividad()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="actividad.id == undefined">Creación de Actividades</h4>
          <h4 class="modal-title" ng-if="actividad.id != undefined">Edición de Actividades</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Titulo :</label>
            <input type="text" class="form-control" ng-model="actividad.act_titulo" required/>
          </div>
          <div class="form-group">
            <label class="control-label">Descripción :</label>
            <textarea class="form-control" ng-model="actividad.act_descripcion" rows="2" required></textarea>
          </div>
          <div class="row">
            <div class="col-sm-4 form-group">
              <label class="control-label">Área Responsable :</label>
              <select class="form-control" ng-model="actividad.act_ar_id" ng-options="option.ar_nombre for option in areas track by option.id" required></select>
            </div>
            <div class="col-sm-4 form-group">
              <label class="control-label">Actividad Predecesora :</label>
              <select class="form-control" ng-model="actividad.pre_act_pre_id" ng-options="option.act_titulo for option in (actividades | filter:  { act_proc_id : actividad.act_proc_id } ) track by option.id"><option value=""></option></select>
            </div>
            <div class="col-sm-4 form-group">
              <label class="control-label">Plantilla :</label>
              <input type="text" class="form-control" ng-model="actividad.act_plantilla" required/>
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
