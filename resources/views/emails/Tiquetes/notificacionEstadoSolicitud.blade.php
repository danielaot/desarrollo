@extends('emails.notificaciones')

<style>
  body {
    font-family: Arial, Helvetica, sans-serif !important;
    font-size: 15px !important;
  }
</style>

@section('content')

          <p>El usuario <strong>{{$objTSolEnvioNego['terceroEnvia']['nombreTercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido1Tercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido2Tercero']}}</strong> ha creado la <strong>NEGOCIACIÓN No. {{$objTSolEnvioNego['sen_sol_id']}}</strong> la cual
          corresponde al cliente <strong>{{$objTSolEnvioNego['solicitud']['cliente']['razonSocialTercero_cli']}}</strong>.</p>
          <div class="form-group">
            <label><strong>Estado: </strong></label> Filtro
          </div>
          <div class="form-group">
            <label><strong>Observaciones: </strong></label>{{$objTSolEnvioNego['sen_observacion']}}
          </div>
          <div class="form-group">
            <label><strong>Forma de Pago: </strong></label>{{$objTSolEnvioNego['solicitud']['costo']['formaPago']['fpag_descripcion']}}
          </div>
          <p>Debe ingresar al sistema y realizar la aprobación de la negociación en menos de 24 horas.</p>
          <p>Para ir al Aplicativo haga clic <a href="http://www.bellezaexpress.com/aplicativos">aqui</a>.</p>

          

@endsection