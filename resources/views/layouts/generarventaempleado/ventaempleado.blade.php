@extends('app')

@section('title', 'Generar Venta')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-body">
          {!! Form::open(['url' => 'generarventa', 'method' => 'post']) !!}
            @if(!empty($inputs))
              {{Form::hidden('ped_id', $inputs['ped_id'])}}
              {{Form::hidden('ped_usuario', $inputs['ped_usuario'] ? $inputs['ped_usuario'] : '1130604678')}}
            @else
              {{Form::hidden('ped_id', old('ped_id'))}}
              {{Form::hidden('ped_usuario', old('ped_usuario') ? old('ped_usuario') : '1130604678')}}
            @endif
            <div class="encabezado">
              <img src="{{url('/img/iconoHoja.png')}}" class="hojaP"/>
              <p>Informaci&oacute;n Empleado</p>
              <img src="{{url('/img/logo3.png')}}" class="hojaG"/>
            </div>
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  {{$error}} <b></b><br/>
                @endforeach
              </div>
            @endif
            <div style="margin: 30px auto 0; padding: 0 15px;">
              <div class="form-group">
                <div class="subtitulo">
                  <em style=" margin-left: 10px;">Identificaci&oacute;n Empleado(a):</em>
                </div>
                <div style=" margin-top: 10px;">
                  @if(!empty($inputs))
                    {{Form::text('ped_nitcliente', $inputs['ped_nitcliente'], ['class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Consultar por Nombre o Cédula'])}}
                  @else
                    {{Form::text('ped_nitcliente', old('ped_nitcliente'), ['class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Consultar por Nombre o Cédula'])}}
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <em>Referencia:</em>
                    @if(!empty($inputs))
                      {{Form::text('det_referencia', $inputs['det_referencia'], ['class' => 'form-control', 'style' => 'text-align: right;'])}}
                    @else
                      {{Form::text('det_referencia', old('det_referencia'), ['class' => 'form-control', 'style' => 'text-align: right;'])}}
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <em>Cantidad:</em>
                    @if(!empty($inputs))
                      {{Form::number('det_cantida', $inputs['det_cantida'], ['class' => 'form-control', 'style' => 'text-align: right;'])}}
                    @else
                      {{Form::number('det_cantida', old('det_cantida') ? old('det_cantida') : '1', ['class' => 'form-control', 'style' => 'text-align: right;'])}}
                    @endif
                  </div>
                </div>
              </div>
              <div class="modal-footer" style="height: 90px; margin: 30px -30px 0;">
                <img src="{{url('/img/BellezaExpress.jpg')}}" style=" height: 50px; width: 180px; float: left;"/>
                {{Form::submit('Adicionar', ['class' => 'btn btn-primary'])}}
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Items Comprados
          @if(!empty($pedido))
            @if(count($pedido->pedidodetalle) > 0)
              <a class="btn btn-warning label" onclick="finalizarcompra({{$pedido->ped_id}})">Finalizar Compra</a>
            @endif
          @endif
        </div>
        <div class="panel-body">
          @if(!empty($pedido))
            <table id="tabla" cellspacing="0" cellpadding="2" width="98%" class="display" align="center" style=" font-size: 13px;">
              <thead>
                <tr style="background: #366092; color: white">
                  <th style=" width: 10%;">Referencia</th>
                  <th style=" width: 50%;">Descripci&oacute;n</th>
                  <th style=" width: 10%;">Cantidad</th>
                  <th style=" width: 20%;">Valor</th>
                  <th style=" width: 10%;">Acci&oacute;n</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pedido->pedidodetalle as $detalle)
                  <tr>
                    <td>{{ $detalle->det_referencia }}</td>
                    <td>{{ $detalle->item->descripcionItem }}</td>
                    <td style="text-align: right;">{{ $detalle->det_cantida }}</td>
                    <td style="text-align: right;">{{ number_format($detalle->det_valor) }}</td>
                    <td style=" text-align: center; font-size: 15px;">
                      <button type="button" class="btn btn-danger label label-danger" data-toggle="modal" data-target="#confirmEliminar{{$detalle->det_referencia}}">
                        Eliminar
                      </button>
                      <div class="modal fade" id="confirmEliminar{{$detalle->det_referencia}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              Realmente Desea Eliminar la Referencia ?
                            </div>
                            <div class="modal-footer">
                              {!! Form::open(['url' => 'eliminarreferencia', 'method' => 'post']) !!}
                                {{Form::hidden('ped_id', $pedido->ped_id)}}
                                {{Form::hidden('ref_id', $detalle->det_referencia)}}
                                {{Form::submit('Aceptar', ['class' => 'btn btn-primary'])}}
                                {{Form::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])}}
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tbody>
                <tr>
                  <td colspan="2" style="text-align: right;"><b>TOTAL</b></td>
                  <td style="text-align: right;"><b>{{$pedido->total_unidades}}</b></td>
                  <td style="text-align: right;"><b>{{number_format($pedido->total)}}</b></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          @else
            @if(!empty($inputs['fincompra']))
              <div class="alert alert-success" style=" width: 80%; margin: auto; text-align: center;">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Factura Generada Exitosamente!
              </div>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
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
    });

    function finalizarcompra(id){
      //Open in new tab
      window.open("{{ url('imprimirfactura') }}/"+id, '_blank');
      //focus to thet window
      window.focus();
      //reload current page
      window.open("{{ url('finalizarcompra') }}/"+id, '_self');
    }
  </script>
@endpush
