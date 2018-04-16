<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="palabraForm" ng-submit="palabraForm.$valid && savePalabra()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="palabra.id == undefined">Creación de Palabra</h4>
          <h4 class="modal-title" ng-if="palabra.id != undefined">Edición de Palabra</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Palabra :</label>
            <input class="form-control" type="text" ng-model="palabra.tvoc_palabra" required/>
          </div>
          <div class="form-group">
            <label class="control-label">Abreviatura :</label>
            <input class="form-control" type="text" ng-model="palabra.tvoc_abreviatura" required/>

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
