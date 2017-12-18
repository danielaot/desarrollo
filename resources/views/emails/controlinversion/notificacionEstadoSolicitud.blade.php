@extends('emails.notificaciones')

<style>
  body {
    font-family: Arial, Helvetica, sans-serif !important;
    font-size: 15px !important;
  }
</style>

@section('content')

<div class="form-group">
  <label><strong>Solicitud No.</strong> </label>
  {{$dataSolicitud['soh_sci_id']}}
</div>

<div class="form-group">
  <label><strong>Fecha de solicitud:</strong> </label>
  {{$dataSolicitud['soh_fechaenvio']}}
</div>

<div class="form-group">
  <label><strong>Canal:</strong> </label>
  {{$dataSolicitud['solicitud']['sci_can_desc']}}
</div>

<div class="form-group">
  <label><strong>Lineas:</strong> </label>
  {{$dataSolicitud['lineasCorreo']}}
</div>

<p>La solicitud ha sido aprobada por <strong>{{$dataSolicitud['perNivelEnvia']['razonSocialTercero']}}</strong> por favor ingrese al aplicativo y realice las acciones correspondientes.</p>



@endsection
