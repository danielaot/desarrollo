@extends('app')

@section('content')
  @include('includes.titulo')
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach($desarrollos as $desarrollo)
          <div class="panel panel-default">
            <div class="panel-heading" role="tab">
              <h4 class="panel-title row">
                <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$loop->iteration}}">
                  <div class="col-sm-12">
                    {{$desarrollo[0]->proyectos->proy_nombre}}
                  </div>
                </a>
              </h4>
            </div>
            <div id="collapse{{$loop->iteration}}" class="panel-collapse collapse" role="tabpanel">
              <div class="panel-body">
                <ul class="list-group">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-4">
                        {{$desarrollo[0]->actividades->act_titulo}}
                      </div>
                      <div class="col-sm-6">
                        {{$desarrollo[0]->actividades->act_descripcion}}
                      </div>
                      <div class="col-sm-2 text-right">
                        <a href="{{route($desarrollo[0]->actividades->act_plantilla.'.index', ['proy' => $desarrollo[0]->dac_proy_id, 'act' => $desarrollo[0]->actividades->id])}}">
                          <button class="btn btn-primary btn-sm">
                            <i class="glyphicon glyphicon-pencil"></i> Realizar
                          </button>
                        </a>
                      </div>
                    </div>
                  </li>
                  @if(count($desarrollo) > 1)
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-sm-4">
                          {{$desarrollo[1]->actividades->act_titulo}}
                        </div>
                        <div class="col-sm-6">
                          {{$desarrollo[1]->actividades->act_descripcion}}
                        </div>
                        <div class="col-sm-2 text-right">
                          <a href="{{route($desarrollo[1]->actividades->act_plantilla.'.index', ['proy' => $desarrollo[1]->dac_proy_id, 'act' => $desarrollo[1]->actividades->id])}}">
                            <button class="btn btn-primary btn-sm">
                              <i class="glyphicon glyphicon-pencil"></i> Realizar
                            </button>
                          </a>
                        </div>
                      </div>
                    </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
