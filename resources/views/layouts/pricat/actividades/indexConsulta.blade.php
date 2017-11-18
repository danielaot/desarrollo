@extends('app')

@section('content')
  @include('includes.titulo')

  <div ng-controller="consultaCtrl" ng-cloak>
    <div class="panel-default">
      <hr>
      <div class="row">
        <label class="col-sm-1 control-label">Referencia:</label>
        <div class="col-sm-6">
           <md-chips ng-model="consulta.referencias" md-require-match="true" md-require-match="true" md-on-add="" md-on-remove="">
            <md-autocomplete md-search-text="referenciasSearchText"
                             md-items="referencia in referenciasSearch(referenciasSearchText)"
                             md-item-text="referencia.ite_referencia"
                             md-no-cache="true"
                             md-min-length="0">
              <md-item-template>
                <span md-highlight-text="referenciasSearchText">@{{referencia.ite_referencia}}</span>
              </md-item-template>
            </md-autocomplete>
            <md-chip-template>
              <span>@{{$chip.ite_referencia}}</span>
            </md-chip-template>
          </md-chips>
        </div>
        <button type="submit" class="btn btn-primary">Consultar</button>
      </div>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/consultaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
