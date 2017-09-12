@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="solicitudesCtrl" ng-cloak>
    <form name="solicitudForm" ng-submit="saveSolicitud()" class="form-inline" novalidate>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-sm-12">
            <div class="row">
              <div class="form-group col-sm-4">
                <label class="control-label">Tipo de Novedad<span class="required">*</span> :</label>
                <select class="form-control" ng-model="solicitud.tnovedad" ng-change="changeNovedad()">
                  <option value="codificacion">Codificación</option>
                  <option value="modificacion">Modificación</option>
                  <option value="eliminacion">Eliminación</option>
                </select>
              </div>
              <div class="form-group col-sm-4" ng-if="solicitud.tnovedad == 'modificacion'">
                <label class="control-label">Tipo de Modificación :</label>
                <select class="form-control" ng-model="solicitud.tmodifica" ng-change="changeNovedad()">
                  <option value="activacion">Activación</option>
                  <option value="suspension">Suspensión</option>
                  <option value="precios">Cambio de Precios</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-12" style="padding-top: 20px;">
            <div class="form-group" ng-if="showFini">
              <label class="control-label">Fecha Inicio<span class="required">*</span> :</label><br>
              <input type="date" class="form-control" ng-model="solicitud.fecini" min="@{{hoy}}" required/>
            </div>
            <div class="form-group" ng-if="showFfin">
              <label class="control-label">Fecha Fin<span class="required">*</span> :</label><br>
              <input type="date" class="form-control" ng-model="solicitud.fecfin" ng-min="referencia.fecini" required/>
            </div>
          </div>
          <div class="col-sm-12" style="padding-top: 20px;">
            <div class="form-group" ng-if="showRef">
              <label class="control-label">Referencia<span class="required">*</span> :</label><br>
              <md-autocomplete md-search-text="itemSearchText"
                               md-items="item in itemSearch(itemSearchText)"
                               md-item-text="[item.ite_referencia,item.detalles.ide_descompleta].join(' - ')"
                               md-selected-item="referencia.ref"
                               md-min-length="0"
                               required
                               style="min-width: 330px;">
                <md-item-template>
                  <span md-highlight-text="itemSearchText" md-highlight-flags="^i">@{{[item.ite_referencia,item.detalles.ide_descompleta].join(' - ')}}</span>
                </md-item-template>
                <md-not-found>
                  No se encontraron resultados para "@{{itemSearchText}}".
                </md-not-found>
              </md-autocomplete>
            </div>
            <div class="form-group" ng-if="showPre">
              <label class="control-label">Precio Bruto<span class="required">*</span> :</label><br>
              <input type="number" class="form-control" ng-model="referencia.prebru" required/>
            </div>
            <div class="form-group" ng-if="showPre">
              <label class="control-label">Precio Sugerido<span class="required">*</span> :</label><br>
              <input type="number" class="form-control" ng-model="referencia.presug" ng-min="referencia.prebru" required/>
            </div>
            <div class="form-group"  ng-if="showRef">
              <br><button type="button" class="btn btn-success" ng-click="addReferencia()">
                <span class="glyphicon glyphicon-plus"></span>
              </button>
            </div>
          </div>
          <div class="col-sm-12" style="padding-top: 20px;" ng-if="referencias.length > 0">
            <table class="table">
              <thead>
                <tr>
                  <th>Referencia</th>
                  <th ng-if="showPre">Precio Bruto</th>
                  <th ng-if="showPre">Precio Sugerido</th>
                  <th ng-if="showFini">Fecha Inicio</th>
                  <th ng-if="showFfin">Fecha Fin</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="refer in referencias">
                  <td>@{{refer.ref.ite_referencia}}</td>
                  <td ng-if="showPre">@{{refer.prebru}}</td>
                  <td ng-if="showPre">@{{refer.presug}}</td>
                  <td ng-if="showFini">@{{solicitud.fecini | date : 'MM/dd/yyyy' }}</td>
                  <td ng-if="showFfin">@{{solicitud.fecfin | date : 'MM/dd/yyyy' }}</td>
                  <td>
                    <button type="button" class="btn btn-danger" ng-click="removeReferencia()">
                      <span class="glyphicon glyphicon-minus"></span>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-sm-12" style="padding-top: 20px;" ng-if="referencias.length > 0">
            <div class="text-center">
              <button class="btn btn-primary" type="submit">Solicitar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/solicitudesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
