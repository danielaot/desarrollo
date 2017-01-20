<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link type="image/x-icon" href="favicon.png" rel="icon"/>

    <title>Aplicativos Belleza Express S.A.</title>

    <!-- Styles -->
    <!--******************** CSS BOOTSTRAP *********************-->
    <link href="{{url('/css/bootstrap.min.css')}}" type="text/css" rel="stylesheet" />
    <!--******************** CSS BESA **************************-->
    <link href="{{url('/css/besa.css')}}" type="text/css" rel="stylesheet"/>
    <link href="{{url('/css/login.css')}}" type="text/css" rel="stylesheet"/>
  </head>
  <body>
    @include('includes.header')

    <div class="wrap">
      <div class="container login">
        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-primary">
            <div class="panel-heading"></div>
            <div class="panel-body">
              <div class="form_description">
                <h2>Ingreso</h2>
                <p>Ingrese la siguiente informaci&oacute;n para acceder a los aplicativos</p>
              </div>
              {!! Form::open(['url' => 'login', 'method' => 'post', 'role' => 'form']) !!}
                @if ($errors->has('login'))
                  <div class="form-group has-error">
                    <span class="help-block">
                      <strong>{{ $errors->first('login') }}</strong>
                    </span>
                  </div>
                @endif
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                      <label for="login" class="control-label">Usuario <font color="red">*</font></label>
                      {{ Form::text('login', old('login'), ['class' => 'form-control', 'required' => '', 'autofocus' => '']) }}
                    </div>
                    <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                      <label for="password" class="control-label">Contraseña <font color="red">*</font></label>
                      {{ Form::password('password', ['class' => 'form-control', 'required' => '']) }}
                    </div>
                    <div class="form-group">
                      <label>Los campos con <font color="red">*</font> son obligatorios.</label>
                    </div>
                    <div class="form-group">
                      {{ Form::submit('Continuar', ['class' => 'btn btn-primary btn-sm']) }}
                      {{ Form::button('Cancelar', ['class' => 'btn btn-primary btn-sm']) }}
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <img src="{{url('/img/login.jpg')}}"/>
                  </div>
                </div>
              {!! Form::close() !!}
              <div class="options txt-center">
                <span>
                  |&nbsp;
                  <a href="{{env('APPV1_INGRESO')}}/index.php?op=REG">Crear Cuenta</a>
                  &nbsp;|&nbsp;
                  <a href="{{env('APPV1_INGRESO')}}/index.php?op=REC">Recuperar Contraseña</a>
                  &nbsp;|
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('includes.footer')
  </body>
</html>
