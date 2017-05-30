app.controller('paso2Ctrl', ['$scope', '$window', '$http', function($scope, $window, $http){
  $scope.url = 'paso2';
  $scope.progress = false;

  $scope.saveProducto = function(){
    $scope.progress = true;
    console.log($scope.producto);
    /*$http.post($scope.url, $scope.producto).then(function(response){
      $scope.progress = false;
      $window.parent.location = response.data;
    }, function(){});*/
  }
}]);
