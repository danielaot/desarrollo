<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="nivelesForm" ng-submit="nivelesForm.$valid && saveNiveles()" novalidate>
      <div class="modal-content panel-primary">
        <!--Titulo del modal-->
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="niveles.id == undefined">Creación Niveles de Aprobación</h4>
          <h4 class="modal-title" ng-if="niveles.id != undefined">Edición Niveles de Aprobación</h4>
        </div>
        <!--Fin Titulo del modal-->
        <div class="modal-body">
        <!--Formulario Creacion -->
          <div class="form-group">
            <label class="control-label">Tipo de Personas :</label>
            <select class="form-control" ng-model="nivel.tpersona" ng-options="option.tpp_descripcion for option in tpersona track by option.id" required></select>
          </div>
          <div class="form-group" ng-if="nivel.tpersona.id == '1'">
            <label class="control-label">Canal :</label>
            <select class="form-control" ng-model="nivel.canal" ng-options="option.can_txt_descrip for option in canal track by option.can_id" required></select>
          </div>
          <div class="form-group" ng-if="nivel.tpersona.id == '2'">
            <label class="control-label">Zona :</label>
            <select class="form-control" ng-model="nivel.zona" ng-options="option.zon_txt_descrip for option in zona track by option.zon_id" required></select>
          </div>
          <div class="form-group">
            <label class="control-label">Usuario :</label>

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
