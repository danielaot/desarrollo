@extends('app')

@section('content')
  @include('layouts.header')
  <div class="wrap">
    <div class="container login">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                      <div class="form_description">
                        <h2>Ingreso</h2>
                        <p>Ingrese la siguiente informaci&oacute;n para acceder a los aplicativos</p>
                      </div>
                      {!! Form::open(['url' => 'login', 'method' => 'post', 'role' => 'form']) !!}
                        <div class="col-md-6">
                          <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="login" class="control-label">Usuario <font color="red">*</font></label>
                            {{ Form::text('login', old('login'), ['class' => 'form-control', 'required' => '', 'autofocus' => '']) }}
                            @if ($errors->has('login'))
                              <span class="help-block">
                                <strong>{{ $errors->first('login') }}</strong>
                              </span>
                            @endif
                          </div>
                          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Contraseña <font color="red">*</font></label>
                            {{ Form::password('password', ['class' => 'form-control', 'required' => '']) }}
                            @if ($errors->has('password'))
                              <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                              </span>
                            @endif
                          </div>
                          <div class="form-group">
                            <label>Los campos con <font color="red">*</font> son obligatorios.</label>
                          </div>
                          <div class="form-group">
                            {{ Form::submit('Continuar', ['class' => 'btn btn-primary btn-sm']) }}
                            {{ Form::button('Cancelar', ['class' => 'btn btn-primary btn-sm']) }}
                          </div>
                        </div>
                        <div class="col-md-6">
                          <img src="{{url('/img/login.jpg')}}"/>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  @include('layouts.footer')
@endsection
