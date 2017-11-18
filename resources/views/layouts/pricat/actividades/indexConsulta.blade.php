@extends('app')

@section('content')
  @include('includes.titulo')

  <div ng-controller="consultaCtrl" ng-cloak>
    <div class="panel panel-default">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Referencia</th>
            <th>Proyecto</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>17523</th>
            <th>prueba</th>
            <th>en proceso</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/consultaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
