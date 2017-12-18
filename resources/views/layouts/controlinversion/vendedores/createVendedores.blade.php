<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 65%;">
    <form name="vendedorForm" ng-submit="vendedorForm.$valid && saveVendedor()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="vendedor.id == undefined">Creación de Vendedores por Zona</h4>
          <h4 class="modal-title" ng-if="vendedor.id != undefined">Edición de Vendedores por Zona</h4>
        </div>

        <div class="modal-body">

          <div class="form-group">

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">

                <label class="control-label">Zona<span class="required">*</span> :</label>
                <select class='form-control' ng-model='vendedor.zona' ng-change="filtrarSubZonas()" ng-options='opt.NomZona for opt in zonas track by opt.CodZona'>
                  <option value=''>Seleccione...</option>
                </select>

              </div>

              <div ng-if="vendedor.zona != undefined" class="col-md-6 col-sm-6 col-xs-6 col-lg-6">

                <label class="control-label">Sub-Zona<span class="required">*</span> :</label>
                <select class='form-control' ng-model='vendedor.subzona' ng-change="filtrarVendedores()" ng-options='opt.NomSubZona for opt in subzonasfilter track by opt.CodSubZona'>
                  <option value=''>Seleccione...</option>
                </select>

              </div>

            </div>

          </div>

          <div class="form-group">

            <label class="control-label">Vendedor<span class="required">*</span> :</label>

            <md-autocomplete
                md-selected-item="itemVendedor"
                md-search-text="searchVendedor"
                md-items="vendedor in vendedorSearch(searchVendedor)"
                md-item-text="[vendedor.IdVendedor.trim(),vendedor.NomVendedor].join(' - ')"
                md-min-length="1"
                md-selected-item-change ="agregarVendedor(itemVendedor)"
                ng-disabled="!(vendedor.zona != undefined && vendedor.subzona != undefined)">

              <md-item-template>
                <span md-highlight-text="searchVendedor" md-highlight-flags="^i">@{{[vendedor.IdVendedor.trim(),vendedor.NomVendedor].join(' - ')}}</span>
              </md-item-template>

              <md-not-found>
                No se encontraror resultados para "@{{searchVendedor}}".
              </md-not-found>

            </md-autocomplete>

          </div>


          <div class="form-group" ng-if="vendedor.vendedores.length > 0">
            <div class="panel panel-primary">
              <div class="panel-heading">Vendedores por zona</div>
              <div class="panel-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nit Vendedor</th>
                      <th>Nombre Vendedor</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="vendedor in vendedor.vendedores">
                      <td>@{{vendedor.NitVendedor}}</td>
                      <td>@{{vendedor.NomVendedor}}</td>
                      <td>
                        <button type="button" ng-class="vendedor.estadoModificado == 1 ? 'btn btn-danger btn-sm' : 'btn btn-success btn-sm'" ng-click="vendedor.esNuevo == 0 ? inhabilitarVendedor(vendedor) : eliminarVendedor(vendedor)">
                            <i ng-class="vendedor.estadoModificado == 1 ? 'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok' "></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
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
