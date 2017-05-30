<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="notificacionForm" ng-submit="notificacionForm.$valid && save()" enctype="multipart/form-data" novalidate>
      {{ csrf_field() }}
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Creación de Notificación Sanitaria</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 form-group">
              <label class="control-label">Nombre<span class="required">*</span> :</label>
              <input type="text" ng-model="notificacion.nosa_nombre" class="form-control" required/>
            </div>
            <div class="col-sm-12 form-group">
              <label class="control-label">Código<span class="required">*</span> :</label>
              <input type="text" ng-model="notificacion.nosa_notificacion" class="form-control" required/>
            </div>
            <div class="col-sm-6 form-group">
              <label class="control-label">Fecha Inicio<span class="required">*</span> :</label>
              <input type="date" ng-model="notificacion.nosa_fecha_inicio" class="form-control" required/>
            </div>
            <div class="col-sm-6 form-group">
              <label class="control-label">Fecha Vencimiento<span class="required">*</span> :</label>
              <input type="date" ng-model="notificacion.nosa_fecha_vencimiento" class="form-control" required/>
            </div>
            <div class="col-sm-12 form-group">
              <label class="control-label">Archivo<span class="required">*</span> :</label>
              <input type="file" ng-model="notificacion.nosa_documento" class="form-control"/>
            </div>
            <div class="col-sm-12 form-group">
              <label class="control-label">Seleccionar Granel<span class="required">*</span> :</label>
              <div class="input-group">
                <md-autocomplete md-search-text="granelSearchText"
                                 md-items="granel in granelSearch(granelSearchText)"
                                 md-item-text="[granel.ite_txt_referencia,granel.ite_txt_descripcion].join(' - ')"
                                 md-selected-item="granel"
                                 md-min-length="1"
                                 md-menu-class="autocomplete">
                  <md-item-template>
                    <span md-highlight-text="granelSearchText" md-highlight-flags="^i">@{{[granel.ite_txt_referencia,granel.ite_txt_descripcion].join(' - ')}}</span>
                  </md-item-template>
                  <md-not-found>
                    No se encontraron resultados para "@{{granelSearchText}}".
                  </md-not-found>
                </md-autocomplete>
                <span class="input-group-btn">
                  <button class="btn btn-success" type="button" ng-click="addGranel()">Agregar</button>
                </span>
              </div>
            </div>
            <div class="col-sm-12 form-group">
              <div class="panel panel-primary">
                <div class="panel-heading">Graneles</div>
                <div class="panel-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="granel in notigraneles">
                        <td>@{{granel.ite_txt_referencia}}</td>
                        <td>@{{granel.ite_txt_descripcion}}</td>
                        <td class="text-right">
                          <button class="btn btn-danger btn-sm" ng-click="deleteGranel(granel.ite_id)">
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
          </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
