app.controller('pedidosAgrupaCtrl', ['$scope', '$http', '$filter', '$element', '$mdDialog', function ($scope, $http, $filter, $element, $mdDialog) {
	$scope.urlGetInfo = "agrupaPedidosGetInfo";
	$scope.urlResource = "tccws";
	$scope.urlPlano = "obtenerPlano";
	$scope.urlUnidades = "unidadesLogisticas";
	$scope.progress = true;
	$scope.sucursal = {};
	$scope.sucursalesArray = {};
	$scope.sucursalSelected = {};
	$scope.puedeEnviar = false;
	$scope.cantidadCajas = 0;
	$scope.cantidadLios = 0;
	$scope.cantidadPaletas = 0;
	$scope.kilosRealesLios = 0;
	$scope.kilosRealesEstibas = 0;
	$scope.kilosBaseLios = 30;
	$scope.sumaTotalKilos = 0;

	$scope.getInfo = function(){
		$http.get($scope.urlGetInfo).then(function(response){
			data = response.data;
			$scope.agrupoCliente = angular.copy(data.agrupoCliente);
			$scope.terceros = angular.copy(data.terceros);
			$scope.sucursales = angular.copy(data.sucursales);
			console.log($scope.agrupoCliente);
			console.log($scope.terceros);
			console.log($scope.sucursales);
			$scope.progress = false;
		}, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
	}

	$scope.traerElementos = function(){
		//aqui debo filtrar el arreglo que se pinta en la vista
		console.log();
	}

	$scope.getInfo();


	$scope.getSucursales = function(){
		if ($scope.cliente == undefined) {
			return [];
		}else{
			return $filter('filter')($scope.sucursales, {nit_tercero : $scope.cliente.idTercero});
		}
	}

	$scope.setSelectAllFacts = function(sucursal){
		$scope.sucursalSelected = sucursal;
		if(sucursal.facturas.length > 0){
			sucursal.facturas.map(function(factura){
				factura.isSelect = $scope.sucursalSelected.isSelectAll;
				return factura;
			})
			sucursal.hasOneOrMoreSelected = $scope.sucursalSelected.isSelectAll;
		}

		var filterSelected = $filter('filter')(sucursal.facturas, {isSelect : true});
		sucursal.cantSeleccionadas = filterSelected.length;

		var cantSeleccionadas = 0;

		$scope.cliente.sucursales.forEach(function(sucu){
			if(sucu.hasOneOrMoreSelected == true){
					cantSeleccionadas += 1;
			}
		});

		if(cantSeleccionadas > 0){
				$scope.puedeEnviar = true;
		}else{
				$scope.puedeEnviar = false;
		}

	}

	$scope.setSelectedFactura = function(factura,sucursal){


			var filterSelected = $filter('filter')(sucursal.facturas, {isSelect : true});

			if(filterSelected.length == sucursal.facturas.length){
				sucursal.isSelectAll = true;
				sucursal.hasOneOrMoreSelected = true;
				$scope.puedeEnviar = true;
			}else if((filterSelected.length > 0) && (filterSelected.length < sucursal.facturas.length)){
				sucursal.isSelectAll = false;
				sucursal.hasOneOrMoreSelected = true;
				$scope.puedeEnviar = true;
			}else if(filterSelected.length == 0){
				sucursal.hasOneOrMoreSelected = false;
				sucursal.isSelectAll = false;
				$scope.puedeEnviar = false;
			}

			sucursal.cantSeleccionadas = filterSelected.length;
			console.log(factura);

	}

	$scope.onChangeSucursales = function(){

		if($scope.cliente.sucursales != undefined){
			if($scope.cliente.sucursales.length > 0){

				var sucursal = $scope.cliente.sucursales[$scope.cliente.sucursales.length - 1];
				sucursal.isSelectAll = false;
				sucursal.hasOneOrMoreSelected = false;
				sucursal.cantSeleccionadas = 0;

				if($scope.agrupoCliente[$scope.cliente.idTercero].length > 0){
					var filterFacturas = $filter('filter')($scope.agrupoCliente[$scope.cliente.idTercero], {num_sucursal: sucursal.codigo});

					if(filterFacturas.length > 0){
						filterFacturas.map(function(factura){
							factura.isSelect = false;
							return factura;
						})
					}

					sucursal.facturas = filterFacturas;

				}

			}
		}

	}

	$scope.retornaListaFiltrada = function(){
		// var lista = $scope.agrupoCliente[$scope.cliente.idTercero];
	}

	$scope.clearSearchTerm = function() {
       $scope.searchTerm = '';
    };

		$scope.getUnidadesLogisticas = function(){

			$scope.cantidadCajas = 0;
			$scope.cantidadLios = 0;
			$scope.cantidadPaletas = 0;
			$scope.kilosRealesLios = 0;
			$scope.kilosRealesEstibas = 0;
			$scope.sumaTotalKilos = 0;

			if($scope.cliente.arregloFinal != undefined){
				$scope.cliente.arregloFinal = {};
			}

			$scope.cliente.sucursales.map(function(sucursal){
				if (sucursal.hasOneOrMoreSelected == true) {
					var filterSelectRemesas = $filter('filter')(sucursal.facturas, {isSelect : true});
					sucursal.facturasAEnviar = filterSelectRemesas;
				}else{
					sucursal.facturasAEnviar = [];
				}
				return sucursal;
			})

			console.log($scope.cliente);
			$scope.progress = true;

			$http.post($scope.urlUnidades, $scope.cliente).then(function(response){
				$scope.progress = false;
				$scope.cliente.arregloFinal = angular.copy(response.data);

				console.log($scope.cliente);

				$scope.cliente.arregloFinal.sucursalesFiltradas.forEach(function(sucursal){

					sucursal.kilosRealesEstibas = 0;
					sucursal.kilosRealesLios = 0;
					sucursal.sumaTotalKilos = 0;

					sucursal.objetoCajas = $filter('filter')(sucursal.unidades, {claseempaque: 'CLEM_CAJA'})[0];
					sucursal.objetoLios = $filter('filter')(sucursal.unidades, {claseempaque: 'CLEM_LIO'})[0];
					sucursal.objetoPaletas = $filter('filter')(sucursal.unidades, {claseempaque: 'CLEM_PALET'})[0];

					$scope.sumatoriaKilos(sucursal);
				})

			});

		}

		$scope.enviarRemesa = function(){
			$scope.progress = true;
			console.log( $scope.cliente);
			$http.post($scope.urlPlano, $scope.cliente.arregloFinal).then(function(response){
				console.log(response.data);
				$scope.progress = false;
				var encabezado = "";
				var filterSuccessTodas = $filter('filter')(response.data.message, {respuesta : "0"});
				var filterErrorLogin = $filter('filter')(response.data.message, {respuesta : "1"});
				var filterErrorTodas = $filter('filter')(response.data.message, {respuesta : "-1"});


				if(filterErrorLogin.length == 0){

					if(filterSuccessTodas.length > 0 && filterErrorTodas.length == 0){

						if(response.data.data.tieneBoomerang == true){

							encabezado = $scope.mensajeRemesaBoomerang(encabezado,filterSuccessTodas);

						}else{
							encabezado += "<br/><h5>Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5><br/>";
							filterSuccessTodas.forEach(function(respuestaTcc){
								encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
							})
						}

					}else if(filterSuccessTodas.length == 0 && filterErrorTodas.length > 0){

						encabezado += "<br/><h5><strong>Error:</strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
						filterErrorTodas.forEach(function(respuestaTcc){
							encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
						})

					}else if(filterSuccessTodas.length > 0 && filterErrorTodas.length > 0){

							if(response.data.data.tieneBoomerang == true){

								encabezado = $scope.mensajeRemesaBoomerang(encabezado,filterSuccessTodas);

							}else{
								encabezado += "<br/><h5>Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5><br/>";
								filterSuccessTodas.forEach(function(respuestaTcc){
									encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
								})
							}

							encabezado += "<br/><h5><strong>Error:</strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
							filterErrorTodas.forEach(function(respuestaTcc){
								encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
							})

					}

			}else{

				encabezado += "<br/><h5><strong>Error:</strong> El servicio de TCC ha respondido con error de acceso, por favor revise sus credenciales.</h5><br/>";
				filterErrorLogin.forEach(function(respuestaTcc){
					console.log(respuestaTcc);
					encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
				})

			}

				angular.element('.close').trigger('click');

				$mdDialog.show($mdDialog.alert({
					title: 'Información Despacho de Remesas',
					htmlContent: encabezado,
					ok: 'Cerrar'
				}));

				console.log(response.data);
			});
		}


		$scope.mensajeRemesaBoomerang = function(encabezado,filterSuccessTodas){

			encabezado += "<br/><h5>Las sucursales seleccionadas para estas remesas son de un cliente con Boomerang</h5>\n";

			var filterErrorBoogmerang = $filter('filter')(filterSuccessTodas, {boomerangResponse : {respuesta : "-1"}});

			if(filterErrorBoogmerang.length > 0){

				encabezado +="<h5><strong>Error:</strong> las siguientes sucursales han presentado errores en el envio de boogmeran para este despacho</h5><br/>";
				filterErrorBoogmerang.forEach(function(respuestaTcc){
					encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error de Boomerang:</strong> "+ respuestaTcc.boomerangResponse.mensaje +"</pre>";
				})

			}else{

				encabezado += "<h5>Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5><br/>";
				filterSuccessTodas.forEach(function(respuestaTcc){
					encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"<br/><strong>Remesa Boomerang:</strong> "+respuestaTcc.boomerangResponse.remesa+"<br/><strong>Mensaje Boomerang:</strong> "+ respuestaTcc.boomerangResponse.mensaje +"</pre>";
				})

			}

			return encabezado;
		}

		$scope.sumatoriaKilos = function(sucursal){

			sucursal.kilosRealesLios = sucursal.objetoLios.cantidadunidades * $scope.kilosBaseLios;
			sucursal.sumaTotalKilos = sucursal.kilosRealesLios + sucursal.kilosRealesEstibas;

			sucursal.objetoLios.kilosreales = sucursal.kilosRealesLios;
			sucursal.objetoCajas.kilosreales = 0;
			sucursal.objetoPaletas.kilosreales = sucursal.kilosRealesEstibas;

		}

}]);
