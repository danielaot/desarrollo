<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="clienteForm" ng-submit="clienteForm.$valid && saveCliente()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="cliente.id == undefined">Creación de Clientes</h4>
          <h4 class="modal-title" ng-if="cliente.id != undefined">Edición de Clientes</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Nit ó Razon Social del Cliente<span class="required">*</span> :</label>
            <p  ng-if="cliente.id != undefined">@{{cliente.terceros.razonSocialTercero}}</p>
            <md-autocomplete ng-if="cliente.id == undefined"
                             md-search-text="terceroSearchText"
                             md-items="tercero in clientesSearch(terceroSearchText)"
                             md-item-text="[tercero.idTercero,tercero.razonSocialTercero].join(' - ')"
                             md-selected-item="cliente.tercero"
                             md-min-length="0"
                             md-no-cache="true"
                             required>
              <md-item-template>
                <span md-highlight-text="terceroSearchText" md-highlight-flags="^i">@{{[tercero.idTercero,tercero.razonSocialTercero].join(' - ')}}</span>
              </md-item-template>
              <md-not-found>
                No se encontraron resultados para "@{{terceroSearchText}}".
              </md-not-found>
            </md-autocomplete>
          </div>
          <div class="form-group">
            <label class="control-label">Seleccione tipo de pricat que aplica para el cliente<span class="required">*</span> :</label><br>
            <label class="checkbox-inline">
              <input type="checkbox" ng-model="cliente.codificacion"/> Codificación
            </label>
            <label class="checkbox-inline">
              <input type="checkbox" ng-model="cliente.modificacion"/> Modificación
            </label>
            <label class="checkbox-inline">
              <input type="checkbox" ng-model="cliente.eliminacion"/> Eliminación
            </label>
          </div>
          <div class="form-group">
            <label class="control-label">KAM<span class="required">*</span> :</label>
            <md-autocomplete md-search-text="kamSearchText"
                             md-items="tercero in clientesSearch(kamSearchText)"
                             md-item-text="[tercero.idTercero,tercero.razonSocialTercero].join(' - ')"
                             md-selected-item="cliente.kam"
                             md-min-length="0"
                             required>
              <md-item-template>
                <span md-highlight-text="kamSearchText" md-highlight-flags="^i">@{{[tercero.idTercero,tercero.razonSocialTercero].join(' - ')}}</span>
              </md-item-template>
              <md-not-found>
                No se encontraron resultados para "@{{kamSearchText}}".
              </md-not-found>
            </md-autocomplete>
          </div>
          <div class="form-group">
            <label class="control-label">GLN<span class="required">*</span> :</label>
            <input type="number" class="form-control" ng-model="cliente.gln" required/>
          </div>
          <div class="form-group">
            <label class="control-label">Lista Precio<span class="required">*</span> :</label>
            <md-autocomplete md-search-text="listaSearchText"
                             md-items="lista in listaSearch(listaSearchText)"
                             md-item-text="[lista.f112_id,lista.f112_descripcion].join(' - ')"
                             md-selected-item="cliente.lista"
                             md-min-length="0"
                             md-no-cache="true"
                             required>
              <md-item-template>
                <span md-highlight-text="listaSearchText" md-highlight-flags="^i">@{{[lista.f112_id,lista.f112_descripcion].join(' - ')}}</span>
              </md-item-template>
              <md-not-found>
                No se encontraron resultados para "@{{listaSearchText}}".
              </md-not-found>
            </md-autocomplete>
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
