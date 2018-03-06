@extends('emails.notificaciones')

<style>
  body {
    font-family: Arial, Helvetica, sans-serif !important;
    font-size: 15px !important;
  }
</style>

@section('content')
  
  <p>Para ir al Aplicativo haga clic <a href="http://www.bellezaexpress.com/aplicativos">aqui</a>.</p>
  <!-- Aprobacion y ruta -->
  @if($objSolTiquete['evaIntTipoSolicitudAnt'] == 4 || $objSolTiquete['evaIntTipoSolicitudAnt'] == 12)
    <!-- Creacion -->
    @if($objSolTiquete['evaIntTipoSolicitudAnt'] == 4)
      <p>La solicitud de <strong>Tiquetes Aereos y Hotel Nro. {{$objSolTiquete['solicitud']['solIntSolId']}}</strong> para <strong>{{$objSolTiquete['solicitud']['perCrea']['razonSocialTercero']}}</strong> se encuentra en estado: <strong>Solicitud</strong>, para su revisión y aprobación, por favor ingrese al aplicativo y aplique las acciones necesarias y/o comentarios.</p>
      <p>Gracias</p>
    <!-- Aprobacion -->
    @else
      <p>La solicitud de <strong>Tiquetes Aereos y Hotel Nro. {{$objSolTiquete['solicitud']['solIntSolId']}}</strong> para <strong>{{$objSolTiquete['solicitud']['perCrea']['razonSocialTercero']}}</strong> se encuentra en estado: <strong>Aprobado</strong>, para su revisión y aprobación, por favor ingrese al aplicativo y aplique las acciones necesarias y/o comentarios.</p>
      <p>Gracias</p>

    @endif

  <!-- Correccion -->
  @elseif($objSolTiquete['evaIntTipoSolicitudAnt'] == 2)
    <p>Su solicitud de <strong>Tiquetes Aereos y Hotel Nro. {{$objSolTiquete['solicitud']['solIntSolId']}}</strong> se encuentra en estado: <strong>Correcciones</strong> por {{$objSolTiquete['evaTxtNomterAnt']}}.</p>
    <p>Gracias</p>

  <!-- Anulada -->
  @elseif($objSolTiquete['evaIntTipoSolicitudAnt'] == 3)
    <p>Su solicitud de <strong>Tiquetes Aereos y Hotel Nro. {{$objSolTiquete['solicitud']['solIntSolId']}}</strong> se encuentra en estado: <strong>Anulada</strong> por {{$objSolTiquete['evaTxtNomterAnt']}}.</p>
    <p>Gracias</p>

  @endif

  <div class="content-informacion">
    <center>
      <table>
        <thead class="background-thead">
          <tr><th colspan="4">Información Personal</th></tr>
          <tr><th colspan="4"></th></tr>
        </thead>
        <tbody>
          <tr>    
            <td class="titulo">Viajero</td>
            <td class="texto">{{$objSolTiquete['solicitud']['solTxtNomtercero']}}</td>
            <td class="titulo">Identificación</td>
            <td class="texto">{{$objSolTiquete['solicitud']['solTxtCedtercero']}}</td>
          </tr>
          <tr>    
            <td class="titulo">E-Mail:</td>
            <td class="texto">{{$objSolTiquete['solicitud']['solTxtEmail']}}</td>
          </tr>
          <tr>    
            <td class="titulo">Observación:</td>
            <td class="texto" colspan="3">{{$objSolTiquete['solicitud']['solTxtObservacion']}}</td>
          </tr>
        </tbody>
      </table>
      <br>
      <table>
        <thead class="background-thead">
          <tr><th colspan="8">Detalle Solicitud</th></tr>
          <tr class="fila-encabezado">
            <th class="encabezado">Lugar Origen</th>
            <th class="encabezado">Lugar Destino</th>
            <th class="encabezado">Hora Viaje</th>
            <th class="encabezado">Requiere HotelRequiere Hotel</th>
          </tr>
        </thead>
        <tbody>
          <!-- Repetir viajes -->
          @foreach($objSolTiquete['solicitud']['detalle'] as $dll)
            <tr>
              <td class="texto">{{$dll['ciuOrigen']['ciuTxtNom']}}</td>
              <td class="texto">{{$dll['ciuDestino']['ciuTxtNom']}}</td>
              <td class="texto">{{gmdate("Y-m-d H:i:s", $dll['dtaIntFechaVuelo'])}}</td>
              <td class="texto">No se</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <br>
      <table>
        <thead class="background-thead">
          <tr><th colspan="4">Información General del Creador de la Solicitud</th></tr>
          <tr><th colspan="4"></th></tr>
        </thead>
        <tbody>
          <tr>    
            <td class="titulo">Nombre</td>
            <td class="texto">{{$objSolTiquete['solicitud']['perCrea']['razonSocialTercero']}}</td>
            <td class="titulo">Nit o Cédula</td>
            <td class="texto">{{$objSolTiquete['solicitud']['solTxtCedterceroCrea']}}</td>
          </tr>
        </tbody>
      </table>
    <center>
  </div>
  <br>

          

@endsection