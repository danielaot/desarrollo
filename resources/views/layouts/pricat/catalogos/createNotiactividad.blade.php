<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="notificacionForm" ng-submit="notificacionForm.$valid && saveNotificacion()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="notificacion.id == undefined">Creación de Notificación por Actividad</h4>
          <h4 class="modal-title" ng-if="notificacion.id != undefined">Edición de Notificación por Actividad</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Actividad :</label>
            <select class="form-control" ng-model="notificacion.id" ng-value="notificacion.id" ng-options="option.act_titulo for option in actividad track by option.id" required></select>
          </div>
          <div class="form-group">
            <label class="control-label">Responsables :</label>
            <div class="input-group">
              <input type="text" class="form-control" ng-class="{'has-error':responsableError}" id="usuarios" ng-model="usuario"/>
              <span class="input-group-btn">
                <button class="btn btn-success" type="button" ng-click="addResponsable()">Agregar</button>
              </span>
              {!! Form::hidden('url', route('autocomplete'), ['id' => 'url']) !!}
            </div>
            <span ng-show="responsableError" class="help-block error-help-block">
              Es necesario agregar al menos un responsable.
            </span>
          </div>
          <div class="form-group">
            <div class="panel panel-primary">
              <div class="panel-heading">Encargados</div>
              <div class="panel-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Cédula</th>
                      <th>Nombre</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="responsable in responsables">
                      <td>@{{responsable.dir_txt_cedula}}</td>
                      <td>@{{responsable.dir_txt_nombre}}</td>
                      <td class="text-right">
                        <button class="btn btn-danger btn-sm" ng-click="deleteResponsable(responsable.dir_id)">
                          <i class="glyphicon glyphicon-trash"></i> Borrar
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
