@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="segmentosCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal" ng-click="setSegmento()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br><br>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title row">
                <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseini">
                  <div class="col-sm-12">
                    Encabezado
                  </div>
                </a>
              </h4>
            </div>
            <div id="collapseini" class="panel-collapse collapse" role="tabpanel">
              <ul class="list-group">
                <li class="list-group-item" ng-repeat="segmento in encabezado">
                  <div class="row">
                    <div class="col-sm-3">
                      @{{segmento.cse_nombre}}
                    </div>
                    <div class="col-sm-2">
                      @{{segmento.cse_campo}}
                    </div>
                    <div class="col-sm-6">
                      @{{segmento.cse_segmento}}
                    </div>
                    <div class="col-sm-1 text-right">
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" ng-click="editSegmento(segmento.id,'encabezado')">
                        <i class="glyphicon glyphicon-pencil"></i> Editar
                      </button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="panel panel-default" ng-repeat="(key, novedad) in segmentos">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title row">
                <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{key}}">
                  <div class="col-sm-12">
                    @{{key | ucfirst}}
                  </div>
                </a>
              </h4>
            </div>
            <div id="collapse@{{key}}" class="panel-collapse collapse" role="tabpanel">
              <ul class="list-group">
                <li class="list-group-item" ng-repeat="segmento in novedad">
                  <div class="row">
                    <div class="col-sm-3">
                      @{{segmento.cse_nombre}}
                    </div>
                    <div class="col-sm-2">
                      @{{segmento.cse_campo}}
                    </div>
                    <div class="col-sm-4">
                      @{{segmento.cse_segmento}}
                    </div>
                    <div class="col-sm-1">
                      @{{segmento.cse_grupo}}
                    </div>
                    <div class="col-sm-1">
                      @{{segmento.cse_orden}}
                    </div>
                    <div class="col-sm-1 text-right">
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" ng-click="editSegmento(segmento.id,key)">
                        <i class="glyphicon glyphicon-pencil"></i> Editar
                      </button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title row">
                <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefin">
                  <div class="col-sm-12">
                    Cierre
                  </div>
                </a>
              </h4>
            </div>
            <div id="collapsefin" class="panel-collapse collapse" role="tabpanel">
              <ul class="list-group">
                <li class="list-group-item" ng-repeat="segmento in cierre">
                  <div class="row">
                    <div class="col-sm-3">
                      @{{segmento.cse_nombre}}
                    </div>
                    <div class="col-sm-2">
                      @{{segmento.cse_campo}}
                    </div>
                    <div class="col-sm-6">
                      @{{segmento.cse_segmento}}
                    </div>
                    <div class="col-sm-1 text-right">
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" ng-click="editSegmento(segmento.id,'cierre')">
                        <i class="glyphicon glyphicon-pencil"></i> Editar
                      </button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createSegmentos')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/segmentosCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
