@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="generarCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#solicitadas" aria-controls="solicitadas" role="tab" data-toggle="tab">Solicitudes</a></li>
          <li role="presentation"><a href="#generadas" aria-controls="generadas" role="tab" data-toggle="tab">Cargadas</a></li>
          <li role="presentation"><a href="#logyca" aria-controls="logyca" role="tab" data-toggle="tab">Items Por Codificar</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="solicitadas">
            <div class="col-sm-12" style="padding-top: 20px;">
              {!! Form::open(['url' => 'pricat/generar']) !!}
                <table datatable="ng" dt-options="dtOptions1" dt-column-defs="dtColumnDefs1" class="row-border hover">
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
                    <tr ng-repeat="solicitud in solicitadas">
                      <td class="text-center">@{{ solicitud.id }}</td>
                      <td>@{{ solicitud.clientes.cli_nit }} - @{{ solicitud.clientes.terceros.razonSocialTercero }}</td>
                      <td class="text-center">@{{ solicitud.sop_tnovedad }}</td>
                      <td class="text-center">@{{ solicitud.created_at | date : 'd/M/Y' }}</td>
                      <td  class="text-center"><input type="radio" name="solicitud" value="@{{ solicitud.id }}"></td>
                    </tr>
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
                <table datatable="ng" dt-options="dtOptions2" dt-column-defs="dtColumnDefs2" class="row-border hover">
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
                    <tr ng-repeat="solicitud in generadas">
                      <td class="text-center">@{{ solicitud.id }}</td>
                      <td>@{{ solicitud.clientes.cli_nit }} - @{{ solicitud.clientes.terceros.razonSocialTercero }}</td>
                      <td class="text-center">@{{ solicitud.sop_tnovedad }}</td>
                      <td class="text-center">@{{ solicitud.created_at | date : 'd/M/Y' }}</td>
                      <td  class="text-center"><input type="radio" name="solicitud" value="@{{ solicitud.id }}"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="row text-center" style="padding-top: 20px;">
                  <button class="btn btn-primary" type="submit">Generar</button>
                </div>
              {!! Form::close() !!}
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="logyca">
            <div class="col-sm-12" style="padding-top: 20px;">
              {!! Form::open(['url' => 'pricat/generar']) !!}
                <table datatable="ng" class="row-border hover">
                  <thead>
                    <tr>
                      <th></th>
                      <th class="text-center">Referencia</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="item in items">
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
                <div class="row text-center" style="padding-top: 20px;">
                  <button class="btn btn-primary" type="submit">Crear</button>
                </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
      <div ng-if="progress" class="progress">
        <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
      </div>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/generarCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
