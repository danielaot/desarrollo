app.controller('pedidosAgrupaCtrl', ['$scope', '$http', '$filter', '$element', function ($scope, $http, $filter, $element) {
	$scope.urlGetInfo = "agrupaPedidosGetInfo";
	$scope.progress = true;
	$scope.sucursal = {};

	$scope.getInfo = function(){
		$http.get($scope.urlGetInfo).then(function(response){
			data = response.data;		
			$scope.agrupoCliente = angular.copy(data.agrupoCliente);	
			$scope.terceros = angular.copy(data.terceros);
			$scope.sucursales = angular.copy(data.sucursales);
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

	$scope.retornaListaFiltrada = function(){
		// var lista = $scope.agrupoCliente[$scope.cliente.idTercero];
	}

	$scope.clearSearchTerm = function() {
       $scope.searchTerm = '';
    };

}]);