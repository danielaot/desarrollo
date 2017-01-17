<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--******************** CSS BOOTSTRAP ********************-->
    <link rel="stylesheet" href="{{url('/css/bootstrap/css/bootstrap.min.css')}}" type="text/css"/>
    <!--link rel="stylesheet" href="{{url('/css/bootstrap/css/bootstrap-responsive.min.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{url('/css/bootstrap/style.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{url('/css/bootstrap/blue.css')}}" type="text/css"/-->

    <!--******************** CSS BESA ********************-->
    <!--link rel="stylesheet" href="{{url('/css/estilos.css')}}" type="text/css"/-->
    <!--link rel="stylesheet" href="{{url('/css/menu.css')}}" type="text/css"/-->
    <link rel="stylesheet" href="{{url('/css/besa.css')}}" type="text/css"/>

    <!--******************** CSS DATA TABLE ********************-->
    <link rel="stylesheet" href="{{url('/general/DataTables/media/css/jquery.dataTables.css')}}" type="text/css"/>

    <link rel="stylesheet" href="{{url('/css/generarventaempleado.css')}}" type="text/css"/>

    <title>Aplicativos Belleza Express S.A.</title>
</head>
<body>
  <!-- Ini - Menu -->
  <!--nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li>
          <a href="">
            <i class="glyphicon glyphicon-home"></i> Menu
          </a>
        </li>
        <li>
          <a href="{{url('generarventa')}}">
            <i class="glyphicon glyphicon-th"></i> Generar Venta
          </a>
        </li>
        <li>
          <a href="{{url('reimprimirfactura')}}">
            <i class="glyphicon glyphicon-th"></i> Reimprimir Factura
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-user"></i> JAPALACIOS
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="">Perfil</a>
            </li>
            <li>
              <a href="">Soporte</a>
            </li>
            <li>
              <a href="">Control</a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="">Salir</a>
            </li>
      </ul>
    </div>
  </nav-->
  <!-- Fin - Menu -->

  @yield('content')

  <!-- jQuery -->
  <script type="text/javascript" language="javascript" src="{{url('/general/jquery/jquery-1.9.1.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script type="text/javascript" language="javascript" src="{{url('/css/bootstrap/js/bootstrap.min.js')}}"></script>
  <!-- DataTables -->
  <script type="text/javascript" language="javascript" src="{{url('/general/DataTables/media/js/jquery.dataTables.js')}}"></script>

  @stack('scripts')
</body>
</html>
