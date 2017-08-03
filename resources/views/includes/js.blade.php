<!-- jQuery 3.1.1 -->
<script src="{{url('/js/jquery.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- jQuery.UI -->
<script src="{{url('/js/jquery-ui.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- DataTables 1.10.13 -->
<script src="{{url('/js/jquery.dataTables.min.js')}}" type="text/javascript" language="javascript"></script>

<script type="text/javascript">
$.extend( true, $.fn.dataTable.defaults, {
  "language": {
    "url": "{{ asset('vendor/datatables/es_ES.json')}}"
  }
} );
</script>

<!-- AngularJs -->
<script src="{{url('/js/angularJs/angular.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-filter.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-animate.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-aria.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-messages.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-material.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-datatables.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- Moment -->
<script src="{{url('/js/moment.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{url('/js/bootstrap.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- Laravel Javascript Validation -->
<script src="{{asset('vendor/jsvalidation/js/jsvalidation.js')}}" type="text/javascript" language="javascript"></script>

<!-- FileInput (https://github.com/kartik-v/bootstrap-fileinput) -->
<script src="{{url('/js/fileinput/fileinput.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/fileinput/locales/es.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/fileinput/themes/explorer/theme.js')}}" type="text/javascript" language="javascript"></script>

<script src="{{url('/js/genericas.js')}}" type="text/javascript" language="javascript"></script>

@stack('script_data_table')
@stack('script_angularjs')
@stack('script_custom')
