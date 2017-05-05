<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="areaForm" ng-submit="areaForm.$valid && saveArea()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Creación de Área y Responsables</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="ar_nombre" class="control-label">Área :</label>
            <input type="text" name="ar_nombre" ng-model="area.ar_nombre" class="form-control" required/>
          </div>
          <div class="form-group">
            <label for="ar_descripcion" class="control-label">Descripción :</label>
            <textarea name="ar_descripcion" ng-model="area.ar_descripcion" class="form-control" rows="2" required></textarea>
          </div>
          <div class="form-group">
            <label for="usuario" class="control-label">Responsables :</label>
            <div class="input-group">
              <input type="text" name="usuario" id="usuarios" ng-model="usuario" class="form-control" ng-class="{'has-error':responsableError}"/>
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
          <button class="btn btn-primary" type="submit" ng-disabled="areaForm.$invalid">Guardar</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
