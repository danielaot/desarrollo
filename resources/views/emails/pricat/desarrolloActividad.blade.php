@extends('emails.notificaciones')

@section('content')
  <p style="{{ $style['body-line'] }}">
    <strong>Actividad ejecutada</strong><br>
    <strong>Nombre : </strong> {{ $actividad['actividadespre']['act_titulo'] }} <br>
    <strong>Responsables : </strong>
    @foreach($actividad['actividadespre']['areas']['responsables'] as $responsable)
      {{$responsable['usuarios']['dir_txt_nombre']}},
    @endforeach
    <br><br>
    <strong>Próxima actividad </strong><br>
    <strong>Nombre : </strong> {{ $actividad['actividades']['act_titulo'] }} <br>
    <strong>Responsables : </strong>
    @foreach($actividad['actividades']['areas']['responsables'] as $responsable)
      {{$responsable['usuarios']['dir_txt_nombre']}},
    @endforeach
  </p>
@endsection
