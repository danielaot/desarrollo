<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form name="regresarForm" ng-submit="regresarForm.$valid && enviarSolicitud()" novalidate>
      <input type="hidden" ng-model="prueba" ng-value="@{{proyecto.proyectos.id}}">
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Solicitud Regresar Paso</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>Observación :</label>
              <textarea class="form-control" rows="5" ng-model="observacion"></textarea>
            </div>
            <!-- Inicio checkbox pasos proyecto -->
            <div ng-if="grupoCheckboxPredecesores.length > 0" layout="row" layout-wrap flex>
               <div class="demo-select-all-checkboxes" flex="100" ng-repeat="acti in grupoCheckboxPredecesores">
                 <md-checkbox ng-checked="exists(acti, selected)" ng-click="toggle(acti, selected)">
                  @{{ acti.act_titulo }}
                 </md-checkbox>
               </div>
             </div>
            <!--fin checkbox pasos proyecto -->
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Enviar Solicitud</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
