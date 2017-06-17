@extends('app')

@section('content')
  @include('includes.titulo')
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="row">
            <label class="col-sm-4">Referencia :</label>
            <p class="col-sm-8">{{$item['ite_referencia']}}</p>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="row">
            <label class="col-sm-3">Descripción :</label>
            <p class="col-sm-9">{{$item['detalles']['ide_descompleta']}}</p>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-4">
          <div class="row">
            <label class="col-sm-4">Categoria :</label>
            <p class="col-sm-8">{{$item['detalles']['ide_categoria']}} - {{$item['detalles']['categoria']['descripcionItemCriterioMayor']}}</p>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="row">
            <label class="col-sm-3">Línea :</label>
            <p class="col-sm-9">{{$item['detalles']['ide_linea']}} - {{$item['detalles']['linea']['descripcionItemCriterioMayor']}}</p>
          </div>
        </div>
      </div>
      @if($item['tipo']['descripcionItemCriterioMayor'] != 'Regular')
        <br>
        <div class="row">
          <div class="col-sm-3">
            <div class="row">
              <label class="col-sm-6">Componente 1 :</label>
              <p class="col-sm-6">{{$item['detalles']['ide_comp1']}}</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="row">
              <label class="col-sm-6">Componente 2 :</label>
              <p class="col-sm-6">{{$item['detalles']['ide_comp2']}}</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="row">
              <label class="col-sm-6">Componente 3 :</label>
              <p class="col-sm-6">{{$item['detalles']['ide_comp3']}}</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="row">
              <label class="col-sm-6">Componente 4 :</label>
              <p class="col-sm-6">{{$item['detalles']['ide_comp4']}}</p>
            </div>
          </div>
        </div>
      @endif
      <br>
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <label class="col-sm-2">Posición Arancelaria :</label>
            <p class="col-sm-8">{{$item['detalles']['ide_posarancelaria']}} - {{$posarancelaria->desc_pos_arancelaria}}</p>
          </div>
        </div>
      </div>
      <br>
      {!! Form::open(['route' => ['paso5.update', $item['id']], 'method' => 'PUT']) !!}
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <label class="col-sm-3">Grupo Impositivo :</label>
              <div class="col-sm-6">
                <select class="form-control" name="grupoimpo" required>
                  <option value=""></option>
                  @foreach($grupoimpositivo as $grupo)
                    <option value="{{$grupo->cod_grupoimpo}}">{{$grupo->desc_grupoimpo}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="text-center">
            <input type="hidden" name="proy" value="{{$idproyecto}}"/>
            <input type="hidden" name="act" value="{{$idactividad}}"/>
            {{ Form::submit('Asignar', array('class' => 'btn btn-primary')) }}
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>

@endsection
