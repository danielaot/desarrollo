<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form name="actividadesForm" ng-submit="actividadesForm.$valid && registroActividades()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          </button>
          <h4 class="modal-title">Solicitudes</h4>
        </div>
        <div class="modal-body">
          <p>Seleccione el número de la solicitud que desea modificar, este cargara automáticamente en el formulario anterior.</p>
          <table class="table table-striped table-bordered">
            <thead>
              <tr bgcolor= "#337AB7">
                <th style="color:#FFFFFF">No.</th>
                <th style="color:#FFFFFF">Estado</th>
                <th style="color:#FFFFFF">Viajero</th>
                <th style="color:#FFFFFF">Fecha Solicitud</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="soli in solicitudes">
                <td>@{{soli}}</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>
