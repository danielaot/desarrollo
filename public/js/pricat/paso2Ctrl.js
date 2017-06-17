app.controller('paso2Ctrl', ['$scope', '$window', '$http', function($scope, $window, $http){
  $scope.url = 'paso2';
  $scope.progress = false;

  $scope.saveProducto = function(){
    $scope.progress = true;
    $http.put($scope.url+'/'+$scope.producto.item, $scope.producto).then(function(response){
      $scope.progress = false;
      if(response.data.errores == undefined)
        $window.location = response.data;
      else
        $scope.errores = angular.copy(response.data.errores);
    }, function(){});
  }
}]);
