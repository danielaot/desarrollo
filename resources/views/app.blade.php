<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link type="image/x-icon" href="favicon.ico" rel="icon"/>

    <title>Aplicativos Belleza Express S.A.</title>

    <!-- Styles -->
    <!--******************** CSS BOOTSTRAP 3.3.7 *********************-->
    <link href="{{url('/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" />
    <!--******************** CSS DataTables 1.10.13 **************************-->
    <link href="{{url('/css/jquery.dataTables.min.css')}}" type="text/css" rel="stylesheet"/>
    <!--******************** CSS BESA **************************-->
    <link href="{{url('/css/besa.css')}}" type="text/css" rel="stylesheet"/>

    <!-- jQuery 3.1.1 -->
    <script src="{{url('/js/jquery.min.js')}}" type="text/javascript" language="javascript"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{url('/js/bootstrap.min.js')}}" type="text/javascript" language="javascript"></script>
    <!-- DataTables 1.10.13 -->
    <script src="{{url('/js/jquery.dataTables.min.js')}}" type="text/javascript" language="javascript"></script>

    <script type="text/javascript">
      $.extend( true, $.fn.dataTable.defaults, {
        "language": {
          "url": "{{ asset('vendor/datatables/es_ES.json')}}"
        }
      } );
    </script>
    <!-- Laravel Javascript Validation -->
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}" type="text/javascript" language="javascript"></script>
    @stack('script_data_table')
  </head>
  <body>
    @include('includes.header')

    <div class="wrap">
      @yield('content')
    </div>

    @include('includes.footer')
  </body>
</html>
