<table border="1">

  <tr>
    <th scope="col">Numero</th>
    <th scope="col">Suma</th>
    <th scope="col">Formula</th>
    <th scope="col">Mes</th>
  </tr>

  @foreach ($pruebas as $prueba)
    <tr>
      <td>{{ $prueba->prc_numero }}</td>
      <td>{{ $prueba->prc_suma }}</td>
      <td>{{ $prueba->prc_formulas }}</td>
      <td>{{ $prueba->id }}</td>
    </tr>
  @endforeach
  
</table>