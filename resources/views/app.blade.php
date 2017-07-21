<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--link type="image/x-icon" href="favicon.ico" rel="icon"/-->

    <title>Aplicativos Belleza Express S.A.</title>

    @include('includes.css')
    @include('includes.js')
  </head>
  <body ng-app="aplicativos">

    <div class="wrap">
      @yield('content')
    </div>

  </body>
</html>
