@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="createSubempaqueCtrl" ng-cloak>
    <form name="createSubempaqueForm" ng-submit="createSubempaqueForm.$valid && saveSubempaque()" class="form-horizontal" novalidate>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <label class="col-sm-2">Referencia<span class="required">*</span> :</label>
                <div class="col-sm-6">
                  <md-autocomplete md-search-text="itemSearchText"
                                   md-items="item in itemSearch(itemSearchText)"
                                   md-item-text="[item.ite_referencia,item.detalles.ide_descompleta].join(' - ')"
                                   md-selected-item="subempaque.referencia"
                                   md-min-length="0"
                                   required>
                    <md-item-template>
                      <span md-highlight-text="itemSearchText" md-highlight-flags="^i">@{{[item.ite_referencia,item.detalles.ide_descompleta].join(' - ')}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{itemSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <label class="col-sm-6 control-label">Cantidad Embalaje<span class="required">*</span> :</label>
                    <div class="col-sm-5 input-group">
                      <input type="number" class="form-control" ng-model="subempaque.embalaje" maxlength="3" required/>
                      <div class="input-group-addon">unds</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="text-center">
              <input type="hidden" ng-model="subempaque.proy" ng-init="subempaque.proy = {{$idproyecto}}"/>
              <input type="hidden" ng-model="subempaque.act" ng-init="subempaque.act = {{$idactividad}}"/>
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
  <script src="{{url('/js/pricat/createSubempaqueCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
