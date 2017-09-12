@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="vocabasCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="setPalabra()">
          <i class="glyphicon glyphicon-plus"></i> Crear
        </button><br>
        <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
          <thead>
            <tr>
              <th>Palabra</th>
              <th>Abreviatura</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="palabra in vocabas">
              <td>@{{palabra.tvoc_palabra}}</td>
              <td>@{{palabra.tvoc_abreviatura}}</td>
              <td class="text-right">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal1" ng-click="editPalabra(palabra.id)">
                  <i class="glyphicon glyphicon-edit"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    @include('layouts.pricat.catalogos.createVocabas')
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/vocabasCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
