<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form name="marcaForm" ng-submit="marcaForm.$valid && saveMarca()" novalidate autocomplete="off">
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Creación de Marcas</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="mar_nombre" class="control-label">Nombre :</label>
            <input type="text" name="mar_nombre" ng-model="marca.mar_nombre" class="form-control" ng-class="{'has-error':errorNombreExist}" required/>
            <span ng-show="errorNombreExist" class="help-block error-help-block">
              Este nombre ya existe.
            </span>
          </div>
          <div class="form-group">
            <label class="control-label">Lineas :</label>
            <md-chips ng-model="marca.lineas" md-require-match="true">
              <md-autocomplete md-search-text="lineaSearchText"
                               md-items="linea in lineaSearch(lineaSearchText)"
                               md-item-text="linea.descripcionItemCriterioMayor"
                               md-no-cache="true"
                               md-min-length="0">
                <md-item-template>
                  <span md-highlight-text="lineaSearchText" md-highlight-flags="^i">@{{linea.descripcionItemCriterioMayor}}</span>
                </md-item-template>
              </md-autocomplete>
              <md-chip-template>
                <span>@{{$chip.descripcionItemCriterioMayor}}</span>
              </md-chip-template>
            </md-chips>
            <span ng-show="errorLineas" class="help-block error-help-block">
              Es necesario agregar al menos una linea.
            </span>
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
