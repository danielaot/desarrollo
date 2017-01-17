@extends('app')

@section('title', 'Reimprimir Factura')

@section('content')
  <section style=" margin-top: 20px;">
    <table id="tabla" cellspacing="0" cellpadding="2" width="98%" class="display" align="center" style=" font-size: 13px;">
      <thead>
        <tr style="background: #366092; color: white">
          <th>Factura</th>
          <th>Cliente</th>
          <th>Fecha Creaci&oacute;n</th>
          <th>Usuario Facturador</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($facturas as $factura)
          <tr>
            <td>{{ $factura->numfactura }}</td>
            <td>{{ $factura->ped_nitcliente }} - {{ $factura->nombrecliente }}</td>
            <td style="text-align: center;">{{ $factura->ped_fechaorden }}</td>
            <td>{{ $factura->nombrefacturador }}</td>
            <td style=" text-align: center; font-size: 15px;">
                <a class="btn btn-danger label label-danger" href="{{ url('imprimirfactura', ['ped_id' => $factura->ped_id]) }}" target="_blank">
                  Imprimir
                </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </section>
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $("#tabla").DataTable({
        "language": {
          "sProcessing": "Procesando...",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sZeroRecords": "No se encontraron resultados",
          "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
          "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix": "",
          "sSearch": "Buscar:",
          "sUrl": "",
          "sInfoThousands": ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      });
    })
  </script>
  <!--script type="text/javascript">
    $(function(){
      $('#tabla').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! URL::asset('facturasdata') !!}',
        columns : [
          { data: 'ped_id', name: 'factura' },
          { data: 'nombrecliente', name: 'cliente' },
          { data: 'ped_fechaorden', name: 'fechaorden' },
          { data: 'nombrefacturador', name: 'facturador' },
        ],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
      });
    });
  </script-->
@endpush
