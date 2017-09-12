app.controller('paso2Ctrl', ['$scope', '$window', '$http', '$mdDialog', function($scope, $window, $http, $mdDialog){
  $scope.url = 'paso2';
  $scope.progress = false;

  $scope.saveProducto = function(){
    $scope.progress = true;

    $http.put($scope.url+'/'+$scope.producto.item, $scope.producto).then(function(response){
      $scope.progress = false;
      if(response.data.errores == undefined)
        $window.location = response.data;
      else{
        $scope.errores = angular.copy(response.data.errores);
        if($scope.errores[0] == 'referencia'){
          $mdDialog.show(
            $mdDialog.alert()
              .parent(angular.element(document.querySelector('body')))
              .clickOutsideToClose(true)
              .title('')
              .textContent('Verifique que el item este creado en el UnoE para poder continuar')
              .ariaLabel('Referencia')
              .ok('Aceptar')
              .targetEvent()
          );
        }
        else{
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
