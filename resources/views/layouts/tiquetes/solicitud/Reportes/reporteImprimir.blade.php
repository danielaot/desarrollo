<html>
	<head>
        <style>
            .table1{
                border-collapse:collapse;
            }
            .table1, td, th{
                border: 0.5px solid #999;
            }

            table{
                padding-left: 2px;   
            }
            table, td, th{
                padding-left: 2px;
                padding-right: 2px;
                }
           
            .fuente_10{
                font-size: 10px;
            }    
            .fuente_11{
                font-size: 11px;
            }
            .fuente_13{
                font-size: 13px;
            }
        </style>
	</head>
	<body>
		<table width="100%" class="table1">
            <tr>
                <td width="50" rowspan="4">
                	<img src="{{url('images/logo1.jpg')}}" width="200"/>
                </td>
                <td rowspan="2" align="center" class="fuente_13">
                	<strong>GERENCIA DE OPERACIONES</strong>
                </td>
                <td width="110" class="fuente_11">Código: 
                	<strong>GOP-FOR-004</strong>
                </td>
            </tr>
            <tr>
                <td class="fuente_11">Edición No. 03</td>
            </tr>
            <tr>
                <td rowspan="2" align="center" class="fuente_13">
                	<strong>SOLICITUD Y RESERVA DE TIQUETES AEREOS Y HOTEL</strong>
                </td>
                <td class="fuente_11">Fecha de emisión: 22-Mar-13</td>
            </tr>
            <tr>
                <td class="fuente_11">Pagina 1 de 1</td>
            </tr>
        </table>

        <br/><br/>
        <table width="100%">
            <tr>
                <td class="fuente_11" width="100" style="background: #CCCCCC; border: 0px">
                	<strong>No. Solicitud:</strong>
                </td>
                <td class="fuente_11" style="border: 0.5px solid #999" width="235">
                	<strong>{{$solicitudImprimir['solIntSolId']}}</strong>
                </td>
                <td class="fuente_11" width="100" style="background: #CCCCCC; border: 0px">Fecha de Solcitud:</td>
                <td class="fuente_11" style="border: 0.5px solid #999">{{$fechaSolicitud}}</td>
            </tr>

            @if ($solicitudImprimir['solTxtPerExterna'] == 2)
    			<tr>
                	<td class="fuente_11" style="background: #CCCCCC; border: 0px">
                		Nombre Solicitante:
                	</td>
                	<td class="fuente_11" colspan="3" style="border: 0.5px solid #999">	
                		{{$solicitudImprimir['solTxtNomtercero']}}
                	</td>
            	</tr>
			@else
    			<tr>
                	<td class="fuente_11" style="background: #CCCCCC; border: 0px">Nombre del Viajero:</td>
                	<td class="fuente_11" style="border: 0.5px solid #999">
                		{{$solicitudImprimir['solTxtNomtercero']}}
                	</td>
                	<td class="fuente_11" style="background: #CCCCCC; border: 0px">Cedula:</td>
                	<td class="fuente_11" style="border: 0.5px solid #999">
                		{{$solicitudImprimir['solTxtCedtercero']}}
                	</td>
            	</tr>
            	<tr>
                	<td class="fuente_11" style="background: #CCCCCC; border: 0px">
                		Fecha de Nacimiento:
                	</td>
                	<td class="fuente_11" style="border: 0.5px solid #999">
                		{{$fechaNacimiento}}
                	</td>
                	<td class="fuente_11" style="background: #CCCCCC; border: 0px">
                		Numero Telefono:
                	</td>
                	<td class="fuente_11" style="border: 0.5px solid #999">
                		{{$solicitudImprimir['solTxtNumTelefono']}}
                	</td>    
            	</tr>
			@endif

			<tr>
                <td class="fuente_11" style="background: #CCCCCC; border: 0px">Gerencia:</td>
                <td class="fuente_11" colspan="3" style="border: 0.5px solid #999">
                	{{$solicitudImprimir['personaGerencia']['gerencia']['ger_nom']}}
                </td>
            </tr>

            @if($solicitudImprimir['solIntTiposolicitud'] == 2)
            	<tr>
                    <td class="fuente_11" style="background: #CCCCCC; border: 0px" colspan="4">
                    	<b>Datos Pasaporte</b>
                    </td>
                </tr>
                <tr>
                    <td class="fuente_11" style="background: #CCCCCC; border: 0px">No.</td>
                    <td class="fuente_11" style="border: 0.5px solid #999">
                    	{{$solicitudImprimir['personaGerencia']['perTxtNoPasaporte']}}
                    </td>
                    <td class="fuente_11" style="background: #CCCCCC; border: 0px">Fecha Caducidad:
                    </td>
                    <td class="fuente_11" style="border: 0.5px solid #999">
                    	{{$solicitudImprimir['personaGerencia']['perTxtFechaCadPass']}}
                    </td>
                </tr>
                <tr>
                    <td class="fuente_11" style="background: #CCCCCC; border: 0px">Ciudad de expedición:</td>
                    <td class="fuente_11" style="border: 0.5px solid #999">
                    	{{$solicitudImprimir['personaGerencia']['perIntCiudadExpPass']}}
                	</td>
                </tr>
            @endif
			
			@if($solicitudImprimir['solTxtPerExterna'] == 2)
				<tr>
	                <td class="fuente_11" style="background: #CCCCCC; border: 0px" colspan="4">
	                	<b>Datos Viajero Externo</b>
	                </td>
	            </tr>
	            <tr>
	                <td class="fuente_11" style="background: #CCCCCC; border: 0px">Nombre:</td>
	                <td class="fuente_11" style="border: 0.5px solid #999">
	                	{{$solicitudImprimir['perExterna']['pereTxtNombComple']}}
	                </td>
	                <td class="fuente_11" style="background: #CCCCCC; border: 0px">Identificacion:</td>
	                <td class="fuente_11" style="border: 0.5px solid #999">
	                	{{$solicitudImprimir['perExterna']['pereTxtCedula']}}
	                </td>
	            </tr>
	            <tr>
	                <td class="fuente_11" style="background: #CCCCCC; border: 0px">Fecha Nacimiento:</td>
	                <td class="fuente_11" style="border: 0.5px solid #999">
	                	{{$solicitudImprimir['perExterna']['pereTxtFNacimiento']}}
	                </td>
	                <td class="fuente_11" style="background: #CCCCCC; border: 0px">Numero de Celular:</td>
	                <td class="fuente_11" style="border: 0.5px solid #999">
	                	{{$solicitudImprimir['perExterna']['pereTxtNumCelular']}}
	                </td>
	            </tr>
	            <tr>
	                <td class="fuente_11" style="background: #CCCCCC; border: 0px">Email:</td>
	                <td class="fuente_11" colspan="3" style="border: 0.5px solid #999">
	                	{{$solicitudImprimir['perExterna']['pereTxtEmail']}}
	                </td>
	            </tr>
	        @endif
        </table>

        <table width="100%">
            <tr>
                <td class="fuente_11" align="center" style="background: #CCCCCC; border: 0px">
                	<strong>Motivo del Viaje</strong>
                </td>
            </tr>
            <tr>
                <td class="fuente_11" style="border: 0.5px solid #999; text-align:justify;">
                	{{$solicitudImprimir['solTxtObservacion']}}
                </td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td class="fuente_11" align="center" style="background: #CCCCCC; border: 0px">
                	<strong>ITINERARIOS DE VUELO</strong>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
                    <table width="100%" class="table1">
                    	@foreach ($solicitudImprimir['detalle'] as $vuelo)
                    		<tr>
                            	<td class="fuente_11" style="border: 0.5px solid #999; background: #CCCCCC;" rowspan="4" align="center">
                            		<strong>{{$vuelo['contador']}}</strong>
                            	</td>
	                            <td class="fuente_11" style="border: 0.5px solid #999; background: #CCCCCC;">
	                            	<strong>Aerolinea</strong>
	                            </td>
	                            <td class="fuente_11" colspan="2" style="border: 0.5px solid #999; ">
	                            	{{$vuelo['aerolinea']['aerTxtNombre']}}
	                            </td>
	                            <td class="fuente_11" style="border: 0.5px solid #999; background: #CCCCCC;">
	                            	<strong>#Reserva</strong>
	                            </td>
	                            <td class="fuente_11" colspan="2" style="border: 0.5px solid #999; ">
	                            	{{$vuelo['dtaTxtResvuelo']}}
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="fuente_11" style="border: 0.5px solid #999; background: #CCCCCC;">
	                            	<strong>Ciudad Origen</strong>
	                            </td>
	                            <td class="fuente_11" style="border: 0.5px solid #999; background: #CCCCCC;">
	                            	<strong>Ciudad Destino</strong>
	                            </td>
	                            <td class="fuente_11" style="border: 0.5px solid #999; background: #CCCCCC;" colspan="2">
	                            	<strong>Fecha y Hora</strong>
	                            </td>
	                            <td class="fuente_11" style="border: 0.5px solid #999; background: #CCCCCC;" colspan="2">
	                            	<strong>Hotel</strong>
	                            </td>
	                        </tr>
	                        <tr>
	                        	@if($solicitudImprimir['solIntTiposolicitud'] == 1)
		                            <td class="fuente_11" style="border: 0.5px solid #999;" rowspan="2">
		                            	{{$vuelo['ciuOrigen']['departamento']['depTxtNom']}} - {{$vuelo['ciuOrigen']['ciuTxtNom']}}
		                            </td>
		                            <td class="fuente_11" style="border: 0.5px solid #999;" rowspan="2">
		                            	{{$vuelo['ciuDestino']['departamento']['depTxtNom']}} - {{$vuelo['ciuDestino']['ciuTxtNom']}}
		                            </td>
	                            @else
		                            <td class="fuente_11" style="border: 0.5px solid #999;" rowspan="2">
		                            	{{$vuelo['dtaTxtOCiu']}}
		                            </td>
		                            <td class="fuente_11" style="border: 0.5px solid #999;" rowspan="2">
		                            	{{$vuelo['dtaTxtDCiudad']}}
		                            </td>
	                            @endif

	                            <td class="fuente_11" style="border: 0.5px solid #999;">Fecha:</td>
	                            <td class="fuente_11" style="border: 0.5px solid #999;">
	                            	{{$vuelo['dtaIntFechaVuelo']}}
	                            </td>
	                            <td class="fuente_11" style="border: 0.5px solid #999;">Hotel:</td>
	                            <td class="fuente_11" style="border: 0.5px solid #999;">
	                            	{{$vuelo['dtaTxtHotel']}}
	                            </td>
	                        </tr>
	                        <tr>
	                            <td class="fuente_11" style="border: 0.5px solid #999;">Hora Salida:</td>
	                            <td class="fuente_11" style="border: 0.5px solid #999;">
	                            	{{$vuelo['dtaIntHoravuelo']}}
	                            </td>
	                            <td class="fuente_11" style="border: 0.5px solid #999;">Dias</td>

	                            @if($vuelo['dtaTxtHotel'] == 'S')
	                            	<td class="fuente_11" style="border: 0.5px solid #999;">
	                            		{{$vuelo['dthIntDias']}}
	                            	</td>
	                            @else
	                            	<td class="fuente_11" style="border: 0.5px solid #999;">0</td>
	                            @endif
	                        </tr>
	                        <tr style="border: 0px;">
	                            <td height="2" colspan="7" style="border: 0.2px;"></td>
	                        </tr>
                    	@endforeach
                    </table>
                </td>
            </tr>
        </table>

        @if($solicitudImprimir['solTxtMotivotarde'] != '')
        	<table width="100%">
	            <tr>
	                <td class="fuente_11" align="center" style="background: #CCCCCC; border: 0px">
	                	<strong>Observaciones</strong>
	                </td>
	            </tr>
	            <tr>
	                <td class="fuente_11" style="border: 0.5px solid #999; text-align:justify;">
	                	{{$solicitudImprimir['solTxtMotivotarde']}}
	                </td>
	            </tr>
	        </table>
        @endif
	</body>
</html>