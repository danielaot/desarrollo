<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;" role="document">
    <form name="nivelesForm" ng-submit="usuarioUno != undefined ? nivelesForm.$valid && editarNivel() : nivelesForm.$valid && savePerNivel()" novalidate>
      <div class="modal-content panel-primary">
        <!--Titulo del modal-->
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Niveles de Aprobación - @{{usuarioUno != undefined ? infoPerNivel.nivel.niv_descripcion : nivel[0].niv_descripcion}}</h4>
        </div>
        <!--Fin Titulo del modal-->
        <div class="modal-body">
          <md-tabs md-dynamic-height md-border-bottom>
            <md-tab label="informacion general">
              <md-content class="md-padding">
                <div class="row">
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Tipo de Personas <span class="required">*</span>:</label>
                      <select class="form-control" ng-change="onChangeTipoPersona()" ng-model="infoPerNivel.tpersona" ng-change="filtrarPersonas()" ng-options="option.tpp_descripcion for option in tpersona track by option.id" required></select>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Persona <span class="required">*</span>:</label>
                      <md-autocomplete md-search-text="nombreSearchText"
                                   md-items="nombre in nombreSearch(nombreSearchText)"
                                   md-item-text="nombre.nombreEstablecimientoTercero"
                                   md-selected-item="infoPerNivel.tercero"
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
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Identificacion :</label>
                      <input type="text" class="form-control" ng-model="infoPerNivel.tercero.idTercero" placeholder="Número de Identificacion" disabled>
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
                      <input type="text" class="form-control" ng-model="infoPerNivel.tercero.dirnacional.dir_txt_email" placeholder="Correo Electrónico" disabled>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Tipo Gerencia :</label>
                      <input type="text" class="form-control" ng-model="infoPerNivel.tercero.datosGerencia.nom_gerencia" placeholder="Gerencia" disabled>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Estado <span class="required">*</span>:</label>
                      <select class="form-control" ng-model="infoPerNivel.estado" ng-options="opt.key for opt in estados track by opt.value" required>
                        <option value="">Seleccione ...</option>
                      </select>
                    </div>
                  </div>
                  <div ng-if="infoPerNivel.tpersona.id == '3' || infoPerNivel.tpersona.id == '4' " class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Grupo :</label>
                      <multiselect ng-model="infoPerNivel.grupos" options="grupos" id-prop="gru_sigla" display-prop="gru_responsable" show-select-all="true" show-unselect-all="true" required></multiselect>
                    </div>
                  </div>
                  <div ng-if="nivel[0].id == 4" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Gerencias:</label>
                      <multiselect class="span-margin" ng-model="infoPerNivel.gerencias" options="gerenciasFiltradas" id-prop="ger_id" display-prop="codigoGerencia" placeholder="-- Seleccione Gerencias --" show-select-all="true" show-unselect-all="true" required></multiselect>
                    </div>
                  </div>
                  <div ng-if="infoPerNivel.tpersona.id == '2'" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Territorio :</label>
                      <multiselect ng-model="infoPerNivel.territorio"
                                   options="territorios" id-prop="id"
                                   display-prop="tnw_descripcion"
                                   show-select-all="true" show-unselect-all="true" ng-change="filtrarPersonas()">
                      </multiselect>
                    </div>
                  </div>
                  <div ng-if="infoPerNivel.tpersona.id == '1'" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group" >
                      <label class="control-label">Canal :</label>
                      <multiselect ng-model="infoPerNivel.canales" options="canales" id-prop="can_id" display-prop="can_txt_descrip"
                        show-select-all="true" show-unselect-all="true" ng-change="filtrarPersonas()"></multiselect>
                    </div>
                  </div>
                  <div ng-if="(infoPerNivel.tpersona.id === 5 && nivel[0].id > 1 && nivel[0].id < 4)" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                      <label>Personas Autoriza:</label>
                      <multiselect class="span-margin" ng-model="infoPerNivel.personasautoriza" options="tercerosFiltrados" id-prop="id" display-prop="cedulaNombre" placeholder="-- Seleccione Personas --" show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect>
                    </div>
                  </div>
                </div>


                <div class="panel panel-primary" ng-if="infoPerNivel.territorio != undefined || infoPerNivel.canales != undefined || infoPerNivel.grupos != undefined"><!--|| infoPerNivel.tpersona.id == '5' && nivel[0].id !== 1-->
                  <div class="panel-heading">Información</div>
                    <div class="panel-body">
                      <md-tabs ng-if="nivel[0].id !== 1 && infoPerNivel.canales.length > 0 || infoPerNivel.territorio.length > 0 || infoPerNivel.grupos.length > 0 || infoPerNivel.tpersona.id === '5'" md-dynamic-height md-border-bottom>
                        <md-tab label="@{{infoPerNivel.canales.length > 0 ? [objeto.can_id,objeto.can_txt_descrip].join(' - ') : infoPerNivel.territorio.length > 0 ? [objeto.zonanw.znw_descripcion,objeto.tnw_descripcion].join(' - ') : [objeto.gru_sigla,objeto.gru_responsable].join(' - ')}}"
                                ng-repeat="(key, objeto) in infoPerNivel.canales.length > 0 ? infoPerNivel.canales : infoPerNivel.territorio.length > 0 ? infoPerNivel.territorio : infoPerNivel.grupos">
                          <md-content class ="md-padding">
                            <div class ="row">
                              <div ng-if="infoPerNivel.tpersona.id == '2' || infoPerNivel.tpersona.id == '3' || infoPerNivel.tpersona.id == '4'" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class ="form-group">
                                  <label class ="control-label">Canal :</label>
                                  <multiselect ng-model ="objeto.canales" options="canales" id-prop="can_id"
                                               display-prop="can_txt_descrip" show-select-all="true"
                                                show-unselect-all="true" ng-change="filtrarPersonas()"></multiselect>
                                </div>
                              </div>
                              <div ng-if="infoPerNivel.tpersona.id == '1' || infoPerNivel.tpersona.id == '5'" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                  <label>Persona(s):</label>
                                  <multiselect class="span-margin" ng-model="objeto.terceros"
                                               options="objeto.tercerosFiltrados" id-prop="pen_cedula" display-prop="cedulaNombre"
                                               placeholder="-- Seleccione Personas --" show-search="true"
                                               show-select-all="true" show-unselect-all="true" required></multiselect>
                                </div>
                                <table ng-if = "canal.terceros.length > 0" class="table table-responsive table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th class="text-center">Cédula</th>
                                      <th class="text-center">Nombre</th>
                                      <th class="text-center">Acción</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr ng-if="canal.terceros.length > 0" ng-repeat="(key, tercero) in (nivel[0].id !== 1 ? canal.terceros : canal.personasautoriza)">
                                      <td class="text-center">@{{nivel[0].id > 1 ? tercero.pen_cedula : tercero.idTercero}}</td>
                                      <td class="text-center">@{{nivel[0].id > 1 ? tercero.pen_nombre : tercero.idTercero}}</td>
                                      <td class="text-center">
                                        <button type="button" class="btn btn-danger" ng-click="eliminarPersona(tercero)"><i class="glyphicon glyphicon-remove"></i></button>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <md-tabs md-dynamic-height md-border-bottom>
                              <md-tab ng-if="nivel[0].id !== 1 && infoPerNivel.tpersona.id == '2' && objeto.canales !== undefined" label="@{{[canal.can_id,canal.can_txt_descrip].join(' - ')}}" ng-repeat="canal in objeto.canales">
                                <md-content class ="md-padding">
                                  <div class="row">
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                      <div class="form-group" >
                                        <label>Persona(s):</label>
							                          <multiselect class="span-margin" ng-model="canal.terceros" options="canal.tercerosFiltrados" id-prop="pen_cedula" display-prop="cedulaNombre" placeholder="-- Seleccione Personas --" show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect>
                                      </div>
                                    </div>
                                  </div>
                                  <table ng-if = "canal.terceros.length > 0" class="table table-responsive table-striped table-bordered">
        				                    <thead>
        				                      <tr>
        				                        <th class="text-center">Cédula</th>
        				                        <th class="text-center">Nombre</th>
        				                        <th class="text-center">Acción</th>
        				                      </tr>
        				                    </thead>
        				                    <tbody>
        				                      <tr ng-if="canal.terceros.length > 0" ng-repeat="(key, tercero) in (nivel[0].id === 1 ? canal.terceros : canal.personasautoriza)">
        				                        <td class="text-center">@{{nivel[0].id > 1 ? tercero.pen_cedula :tercero.idTercero}}</td>
        				                        <td class="text-center">@{{nivel[0].id > 1 ? tercero.pen_nombre : tercero.razonSocialTercero}}</td>
        				                        <td class="text-center">
        				                          <button type="button" class="btn btn-danger" ng-click="eliminarPersona(tercero)"><i class="glyphicon glyphicon-remove"></i></button>
        				                        </td>
        				                      </tr>
        				                    </tbody>
        				                  </table>
                                </md-content>
                              </md-tab>
                            </md-tabs>
                          </md-content>
                        </md-tab>
                      </md-tabs>
                    </div>
                </div>
              </md-content>
            </md-tab>
            <!--Fin Formulario Creacion -->
            <!--Pasaporte -->
            <md-tab label="Pasaporte">
              <md-content class="md-padding">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                      <h4>Datos Pasaporte</h4>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Número Pasaporte :</label>
                      <input type="text" class="form-control" ng-model="infoPerNivel.numpasaporte">
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Fecha Pasaporte :</label>
                      <input type="date" class="form-control" ng-model="infoPerNivel.fpasaporte">
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Ciudad Expedición :</label>
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
                    <label class="control-label">LifeMiles :</label>
                    <input type="text" class="form-control" ng-model="infoPerNivel.lifemiles">
                    </div>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <!--Fin Pasaporte -->
          </md-tabs>
        </div>
        <div class="modal-footer">

          <button class="btn btn-primary" type="submit">Guardar</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
