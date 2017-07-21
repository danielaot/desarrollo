<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content panel-primary">
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">WorkFlow</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-sm-6">
                <span class="label label-warning"><i class="glyphicon glyphicon-leaf"></i></span>
                <b>@{{proyecto.proy_nombre}} </b>
              </div>
              <div class="col-sm-2">
                <span class="label @{{estados['Completado'].label}}"><i class="glyphicon @{{estados['Completado'].icon}}"></i></span>
                <b>Completada</b>
              </div>
              <div class="col-sm-2">
                <span class="label @{{estados['En Proceso'].label}}"><i class="glyphicon @{{estados['En Proceso'].icon}}"></i></span>
                <b>En Proceso</b>
              </div>
              <div class="col-sm-2">
                <span class="label @{{estados['Pendiente'].label}}"><i class="glyphicon @{{estados['Pendiente'].icon}}"></i></span>
                <b>Pendiente</b>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <table cellpadding="0" cellspacing="0" class="header-wf">
              <tbody>
                <tr>
                  <th></th>
                  <th ng-repeat="actividad in proyecto.desarrollos"><span class="label @{{estados[actividad.dac_estado].label}}">@{{actividad.dac_act_id}}</span></th>
                </tr>
                <tr class="body-wf">
                  <th class="act-title">
                    <div>Desarrollo<br>Actividad</div>
                  </th>
                  <th class="act" ng-repeat="actividad in proyecto.desarrollos">
                    <div class="@{{estados[actividad.dac_estado].state}}">
                      <div>&nbsp;</div>
                    </div>
                  </th>
                </tr>
              </tbody>
            </table>
            <br>
            <div class="well">
              <div class="row">
                <div class="col-sm-4 detail" ng-repeat="actividad in proyecto.desarrollos">
                  <div class="row">
                    <div class="col-sm-3">
                      <span class="label @{{estados[actividad.dac_estado].label}}">@{{actividad.dac_act_id}} <i class="glyphicon @{{estados[actividad.dac_estado].icon}}"></i></span>
                    </div>
                    <em class="col-sm-9">@{{actividad.actividades.act_titulo}}</em>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
