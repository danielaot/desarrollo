@extends('app')

@section('content')
  @include('includes.titulo')

  <div ng-controller="fotosCtrl" ng-cloak>
    <form name="fotosForm" ng-submit="fotosForm.$valid && save()" enctype="multipart/form-data" class="form-horizontal" novalidate>
      <div class="panel-default">
        <hr>
        <div class="row">
          <label class="col-sm-1 control-label">Referencia:</label>
          <div class="col-sm-5">
               <md-autocomplete md-search-text="referenciasSearchText"
                               md-items="referencia in referenciasSearch(referenciasSearchText)"
                               md-item-text="referencia.ite_referencia"
                               md-selected-item="info.referencia"
                               md-no-cache="true"
                               md-min-length="0">
                  <md-item-template>
                    <span md-highlight-text="referenciasSearchText">@{{referencia.ite_referencia}}</span>
                  </md-item-template>
                </md-autocomplete>
          </div>
          <div class="col-sm-4">

            <input id="imagen" file-model="imagen" type="file" class="form-control" accept=".png, .jpg, .jpeg"/>
          </div>
        </div>
          <div class="row">
          <br><br><br>
          <div class="row">
            <div class="text-center">
              <button type="submit" class="btn btn-primary" pull-rigth>Cargar Foto</button>
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

@push('script_data_table')
  <script src="{{url('/js/pricat/fotosCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
@push('script_after')
  <script>
    $("#imagen").fileinput({
      language: 'es',
      uploadUrl: '#',
      theme: "explorer",
      allowedFileExtensions: ['jpg', 'png', 'gif']
    });
  </script>
@endpush
