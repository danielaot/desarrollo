@extends('app')

@section('content')
  @include('includes.titulo')

  <div ng-controller="consultaCtrl" ng-cloak>
    <div class="panel-default">
      <hr>
      <div class="row">
        <label class="col-sm-1 control-label">Referencia:</label>
        <div class="col-sm-6">
          <md-chips ng-model="consultaref" md-autocomplete-snap
             md-transform-chip="transformChip($chip)"
             md-on-add="onAddReferencia($chip)"
             md-on-remove="onRemoveReferencia($chip)"
             md-require-match="autocompleteDemoRequireMatch">
             <md-autocomplete
                 md-selected-item="selectedItem"
                 md-search-text="colaboradorText"
                 md-items="item in onSearchQueryChange(colaboradorText) | map: filtrarVendedorZona | remove: undefined"
                 md-item-text="(solicitud.tipopersona1.tpe_id == 1) ? ['Z'+item.scz_zon_id, item.scl_nombre].join(' - ') : [item.scl_cli_id, item.scl_nombre].join(' - ')"
                 md-min-length="1"
                 md-no-cache="true"
                 placeholder="Buscar una referencia">
               <span md-highlight-text="searchText">@{{(solicitud.tipopersona1.tpe_id == 1) ? ['Z'+item.scz_zon_id, item.scl_nombre].join(' - ') : [item.scl_cli_id, item.scl_nombre].join(' - ')}}</span>
             </md-autocomplete>
            <md-chip-template>
             <span>
               @{{(solicitud.tipopersona1.tpe_id == 1) ? ['Z'+$chip.scz_zon_id, $chip.scl_nombre].join(' - ') : [$chip.scl_cli_id, $chip.scl_nombre].join(' - ') }}
             </span>
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
