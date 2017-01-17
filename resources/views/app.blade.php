<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link type="image/x-icon" href="favicon.png" rel="icon"/>

    <title>Aplicativos Belleza Express S.A.</title>

    <!-- Styles -->
    <!--******************** CSS BOOTSTRAP *********************-->
    <link href="{{url('/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" />
    <!--******************** CSS BESA **************************-->
    <link href="{{url('/css/besa.css')}}" type="text/css" rel="stylesheet"/>

    <!-- jQuery 3.1.1 -->
    <script src="{{url('/js/jquery.min.js')}}" type="text/javascript" language="javascript"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{url('/js/bootstrap.min.js')}}" type="text/javascript" language="javascript"></script>
    <!-- Laravel Javascript Validation -->
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}" type="text/javascript" language="javascript"></script>
  </head>
  <body>
    @include('includes.header')
    @include('includes.menu')

    <div class="wrap">
      @yield('content')
    </div>

    @include('includes.footer')
  </body>
</html>
