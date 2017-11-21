app.controller('pedidosAgrupaCtrl', ['$scope', '$http', '$filter', '$element', function ($scope, $http, $filter, $element) {
	$scope.urlGetInfo = "agrupaPedidosGetInfo";
	$scope.urlResource = "tccws";
	$scope.progress = true;
	$scope.sucursal = {};
	$scope.sucursalesArray = {};
	$scope.sucursalSelected = {};
	$scope.puedeEnviar = false;

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
			console.log(sucursal.facturas);

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

		$scope.enviarRemesa = function(){

					$scope.cliente.sucursales.map(function(sucursal){
						if (sucursal.hasOneOrMoreSelected == true) {
							var filterSelectRemesas = $filter('filter')(sucursal.facturas, {isSelect : true});
							sucursal.facturasAEnviar = filterSelectRemesas;
						}else{
							sucursal.facturasAEnviar = [];
						}
						return sucursal;
					})

					$http.post($scope.urlResource, $scope.cliente).then(function(response){
						console.log(response.data);
					});

		}

}]);
