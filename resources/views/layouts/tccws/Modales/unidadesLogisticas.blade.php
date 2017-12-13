<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width: 50% !important;" role="document">
    <form id="frmRemesa" name="frmRemesa" ng-submit="frmRemesa.$valid && enviarRemesa()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Preparación de Remesas</h4>
        </div>

        <div class="modal-body">

          <md-content>
            <md-tabs md-dynamic-height md-border-bottom>
              <md-tab label="@{{sucursal.nombre}}" ng-repeat="sucursal in cliente.arregloFinal.sucursalesFiltradas">
                <md-content class="md-padding">

                  <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                              <label>Cajas:</label>
                              <input type="number" ng-model="sucursal.objetoCajas.cantidadunidades" class="form-control" placeholder="Cantidad de Cajas">
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                              <label>Lios:</label>
                              <input type="number" ng-model="sucursal.objetoLios.cantidadunidades" ng-change="sumatoriaKilos(sucursal)" min="0" class="form-control" placeholder="Cantidad de Lios...">
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                              <label>Kilos Reales Lios:</label>
                              <input type="number" ng-model="sucursal.kilosRealesLios" ng-disabled="true" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                              <label>Estibas:</label>
                              <input type="number" ng-model="sucursal.objetoPaletas.cantidadunidades" class="form-control" placeholder="Cantidad de Estibas...">
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 col-xl-6">
                              <label>Kilos Reales Estibas:</label>
                              <input type="number" ng-disabled="sucursal.objetoPaletas.cantidadunidades == 0 || sucursal.objetoPaletas.cantidadunidades == undefined" ng-model="sucursal.kilosRealesEstibas" ng-change="sumatoriaKilos(sucursal)" class="form-control" placeholder="Peso total de Estibas (Kilos)...">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                        <label>Observaciones</label>
                        <textarea ng-model="sucursal.observacion" class="form-control" maxlength="150" rows="5"></textarea>
                      </div>
                    </div>

                    <hr>
                    <h3 class="text-right" style="font-weight: bold;">Total Kilos: @{{sucursal.sumaTotalKilos}}</h3>

                </md-content>
              </md-tab>
            </md-tabs>
          </md-content>

      </div>
        <div class="modal-footer">
          <button class="btn btn-primary" ng-disabled="pesosNoValidos" type="submit">Enviar Remesa</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
