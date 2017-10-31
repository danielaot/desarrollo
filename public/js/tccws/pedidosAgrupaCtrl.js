app.controller('pedidosAgrupaCtrl', ['$scope', '$http', function ($scope, $http) {
	$scope.urlGetInfo = "agrupaPedidosGetInfo";
	$scope.progress = true;

	$scope.getInfo = function(){
		$http.get($scope.urlGetInfo).then(function(response){
			data = response.data;			
			console.log(data);
		}, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
	}

	$scope.getInfo();

}]);