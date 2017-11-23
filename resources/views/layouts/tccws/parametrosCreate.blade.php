<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="parametroForm" ng-submit="parametroForm.$valid && saveParametro()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="isEdit == false">Creación de parametros</h4>
          <h4 class="modal-title" ng-if="isEdit == true">Edición de parametros</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label class="control-label">Nombre del parametro en el campo de TCC:*</label>
              <input class="form-control" ng-disabled="isEdit == true" required ng-model="parametro.par_campoTcc"/>
            </div>
            <div class="form-group">
              <label class="control-label">Valor del parametro:*</label>
              <input class="form-control" required ng-model="parametro.par_valor"/>
            </div>
        <div class="modal-footer">
          <button class="btn btn-primary" ng-if="isEdit == false" type="submit">Guardar</button>
          <button class="btn btn-primary" ng-if="isEdit == true" type="submit">Actualizar</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>