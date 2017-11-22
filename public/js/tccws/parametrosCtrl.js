app.controller('parametrosCtrl', ['$scope', '$http', '$filter', '$element', function ($scope, $http, $filter, $element) {
	$scope.urlGetInfo = "parametrostccGetInfo";
	$scope.urlResource = "parametrostcc";
	$scope.progress = true;


	$scope.getInfo = function(){
		$http.get($scope.urlGetInfo).then(function(response){
    		var data = response.data;
    		console.log(data);
        	//$scope.parametros = angular.copy(data.parametros);
        	//$scope.progress = false;
    	});
	}
    $scope.getInfo();

}]);