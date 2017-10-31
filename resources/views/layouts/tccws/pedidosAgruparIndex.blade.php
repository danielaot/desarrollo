@extends('app')

@section('content')
@include('includes.titulo')
<div ng-controller="pedidosAgrupaCtrl as ctrl" ng-cloak>


</div>
@endsection

@push('script_angularjs')
<script src="{{url('/js/tccws/pedidosAgrupaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush