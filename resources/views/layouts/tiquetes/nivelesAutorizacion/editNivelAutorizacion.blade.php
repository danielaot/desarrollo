<!--Modal-->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;" role="document">
    <form name="nivelesEditForm" ng-submit="nivelesEditForm.$valid && editarNivel()" novalidate>
      <div class="modal-content panel-primary">
        <!--Titulo del modal-->
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Editar Nivel de Aprobación - @{{pernivelEdit.nivel.niv_descripcion}}</h4>
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
                      <input type="text" disabled="disabled" class="form-control" ng-value="pernivelEdit.tpersona">
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Persona :</label>
                      <md-autocomplete md-search-text="searchTerceroText;"
                                   md-items="nombre in getTercerosSinFiltro(searchTerceroText)"
                                   md-item-text="nombre.dirnacional.dir_txt_nombre"
                                   md-selected-item="pernivelEdit.nuevoBeneficiario"
                                   md-min-length="0"
                                   >
                        <md-item-template>
                          <span md-highlight-text="searchTerceroText" md-highlight-flags="^i">@{{nombre.dir_txt_nombre}}</span>
                        </md-item-template>
                        <md-not-found>
                          No se encontraron resultados para "@{{searchTerceroText}}".
                        </md-not-found>
                      </md-autocomplete>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Identificacion :</label>
                      <input type="text" class="form-control" ng-model="pernivelEdit.nuevoBeneficiario.idTercero" placeholder="Número de Identificacion" disabled>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Fecha Nacimiento <span class="required">*</span></label>
                      <input type="date" class="form-control" ng-model="pernivelEdit.fnacimiento">
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Correo Electrónico :</label>
                      <input type="text" class="form-control" ng-model="pernivelEdit.nuevoBeneficiario.dirnacional.dir_txt_email" placeholder="Correo Electrónico" disabled>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label>Tipo Gerencia :</label>
                      <input type="text" class="form-control" ng-model="pernivelEdit.nuevoBeneficiario.datosGerencia.nom_gerencia" placeholder="Gerencia" disabled>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Estado <span class="required">*</span>:</label>
                      <select class="form-control" ng-model="pernivelEdit.estado" ng-options="opt.key for opt in estados track by opt.value" required>
                        <option value="">Seleccione ...</option>
                      </select>
                    </div>
                  </div>

                  <div ng-if="pernivelEdit.tipo_persona.id === 1" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
  		              <div class="form-group">
    		              <label>Canal:</label>
    		              <multiselect class="span-margin" ng-change="onEditBeneficiario()" ng-model="pernivelEdit.canales" options="canales" id-prop="can_id" display-prop="can_txt_descrip" show-select-all="true" placeholder="-- Seleccione Canales --" show-unselect-all="true" required></multiselect>
  		              </div>
		              </div>

                  <div ng-if="pernivelEdit.tipo_persona.id === 2" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
  		              <div class="form-group">
    		              <label>Territorio:</label>
    		              <multiselect class="span-margin" ng-change="onEditBeneficiario()" ng-model="pernivelEdit.territorios" options="territorios" id-prop="id" display-prop="tnw_descripcion" placeholder="-- Seleccione un Territorio --" show-select-all="true" show-unselect-all="true" required></multiselect>
  		              </div>
		              </div>

                  <div ng-if="pernivelEdit.tipo_persona.id === 3 || pernivelEdit.tipo_persona.id === 4" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
  		              <div class="form-group">
  		                <label>Grupo:</label>
  		                <multiselect class="span-margin" ng-change="onEditBeneficiario()" ng-model="pernivelEdit.grupos" options="grupos" id-prop="gru_sigla" display-prop="grupoPersona" placeholder="-- Seleccione Grupos --" show-select-all="true" show-unselect-all="true" required></multiselect>
  		              </div>
		              </div>

                  <div ng-if="(pernivelEdit.tipo_persona.id === 5 && (pernivelEdit.nivel.id === 2 || pernivelEdit.nivel.id === 3))" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                      <label>Personas Autoriza:</label>
                      <multiselect class="span-margin" ng-model="pernivelEdit.terceros" options="pernivelEdit.tercerosFiltrados" id-prop="id" display-prop="cedulaNombre" placeholder="-- Seleccione Personas --" show-search="true" show-select-all="true" show-unselect-all="true"></multiselect>
                    </div>
                  </div>

                  <!-- <div ng-if="((pernivelEdit.nivel.id === 2 || pernivelEdit.nivel.id === 3) && pernivelEdit.tipo_persona.id === 5)" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                      <label>Persona(s):</label>
                      <multiselect class="span-margin" ng-change="agregandoObjetoEditar(objeto)" ng-model="objeto.terceros" options="objeto.tercerosFiltrados" id-prop="id" display-prop="cedulaNombre" placeholder="-- Seleccione Personas --" show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect>
                    </div>
                  </div> -->
              </div>

                <hr ng-if="!(pernivelEdit.tipo_persona.id == 5 && pernivelEdit.nivel.id == 1)" class="border-top-dotted">

                <div class="row">
                  <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
		              <table ng-if="(pernivelEdit.tipo_persona.id == 1 && pernivelEdit.nivel.id == 1) || ((pernivelEdit.tipo_persona.id == 3 || pernivelEdit.tipo_persona.id == 4) && (pernivelEdit.nivel.id == 1 || pernivelEdit.nivel.id == 3)) || (pernivelEdit.tipo_persona.id == 5 && (pernivelEdit.nivel.id > 1 && pernivelEdit.nivel.id < 4))" class="table table-responsive table-striped table-bordered">
		                <tr>
		                  <th class="text-center">@{{(pernivelEdit.canales != undefined || pernivelEdit.gerencias != undefined) ? 'Código' : pernivelEdit.grupos != undefined ? 'Sigla' : 'Cédula'}}</th>
		                  <th class="text-center">@{{pernivelEdit.canales != undefined ? 'Canal' : pernivelEdit.grupos != undefined ? 'Responsable' : pernivelEdit.terceros ? 'Nombre' : 'Gerencia'}}</th>
		                </tr>
                    <tr ng-if="(pernivelEdit.canales.length == 0 && pernivelEdit.grupos.length == 0 && pernivelEdit.terceros.length == 0 && pernivelEdit.gerencias.length == 0) || (pernivelEdit.canales == undefined && pernivelEdit.grupos == undefined && pernivelEdit.terceros == undefined && pernivelEdit.gerencias == undefined)">
                      <td class="text-center" colspan="3">No se han encontrado registros</td>
                    </tr>

                    <tr ng-if="pernivelEdit.canales.length > 0 || pernivelEdit.grupos.length > 0 || pernivelEdit.terceros.length > 0 || pernivelEdit.gerencias.length > 0" ng-repeat="objeto in pernivelEdit.canales.length > 0 ? pernivelEdit.canales: pernivelEdit.grupos.length > 0 ? pernivelEdit.grupos : pernivelEdit.terceros.length > 0 ? pernivelEdit.terceros : pernivelEdit.gerencias">
		                  <td class="text-center">@{{pernivelEdit.canales.length > 0 ? objeto.can_id : pernivelEdit.grupos.length > 0 ? objeto.gru_sigla : pernivelEdit.terceros.length > 0 ? objeto.pen_cedula : objeto.ger_cod}}</td>
		                  <td class="text-center">@{{pernivelEdit.canales.length > 0 ? objeto.can_txt_descrip : pernivelEdit.grupos.length > 0 ? objeto.gru_responsable : pernivelEdit.terceros.length > 0 ? objeto.pen_nombre : objeto.ger_nom}}</td>
		                </tr>
                  </table>
                    <md-tabs ng-if="(pernivelEdit.tipo_persona.id == 2 && (pernivelEdit.nivel.id == 1 || pernivelEdit.nivel.id == 2 || pernivelEdit.nivel.id == 3)) || ((pernivelEdit.tipo_persona.id == 1) && (pernivelEdit.nivel.id == 2 || pernivelEdit.nivel.id == 3)) || ((pernivelEdit.tipo_persona.id == 3 || pernivelEdit.tipo_persona.id == 4) && pernivelEdit.nivel.id == 2)" md-dynamic-height md-border-bottom>
		                    <md-tab label="@{{pernivelEdit.territorios.length > 0 ? objeto.tnw_descripcion : pernivelEdit.canales.length > 0 ? objeto.can_txt_descrip : [objeto.gru_sigla, objeto.gru_responsable].join(' - ')}}" ng-repeat="objeto in pernivelEdit.territorios.length > 0 ? pernivelEdit.territorios : pernivelEdit.canales.length > 0 ? pernivelEdit.canales : pernivelEdit.grupos">
		                        <md-content class="md-padding">

							                  <div class="row">
        			                    <div ng-if="(pernivelEdit.tipo_persona.id === 2 && (pernivelEdit.nivel.id == 1 || pernivelEdit.nivel.id == 2 || pernivelEdit.nivel.id == 3)) || ((pernivelEdit.tipo_persona.id === 3 || pernivelEdit.tipo_persona.id === 4) && pernivelEdit.nivel.id == 2)" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
        			                      <div class="form-group">
          			                      <label>Canal:</label>
          			                      <multiselect class="span-margin" ng-change="agregandoObjetoEditar(objeto)" ng-model="objeto.canales" options="objeto.canalesFiltrados != undefined ? objeto.canalesFiltrados : canales" id-prop="can_id" display-prop="can_txt_descrip" show-select-all="true" placeholder="-- Seleccione Canales --" show-unselect-all="true" required></multiselect>
        			                      </div>
        			                    </div>
        			                    <div ng-if="((pernivelEdit.nivel.id === 2 || pernivelEdit.nivel.id === 3) && pernivelEdit.tipo_persona.id === 1)" class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            					              <div class="form-group">
            					                <label>Persona(s):</label>
            					                <multiselect class="span-margin" ng-change="agregandoObjetoEditar(objeto)" ng-model="objeto.terceros" options="objeto.tercerosFiltrados" id-prop="id" display-prop="cedulaNombre" placeholder="-- Seleccione Personas --" show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect>
            					              </div>
        			                    </div>
							                 </div>

		                           <table ng-if="(pernivelEdit.tipo_persona.id == 2 && pernivelEdit.nivel.id == 1) || (pernivelEdit.tipo_persona.id == 1 && (pernivelEdit.nivel.id == 2 || pernivelEdit.nivel.id == 3)) || ((pernivelEdit.tipo_persona.id === 3 || pernivelEdit.tipo_persona.id === 4) && pernivelEdit.nivel.id == 2)" class="table table-responsive table-striped table-bordered">
      		                      <tr>
      		                        <th class="text-center">@{{objeto.terceros != undefined ? 'Cedula' : 'Código'}}</th>
      		                        <th class="text-center">@{{objeto.terceros != undefined ? 'Nombre' : 'Canal'}}</th>
      		                      </tr>
      		                      <tr ng-if="(objeto.canales.length == 0 && objeto.terceros.length == 0) || (objeto.canales == undefined && objeto.terceros == undefined)">
      		                        <td class="text-center" colspan="3">No se han encontrado registros</td>
      		                      </tr>
      		                      <tr ng-if="objeto.canales != undefined || objeto.terceros != undefined" ng-repeat="obj in objeto.canales != undefined ? objeto.canales : objeto.terceros">
      		                        <td class="text-center">@{{objeto.canales != undefined ? obj.can_id : obj.pen_cedula}}</td>
      		                        <td class="text-center">@{{objeto.canales != undefined ? obj.can_txt_descrip : obj.pen_nombre}}</td>
      		                      </tr>
		                          </table>

		                        <md-tabs  ng-if="(pernivelEdit.tipo_persona.id == 2 && (pernivelEdit.nivel.id == 2 || pernivelEdit.nivel.id == 3))" md-dynamic-height md-border-bottom>

		                    	       <md-tab label="@{{obj.can_txt_descrip}}" ng-repeat="obj in objeto.canales">
		                    		           <md-content class="md-padding">

										                        <div class="row">
                						                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    								              <div class="form-group">
                                                    <label>Persona(s):</label>
                          					                <multiselect class="span-margin" ng-change="agregandoObjetoEditar(obj,true,objeto)" ng-model="obj.terceros" options="obj.tercerosFiltrados" id-prop="id" display-prop="cedulaNombre" placeholder="-- Seleccione Personas --" show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect>
                    								              </div>
                						                    </div>
										                        </div>

            					                    <table class="table table-responsive table-striped table-bordered">
            					                      <tr>
            					                        <th class="text-center">Cedula</th>
            					                        <th class="text-center">Nombre</th>
            					                      </tr>
            					                      <tr ng-if="obj.terceros.length == 0 || obj.terceros == undefined">
            					                        <td class="text-center" colspan="3">No se han encontrado registros</td>
            					                      </tr>
            					                      <tr ng-if="obj.terceros != undefined" ng-repeat="objItem in obj.terceros">
            					                        <td class="text-center">@{{objItem.pen_cedula}}</td>
            					                        <td class="text-center">@{{objItem.pen_nombre}}</td>
            					                      </tr>
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
                      <input type="text" class="form-control" ng-model="pernivelEdit.numpasaporte">
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Fecha Pasaporte :</label>
                      <input type="date" class="form-control" ng-model="pernivelEdit.fpasaporte">
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Ciudad Expedición :</label>
                      <select class="form-control" ng-model="pernivelEdit.ciuexpedicion" ng-options='opt.ciuTxtNom for opt in ciudades track by opt.ciuIntId'>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                    <label class="control-label">Estado <span class="required">*</span>:</label>
                    <select class="form-control" ng-model="pernivelEdit.estado" ng-options="opt.key for opt in estados track by opt.value">
                    </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                    <label class="control-label">LifeMiles :</label>
                    <input type="text" class="form-control" ng-model="pernivelEdit.lifemiles">
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
