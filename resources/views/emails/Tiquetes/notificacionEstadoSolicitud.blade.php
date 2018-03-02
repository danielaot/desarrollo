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
  @if()
    <!-- Creacion -->
    @if()
      <p>La solicitud de <strong>Tiquetes Aereos y Hotel Nro. XXXX</strong> para <strong>Pruebita Prueba Pruebota</strong> se encuentra en estado: <strong>SolicitudPrueba</strong>, para su revisión y aprobación, por favor ingrese al aplicativo y aplique las acciones necesarias y/o comentarios.</p>
      <p>Gracias</p>
    <!-- Aprobacion -->
    @else
      <p>La solicitud de <strong>Tiquetes Aereos y Hotel Nro. XXXX</strong> para <strong>Pruebita Prueba Pruebota</strong> se encuentra en estado: <strong>AprobadoPrueba</strong>, para su revisión y aprobación, por favor ingrese al aplicativo y aplique las acciones necesarias y/o comentarios.</p>
      <p>Gracias</p>

    @endif

  <!-- Correccion -->
  @elseif()
    <p>Su solicitud de <strong>Tiquetes Aereos y Hotel Nro. XXXX</strong> se encuentra en estado: <strong>Correcciones</strong> por Prueba Prueba Pruebaaa.</p>
    <p>Gracias</p>

  <!-- Anulación -->
  @else
    <p>Su solicitud de <strong>Tiquetes Aereos y Hotel Nro. XXXX</strong> se encuentra en estado: <strong>Anulada</strong> por Prueba Prueba Pruebaaa.</p>
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
            <td class="texto">NNN</td>
            <td class="titulo">Identificación</td>
            <td class="texto">15156156</td>
          </tr>
          <tr>    
            <td class="titulo">E-Mail:</td>
            <td class="texto">nnn@bellezaexpress.com</td>
          </tr>
          <tr>    
            <td class="titulo">Observación:</td>
            <td class="texto" colspan="3">Prueba</td>
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
          <tr>    
            <td class="texto">Cali</td>
            <td class="texto">Bogota</td>
            <td class="texto">Año-Mes-Dia Hora:Minutos</td>
            <td class="texto">No se</td>
          </tr>
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
            <td class="texto">NNN</td>
            <td class="titulo">Nit o Cédula</td>
            <td class="texto">15156156</td>
          </tr>
        </tbody>
      </table>
    <center>
  </div>
  <br>

          

@endsection