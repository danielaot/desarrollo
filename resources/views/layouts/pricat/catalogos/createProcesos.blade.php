<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="procesoForm" ng-submit="procesoForm.$valid && saveProceso()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="proceso.id == undefined">Creación de Procesos</h4>
          <h4 class="modal-title" ng-if="proceso.id != undefined">Edición de Procesos</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Nombre :</label>
            <input type="text" class="form-control" ng-model="proceso.pro_nombre" required/>
          </div>
          <div class="form-group">
            <label class="control-label">Descripción :</label>
            <textarea class="form-control" ng-model="proceso.pro_descripcion" rows="2" required></textarea>
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
