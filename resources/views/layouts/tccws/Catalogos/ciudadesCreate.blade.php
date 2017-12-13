<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="ciudadForm" ng-submit="ciudadForm.$valid && saveCiudad()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="isEdit == false">Creación de ciudades</h4>
          <h4 class="modal-title" ng-if="isEdit == true">Edición de ciudades</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Codigo del Dane:*</label>
            <input class="form-control" ng-disabled="isEdit == true" required ng-model="ciudad.ctc_cod_dane"/>
          </div>
          <div class="form-group">
            <label class="control-label">Nombre del Departamento:*</label>
            <md-select ng-disabled="isEdit == true" ng-model="ciudad.ctc_dept_erp">
              <md-option ng-value="depto" ng-repeat="depto in deptoErp">@{{depto}}</md-option>
            </md-select>
          </div>
          <div class="form-group" ng-if="ciudad.ctc_dept_erp != NULL">
            <label class="control-label">Nombre de la Ciudad:*</label>
            <md-select ng-model="ciudad.ctc_ciu_erp">
              <md-option ng-value="ciud.des_ciudad" ng-repeat="ciud in ciuErp | filter : {desc_depto : ciudad.ctc_dept_erp}">@{{ciud.des_ciudad}}</md-option>
            </md-select>
          </div>

          <!--<div class="form-group">
            <label class="control-label">Nombre de la Ciudad:*</label>
            <input class="form-control" required ng-model="ciudad.ctc_ciu_erp"/>
          </div>-->
          <div class="modal-footer">
            <button class="btn btn-primary" ng-if="isEdit == false" type="submit">Guardar
            </button>
            <button class="btn btn-primary" ng-if="isEdit == true" type="submit">Actualizar
            </button>
            <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>