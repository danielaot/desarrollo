<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="proyectoForm" ng-submit="proyectoForm.$valid && saveProyecto()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="proyecto.id == undefined">Creación de Proyectos</h4>
          <h4 class="modal-title" ng-if="proyecto.id != undefined">Edición de Proyectos</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Nombre :</label>
            <input class="form-control" type="text" ng-model="proyecto.proy_nombre" required/>
          </div>
          <div class="form-group">
            <label class="control-label" ng-if="proyecto.id == undefined">Proceso :</label>
            <select class="form-control" ng-if="proyecto.id == undefined" ng-model="proyecto.proy_proc_id" ng-options="option.pro_nombre for option in procesos track by option.id" required>
              <option value="">Seleccione...</option>
            </select>
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
