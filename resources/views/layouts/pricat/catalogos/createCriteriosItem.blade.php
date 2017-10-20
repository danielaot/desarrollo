<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="criterioForm" ng-submit="criterioForm.$valid && saveCriterio()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="criterio.id == undefined">Creación de Criterios</h4>
          <h4 class="modal-title" ng-if="criterio.id != undefined">Edición de Criterios</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Nombre:</label>
            <p ng-if="criterio.id != undefined">&nbsp;@{{titulo}}</p>
            <select ng-if="criterio.id == undefined" class="form-control" ng-model="criterio.plan" ng-options="option.nombreCriterioPlan for option in planes track by option.idCriterioPlan" required></select>
          </div>
          <div class="form-group">
            <label class="control-label">Columna del UnoE :</label>
            <input type="text" class="form-control" ng-model="criterio.cri_col_unoe" required/>
          </div>
          <div class="form-group">
            <label class="control-label">Seleccione para que tipo de producto aplica el criterio :</label><br>
            <label class="checkbox-inline">
              <input type="checkbox" ng-model="criterio.cri_regular"/> Regular
            </label>
            <label class="checkbox-inline">
              <input type="checkbox" ng-model="criterio.cri_estuche"/> Estuche
            </label>
            <label class="checkbox-inline">
              <input type="checkbox" ng-model="criterio.cri_oferta"/> Oferta
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary"  ng-if="criterio.id == undefined" type="submit">Guardar</button>
          <button class="btn btn-primary"  ng-if="criterio.id != undefined" type="submit">Editar</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
