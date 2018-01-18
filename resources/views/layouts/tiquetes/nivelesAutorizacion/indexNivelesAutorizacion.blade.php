@extends('app')

@section('content')
  @include('includes.titulo')
    <div ng-controller="nivelesAutorizacionCtrl" ng-cloak class="cold-md-12">
      <div class="container-fluid">
        <md-tabs md-dynamic-height md-border-bottom>
          <!-- inicio nivel 1 -->
          <md-tab label="nivel 1">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(tod)">
                <i class="glyphicon glyphicon-plus"></i>  Agregar Nivel
              </button>
            </md-content>
          </md-tab>
          <!-- fin nivel 1 -->
          <!-- inicio nivel 2 -->
          <md-tab label="nivel 2">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(tod)">
                <i class="glyphicon glyphicon-plus"></i>  Agregar Nivel
              </button>
            </md-content>
          </md-tab>
          <!-- fin nivel 2 -->
          <!-- inicio nivel 3 -->
          <md-tab label="nivel 3">
            <md-content class="md-padding">
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#modal" ng-click="solicitud(tod)">
                <i class="glyphicon glyphicon-plus"></i>  Agregar Nivel
              </button>
            </md-content>
          </md-tab>
          <!-- fin nivel 3 -->
        </md-tabs>
      </div>
      @include('layouts.tiquetes.nivelesAutorizacion.createNivelAutorizacion')
    </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/tiquetes/nivelesAutorizacionCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
