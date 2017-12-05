<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="pruebaForm" ng-submit="pruebaForm.$valid && savePrueba()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Creación de pruebas</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label type="number" class="control-label">Digite el numero:*</label>
              <input class="form-control" required ng-model="prueba.prc_numero"/>
            </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
          </div>
        </div>
    </form>
  </div>
</div>