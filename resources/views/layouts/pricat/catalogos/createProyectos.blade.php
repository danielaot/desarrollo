<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="proyectoForm" ng-submit="proyectoForm.$valid && saveProyecto()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Creación de Proyectos</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="proy_nombre" class="control-label">Nombre :</label>
            <input type="text" name="proy_nombre" ng-model="proyecto.proy_nombre" class="form-control" required/>
          </div>
          <div class="form-group">
            <label for="proy_descripcion" class="control-label">Descripción :</label>
            <textarea name="proy_descripcion" ng-model="proyecto.proy_descripcion" class="form-control" rows="2" required></textarea>
          </div>
          <div class="form-group">
            <label for="proy_proceso" class="control-label">Proceso :</label>
            <select name="proy_proceso" ng-model="proyecto.proy_proc_id" class="form-control" ng-options="option.pro_nombre for option in procesos track by option.id" required></select>
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
