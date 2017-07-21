@extends('app')

@section('content')
  @include('includes.titulo')
  <div class="panel panel-default">
    <div class="panel-body">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#solicitadas" aria-controls="solicitadas" role="tab" data-toggle="tab">Solicitadas</a></li>
        <li role="presentation"><a href="#generadas" aria-controls="generadas" role="tab" data-toggle="tab">Generadas</a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="solicitadas">
          <div class="col-sm-12" style="padding-top: 20px;">
            {!! Form::open(['url' => 'pricat/generar']) !!}
            <table id="tabla1" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Nit Cliente</th>
                  <th class="text-center">Tipo Novedad</th>
                  <th class="text-center">Fecha Solicitud</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($solicitadas as $solicitud)
                <tr>
                  <td class="text-center">{{ $solicitud->id }}</td>
                  <td>{{ $solicitud->clientes->cli_nit }} - {{ $solicitud->clientes->terceros->razonSocialTercero }}</td>
                  <td class="text-center">{{ $solicitud->sop_tnovedad }}</td>
                  <td class="text-center">{{ Carbon\Carbon::parse($solicitud->created_at)->format('d/M/Y') }}</td>
                  <td  class="text-center">{!! Form::radio('solicitud', $solicitud->id) !!}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="row text-center" style="padding-top: 20px;">
              <button class="btn btn-primary" type="submit">Generar</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="generadas">
          <div class="col-sm-12" style="padding-top: 20px;">
            {!! Form::open(['url' => 'pricat/generar']) !!}
            <table id="tabla2" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Nit Cliente</th>
                  <th class="text-center">Tipo Novedad</th>
                  <th class="text-center">Fecha Solicitud</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($generadas as $solicitud)
                <tr>
                  <td class="text-center">{{ $solicitud->id }}</td>
                  <td>{{ $solicitud->clientes->cli_nit }} - {{ $solicitud->clientes->terceros->razonSocialTercero }}</td>
                  <td class="text-center">{{ $solicitud->sop_tnovedad }}</td>
                  <td class="text-center">{{ Carbon\Carbon::parse($solicitud->created_at)->format('d/M/Y') }}</td>
                  <td  class="text-center">{!! Form::radio('solicitud', $solicitud->id) !!}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="row text-center" style="padding-top: 20px;">
              <button class="btn btn-primary" type="submit">Generar</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script_data_table')
  <script type="text/javascript">
    $(document).ready(function () {
      $("#tabla1").DataTable();
      $("#tabla2").DataTable();
    })
  </script>
@endpush
