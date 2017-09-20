app.controller('paso8Ctrl', ['$scope', '$http', '$filter', '$window', function($scope, $http, $filter, $window){
  $scope.url = 'paso8';

  $scope.saveProducto = function(){
    $scope.progress = true;

    $http.put($scope.url+'/'+$scope.producto.item.id, $scope.producto).then(function(response){
      $scope.progress = false;
      console.log(response.data.url);
      if(response.data.errores == undefined)
        $window.location = response.data.url;
      else
        console.log(response.data.errores);
    }, function(){});
  }
}]);
