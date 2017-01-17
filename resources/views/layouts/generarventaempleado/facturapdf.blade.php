<style type="text/css">
    body {
        margin: 0cm;
        font-family: sans-serif;
        font-size: 10px;
        margin: 2px;
    }
</style>
<table width="540" border="0" style="border-collapse: collapse;">
  <tr>
    <td align="left" valign="middle" colspan="3">
      <img src="{{url('/img/bellezaexpressLogo.jpg')}}" width="100">
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle" colspan="3">
      <h3>REMISION EMPLEADO - FERIA DE INNOVACI&Oacute;N</h3>
    </td>
  </tr>
  <tr>
    <td width="80%" style="border-bottom: 1px solid #000000;">
      <strong>CONSECUTIVO INTERNO: {{ $pedido->numfactura }} </strong>
    </td>
    <td width="10%" style="border-bottom: 1px solid #000000;">
      <strong>FECHA </strong>
    </td>
    <td width="10%" style="border-bottom: 1px solid #000000;">
      <strong>{{ $pedido->fechaorden }}</strong>
    </td>
  </tr>
</table>
<table>
  <tr>
    <td height="0">&nbsp;</td>
  </tr>
</table>
<table width="540" border="0" style="border-collapse:collapse;">
  <tr>
    <td><b>Nombre: </b></td>
    <td colspan="2">{{ $pedido->nombrecliente }}</td>
  </tr>
  <tr>
    <td width="15%"><b>Nit / Identificaci&oacute;n:</b></td>
    <td width="85%" colspan="2">{{ $pedido->ped_nitcliente }}</td>
  </tr>
</table>
<table>
  <tr>
    <td height="0">&nbsp;</td>
  </tr>
</table>
<table width="540" border="1" style="border-collapse:collapse;">
  <tr>
    <th align="center" width="10%" style="background: #D9D9D9; padding: 5px;">REF.</th>
    <th align="center" width="40%" style="background: #D9D9D9;">DESCRIPCION</th>
    <th align="center" width="10%" style="background: #D9D9D9;">CANTIDAD</th>
    <th align="center" width="10%" style="background: #D9D9D9;">VALOR UNITARIO</th>
    <th align="center" width="10%" style="background: #D9D9D9;">VALOR TOTAL</th>
  </tr>
  @foreach($pedido->pedidodetalle as $detalle)
    <tr>
      <td align="center" style="padding: 2px;">{{ $detalle->det_referencia }}</td>
      <td align="left">{{ $detalle->item->descripcionItem }}</td>
      <td align="right">{{ $detalle->det_cantida }}</td>
      <td align="right">
        {{ number_format($detalle->det_valor/$detalle->det_cantida, 0, '', '.') }}
      </td>
      <td align="right">
        {{ number_format($detalle->det_valor, 0, '', '.') }}
      </td>
    </tr>
  @endforeach
  <tr>
    <th align="right" style="background: #D9D9D9; padding: 5px;" colspan="2">TOTAL</th>
    <th align="right" style="background: #D9D9D9;">{{ $pedido->total_unidades }}</th>
    <th align="right" style="background: #D9D9D9;">{{ number_format($pedido->total_precio_unidades, 0, '', '.') }}</th>
    <th align="right" style="background: #D9D9D9;">{{ number_format($pedido->total, 0, '', '.') }}</th>
  </tr>
</table>
<br/><br/><br/><br/>
<div style="text-align:center;width:580px; margin-left:80px">
Por medio de este documento, y de conformidad con el numeral 1 del art&iacute;culo 59 y el art&iacute;culo 149 del C&oacute;digo Sustantivo del Trabajo, autorizo a la empresa BELLEZA EXPRESS S.A para que descuente de mi n&oacute;mina quincenal el valor que sume la compra de los anteriores productos en m&aacute;ximo dos cuotas quincenales iguales. En el evento de desvincularme de la Compa&ntilde;&iacute;a, favor descontar el saldo de mi liquidaci&oacute;n definitiva de prestaciones sociales.
</div><br><br><br><br>
<table cellpadding="1" cellspacing="0"  width="540" style="border-collapse:collapse; ">
    <tr>
        <td width="30%" align="center">&nbsp;</td>
        <td width="5%" align="left">&nbsp;</td>
        <td width="30%" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td align="left" style="border-bottom: 1px solid #000000;">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left" style="border-bottom: 1px solid #000000;">&nbsp;</td>
    </tr>
    <tr>
        <td align="center">ENTREGADO POR</td>
        <td align="left">&nbsp;</td>
        <td align="center">RECIBIDO CONFORME Y APRUEBO</td>
    </tr>
</table>
