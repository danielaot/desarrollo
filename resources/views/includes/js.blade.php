<!-- jQuery 3.1.1 -->
<script src="{{url('/lib/jquery.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- jQuery.UI -->
<script src="{{url('/lib/jquery-ui.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- DataTables 1.10.13 -->
<script src="{{url('/lib/jquery.dataTables.min.js')}}" type="text/javascript" language="javascript"></script>

<script type="text/javascript">
$.extend( true, $.fn.dataTable.defaults, {
  "language": {
    "url": "{{ asset('vendor/datatables/es_ES.json')}}"
  }
} );
</script>

<!-- Moment -->
<script src="{{url('/lib/moment.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- AngularJs -->
<script src="{{url('/lib/angularJs/angular.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-filter.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-animate.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-aria.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-messages.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-sanitize.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-material.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-datatables.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/calendar.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/angularJs/angular-locale_es-co.js')}}"></script>

<!-- FullCalendarJs -->
<script src="{{url('/lib/fullcalendarjs/fullcalendar.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/fullcalendarjs/gcal.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/fullcalendarjs/scheduler.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{url('/lib/bootstrap.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/lib/bootstrap-datetimepicker.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- Laravel Javascript Validation -->
<script src="{{asset('vendor/jsvalidation/js/jsvalidation.js')}}" type="text/javascript" language="javascript"></script>

<!-- DATETIMEPICKER -->
<script src="{{url('/lib/datetimepicker/angular-material-datetimepicker.min.js')}}"></script>

<!-- Dropzone -->
<script src="{{url('/lib/dropzone.js')}}" type="text/javascript" language="javascript"></script>

<!-- angular-multiselect -->
<script src="{{url('/lib/angularJs/angular-bootstrap-multiselect.min.js')}}" type="text/javascript" language="javascript"></script>

<!-- underscore -->
<script src="{{url('/lib/underscore/underscore.min.js')}}" type="text/javascript" language="javascript"></script>


<script src="{{url('/js/genericas.js')}}" type="text/javascript" language="javascript"></script>

@stack('script_data_table')
@stack('script_angularjs')
@stack('script_custom')
