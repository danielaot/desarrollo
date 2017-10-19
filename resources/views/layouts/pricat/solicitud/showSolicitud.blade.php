<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content panel-primary">
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Solicitud No. @{{ solicitud.id }}</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <label>Inicio: </label><span> @{{ solicitud.sop_fecha_inicio | date : 'dd/MMM/yy' }}</span>
          </div>
          <div class="col-sm-4">
            <label>Fin: </label><span> @{{ solicitud.sop_fecha_fin | date : 'dd/MMM/yy' }}</span>
          </div>
        </div>
        <table class="table table-condensed table-hover">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Referencia</th>
              <th class="text-center">Precio Bruto</th>
              <th class="text-center">Precio Sugerido</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="referencia in solicitud.detalles">
              <td class="text-center">
                @{{$index}}
              </td>
              <td>
                <span>@{{ referencia.spd_referencia }} - @{{ referencia.items.detalles.ide_descompleta }}</span>
              </td>
              <td class="text-center">
                <span>@{{ referencia.spd_preciobruto | currency : '$' : 0 }}</span>
              </td>
              <td class="text-center">
                <span>@{{ referencia.spd_preciosugerido | currency : '$' : 0 }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
