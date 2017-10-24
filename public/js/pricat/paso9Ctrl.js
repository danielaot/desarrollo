app.controller('paso9Ctrl', ['$scope', '$window', '$http', '$mdDialog', function($scope, $window, $http, $mdDialog){
  $scope.url = 'paso9';

  $scope.saveProducto = function(){
    $scope.progress = true;

    $http.put($scope.url+'/'+$scope.producto.item, $scope.producto).then(function(response){
      $scope.progress = false;
      if(response.data.errores == undefined)
        $window.location = response.data;
      else{
        $scope.errores = angular.copy(response.data.errores);
        if($scope.errores.length > 0){
          $mdDialog.show(
            $mdDialog.alert()
            .parent(angular.element(document.querySelector('body')))
            .clickOutsideToClose(true)
            .title('')
            .textContent('El item presenta inconsistencias en el UnoE')
            .ariaLabel('Errores')
            .ok('Aceptar')
            .targetEvent()
          );
        }
      }
    }, function(){});
  }
}]);
