<!-- Modal -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 65%;">
    <form name="personaForm" ng-submit="personaForm.$valid && save()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Crear persona</h4>
        </div>
        <div class="modal-body">

          <!-- Combo niveles -->
          <div class="form-group">
            <label>Seleccionar nivel:</label>
            <select ng-model="objeto.nivel" ng-disabled="objeto.id != undefined" ng-change="nivelesCambio()"  ng-options='nivel.niv_nombre for nivel in niveles track by nivel.id' required class="form-control">
              <option value="">Seleccione...</option>
            </select>
          </div>
          <!-- End combo niveles -->

          <!-- Combo tipo persona -->
          <div class="form-group" ng-if="objeto.nivel.id == 1">
            <label>Seleccionar tipo persona:</label>
            <select ng-model="objeto.tipo" ng-change="cambioConsultaArreglo()" ng-options='tipo.tip_descripcion for tipo in tipoPersona track by tipo.id' required class="form-control">
              <option value="">Seleccione...</option>
            </select>
          </div>
          <!-- End combo tipo persona -->

          <!-- Autocomplete -->
          <div class="form-group">
            <label>Usuario</label>
            <div ng-if="validoSiExisteNombre" class="alert alert-danger alert-dismissable">
              Ya existe la persona que intenta crear, la debe buscar y agregar
            </div>
            <md-autocomplete
            ng-disabled="objeto.id != undefined"
            md-no-cache="true"
            md-selected-item="objeto.selectedItem"
            md-search-text="objeto.searchText"
            md-items="item in querySearch(objeto.searchText)"
            md-item-text="item.razonSocialTercero"
            md-selected-item-change="cambioPersonaInAutocomplete(objeto.selectedItem)"
            md-min-length="2"
            placeholder="Ingresar nombre de persona"
            required>
            <md-item-template>
              <span md-highlight-text="objeto.searchText" md-highlight-flags="^i">@{{item.idTercero}}-@{{item.razonSocialTercero}}</span>
            </md-item-template>
            <md-not-found>
              La persona "@{{objeto.searchText}}" no fue encontrada
            </md-not-found>
          </md-autocomplete>
        </div>
        <!-- End autocomplete -->

          <!-- Combo Jefe -->
          <div class="form-group" ng-if="objeto.selectedItem != undefined && (objeto.nivel.id == 3 || objeto.nivel.id == 1)">
            <label>Seleccionar persona siguiente nivel:</label>
            <select ng-model="objeto.jefe" ng-options='pniv.pern_nombre for pniv in filtroNiveles(objeto.nivel.niv_idpadre) track by pniv.id' required class="form-control">
              <option value="">Seleccione...</option>
            </select>
          </div>
          <!-- End Jefe -->



        <!-- Canales -->
        <div ng-if="objeto.nivel.id == 3 && objeto.jefe != undefined" class="panel panel-primary">
          <div class="panel-heading">Favor agregar canales:</div>
          

          <div ng-if="objeto.canales.length == 0" class="alert alert-warning alert-dismissable">
            Debe agregar al menos un canal
          </div>

          <div class="panel-body">
            <div class="input-group">
              <select ng-model="canal" ng-options='can.can_txt_descrip for can in canales track by can.can_id' class="form-control">
                <option value="">Seleccione...</option>
              </select>
              <span class="input-group-btn">
                <button ng-click="AgregarCanal(canal)" ng-disabled="canal == undefined" class="btn btn-success" type="button">
                  <i class="glyphicon glyphicon-plus"></i>
                </button>
              </span>
            </div>
            <br>
            <ul class="list-group">
              <li ng-if="objeto.canales.length == 0" class="list-group-item">Favor seleccionar al menos un canal...</li>
              <li class="list-group-item" ng-repeat="cana in objeto.canales">@{{cana.can_txt_descrip}}
                <a href="#" ng-click="borrarElemento(cana)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              </li>
            </ul>
          </div>
        </div>
        <!-- End Canales -->




        <!-- Lineas -->
        <div ng-if="objeto.nivel.id == 3 && objeto.canales.length > 0" class="panel panel-primary">
          <div class="panel-heading">Favor agregar lineas:</div>

          <div ng-if="objeto.lineas.length == 0" class="alert alert-warning alert-dismissable">
            Debe agregar al menos una linea
          </div>

          <div ng-if="!validoSiGrabo" class="alert alert-danger alert-dismissable">
            No puede adicionar esta linea por que ya esta asociada a otra persona en el mismo canal
          </div>

          <div class="panel-body">
            <div class="input-group">
              <select ng-model="linea" ng-options='[lin.lin_id,lin.lin_txt_descrip].join(" - ") for lin in lineas track by lin.lin_id' class="form-control">
                <option value="">Seleccione...</option>
              </select>
              <span class="input-group-btn">
                <button ng-click="agregarLinea(linea)" ng-disabled="linea == undefined" class="btn btn-success" type="button">
                  <i class="glyphicon glyphicon-plus"></i>
                </button>
              </span>
            </div>
            <br>
            <ul class="list-group">
              <li ng-if="objeto.lineas.length == 0" class="list-group-item">Favor seleccionar al menos una linea...</li>
              <li class="list-group-item" ng-repeat="line in objeto.lineas">@{{line.lin_txt_descrip}}
                <a href="#" ng-click="borrarEsteElemento(line)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              </li>
            </ul>
          </div>
        </div>
        <!-- End Lineas -->

      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
      </div>
    </div>
  </form>
</div>
</div>
