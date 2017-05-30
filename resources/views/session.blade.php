<form id="login" action="{{$inputs['url']}}/session.php" method="post">
  <input type="hidden" name="app" value="{{$inputs['app']}}"/>
  <input type="hidden" name="idUsuario" value="{{$inputs['idUsuario']}}"/>
  <input type="hidden" name="idTercero" value="{{$inputs['idTercero']}}"/>
  <input type="hidden" name="ultimoIngreso" value="{{$inputs['ultimoIngreso']}}"/>
  <input type="hidden" name="cedula" value="{{$inputs['cedula']}}"/>
  <input type="hidden" name="nombreCompleto" value="{{$inputs['nombreCompleto']}}"/>
  <input type="hidden" name="correoElectronico" value="{{$inputs['correoElectronico']}}"/>
  <input type="hidden" name="ven_id" value="{{$inputs['ven_id']}}"/>
</form>
<script type="text/javascript">
  document.getElementById('login').submit();
</script>
