<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="segmentoForm" ng-submit="segmentoForm.$valid && saveSegmento()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="cliente.id == undefined">Creación de Segmentos</h4>
          <h4 class="modal-title" ng-if="cliente.id != undefined">Edición de Segmentos</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Nombre<span class="required">*</span> :</label>
            <input type="text" class="form-control" ng-model="segmento.cse_nombre" required/>
          </div>
          <div class="form-group">
            <label class="control-label">Campo Base de Datos :</label>
            <input type="text" class="form-control" ng-model="segmento.cse_campo"/>
          </div>
          <div class="form-group">
            <label class="control-label">Segmento Pricat<span class="required">*</span> :</label>
            <input type="text" class="form-control" ng-model="segmento.cse_segmento" required/>
          </div>
          <div class="form-group">
            <label class="control-label">Grupo<span class="required">*</span> :</label>
            <select class="form-control" ng-model="segmento.cse_grupo">
              <option value="a">Encabezado</option>
              <option value="b">Amarillo</option>
              <option value="c">Gris</option>
              <option value="d">Verde</option>
              <option value="z">Cierre</option>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Tipo de Novedad<span class="required">*</span> :</label>
            <select class="form-control" ng-model="segmento.cse_tnovedad">
              <option value="codificacion">Codificación</option>
              <option value="activacion">Activación</option>
              <option value="suspension">Suspensión</option>
              <option value="precios">Cambio de Precios</option>
              <option value="eliminacion">Eliminación</option>
            </select>
          </div>
          <div class="form-group" ng-if="segmento.cse_orden != undefined">
            <label class="control-label">Orden<span class="required">*</span> :</label>
            <select class="form-control" ng-model="segmento.cse_orden" required>
              <option value="@{{i}}" ng-repeat="i in [] | range : cantsgtos : 1">@{{i}}</option>
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
