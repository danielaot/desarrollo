@extends('app')

@section('content')
  <link href="{{url('/css/pricat.css')}}" type="text/css" rel="stylesheet"/>
  @include('includes.titulo')
  <div ng-controller="workflowCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        @foreach($proyectos as $proyecto)
          <div class="col-sm-6 proyecto">
            <button type="button" class="btn {{$estilos[array_rand($estilos)]}} work-box" data-toggle="modal" data-target="#modal" ng-click="setProyecto({{$proyecto->id}})">
              {{$proyecto->proy_nombre[0]}}
            </button>
            <p class="info-proy">{{$proyecto->proy_nombre}}</p>
            <span class="btn-primary estado">{{$proyecto->proy_estado}}</span>
          </div>
        @endforeach
      </div>
      @include('layouts.pricat.actividades.showWorkFlow')
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/workflowCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
