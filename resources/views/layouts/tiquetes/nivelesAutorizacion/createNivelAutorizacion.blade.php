<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;" role="document">
    <form name="nivelesForm" ng-submit="nivelesForm.$valid && savePerNivel()" novalidate>
      <div class="modal-content panel-primary">
        <!--Titulo del modal-->
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="niveles.id == undefined">Creación Niveles de Aprobación - @{{nivel[0].niv_descripcion}}</h4>
          <h4 class="modal-title" ng-if="niveles.id != undefined">Edición Niveles de Aprobación</h4>
        </div>
        <!--Fin Titulo del modal-->
        <div class="modal-body">
        <!--Formulario Creacion -->
          <div class="row">
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Tipo de Personas <span class="required">*</span>:</label>
                <select class="form-control" ng-model="infoPerNivel.tpersona" ng-options="option.tpp_descripcion for option in tpersona track by option.id" required></select>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label>Nombre <span class="required">*</span>:</label>
                <md-autocomplete md-search-text="nombreSearchText"
                             md-items="nombre in nombreSearch(nombreSearchText)"
                             md-item-text="nombre.nombreEstablecimientoTercero"
                             md-selected-item="infoPerNivel.usuarioNivel"
                             md-min-length="0"
                             >
                  <md-item-template>
                    <span md-highlight-text="nombreSearchText" md-highlight-flags="^i">@{{nombre.nombreEstablecimientoTercero}}</span>
                  </md-item-template>
                  <md-not-found>
                    No se encontraron resultados para "@{{nombreSearchText}}".
                  </md-not-found>
                </md-autocomplete>
              </div>
            </div>
            <!-- <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Persona :</label>
                <multiselect ng-model="infoPerNivel.detPersona"
                             options="usuarios" id-prop="idTercero"
                             display-prop="cedulaNombre" show-select-all="true"
                             placeholder=" Seleccione Personas "
                             show-unselect-all="true" show-search="true"
                             search-limit="3" selection-limit="nivel[0].id === 1 ? 1000 : 1">
                </multiselect>
              </div>
            </div> -->
            <div ng-if="infoPerNivel.tpersona.id == '3' || infoPerNivel.tpersona.id == '4' " class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Grupo :</label>
                <multiselect ng-model="infoPerNivel.grupo" options="grupo" id-prop="gru_sigla" display-prop="gru_responsable" show-select-all="true" show-unselect-all="true"></multiselect>
              </div>
            </div>
            <div ng-if="infoPerNivel.tpersona.id == '1' || infoPerNivel.tpersona.id == '2' " class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group" >
                <label class="control-label">Canal :</label>
                <multiselect ng-model="infoPerNivel.canal" options="canal" id-prop="can_id" display-prop="can_txt_descrip" show-select-all="true" show-unselect-all="true"></multiselect>
              </div>
            </div>
            <div ng-if="infoPerNivel.tpersona.id == '2'" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Territorio :</label>
                <multiselect ng-model="infoPerNivel.territorio"
                            options="territorios" id-prop="id"
                            display-prop="tnw_descripcion"
                            show-select-all="true" show-unselect-all="true"
                            selection-limit="1">
                </multiselect>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label>Identificacion :</label>
                <input type="text" class="form-control" ng-model="infoPerNivel.usuarioNivel.idTercero" placeholder="Número de Identificacion" disabled>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Fecha Nacimiento <span class="required">*</span></label>
                <input type="date" class="form-control" ng-model="infoPerNivel.fnacimiento">
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label>Correo Electrónico :</label>
                <input type="text" class="form-control" ng-model="infoPerNivel.usuarioNivel.dirnacional.dir_txt_email" placeholder="Correo Electrónico" disabled>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label>Tipo Gerencia <span class="required">*</span>:</label>
                <select class="form-control" ng-model="infoPerNivel.tgerencia" ng-options='opt.ger_nom for opt in gerencia track by opt.ger_id'>
                  <option value="">Seleccione Gerencia</option>
                </select>
              </div>
            </div>
          </div>
          <hr class="border-top-dotted">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
              <div class="form-group">
                <h4>Datos Pasaporte</h4>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label>Número Pasaporte <span class="required">*</span>:</label>
                <input type="text" class="form-control" ng-model="infoPerNivel.numpasaporte">
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Fecha Pasaporte <span class="required">*</span>:</label>
                <input type="date" class="form-control" ng-model="infoPerNivel.fpasaporte">
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Ciudad Expedición <span class="required">*</span>:</label>
                <select class="form-control" ng-model="infoPerNivel.ciuexpedicion" ng-options='opt.ciuTxtNom for opt in ciudades track by opt.ciuIntId'>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
              <label class="control-label">Estado <span class="required">*</span>:</label>
              <select class="form-control" ng-model="infoPerNivel.estado" ng-options="opt.key for opt in estados track by opt.value">
              </select>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
                <label class="control-label">Estado <span class="required">*</span>:</label>
                <select class="form-control" ng-model="infoPerNivel.estado" ng-options="opt.key for opt in estados track by opt.value">
                  <option value="">Seleccione ...</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
              <div class="form-group">
              <label class="control-label">LifeMiles :</label>
              <input type="text" class="form-control" ng-model="infoPerNivel.lifemiles">
              </div>
            </div>
            <div ng-if="nivel[0].id === 2 || nivel[0].id === 3" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
              <div class="form-group">
                <label>Autoriza a:</label>
                <multiselect class="span-margin" ng-model="infoPerNivel.personasautoriza"
                  options="usuariosN" id-prop="id" display-prop="cedulaNombre"
                  placeholder="-- Seleccione Personas --" show-search="true"
                  show-select-all="true" show-unselect-all="true">
                </multiselect>
              </div>
            </div>
          </div>
          <div class="panel panel-primary" ng-if="infoPerNivel.detPersona != undefined || infoPerNivel.personasautoriza != undefined ">
            <div class="panel-heading">Personas Agregadas</div>
              <div class="panel-body">
                <table class="table table-responsive table-striped table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">Cédula</th>
                      <th class="text-center">Nombre</th>
                      <th class="text-center">Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-if="infoPerNivel.detPersona != undefined" ng-repeat="(key, detPersona) in (nivel[0].id === 1 ? infoPerNivel.detPersona : infoPerNivel.personasautoriza)">
                      <td>@{{nivel[0].id === 1 ? detPersona.idTercero : detPersona.pen_cedula}}</td>
                      <td>@{{nivel[0].id === 1 ? detPersona.nombreEstablecimientoTercero : detPersona.pen_nombre}}</td>
                      <td><button class="btn btn-danger btn-sm" type="button" ng-click="quitarPersona(per)">
                        <i class="glyphicon glyphicon-remove"></i>
                      </button></td>
                    </tr>
                  </tbody>
                </table>
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
