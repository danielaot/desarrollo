app.controller('pruebaCarteraCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "carterainfo";
	$scope.url = "cartera";

  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
        var data = response.data;
        $scope.pruebas = angular.copy(data.pruebas);
        console.log($scope.pruebas);
      $scope.progress = false;
      });
  }

  $scope.getInfo();

  $scope.savePrueba = function(){
    $http.post($scope.url, $scope.prueba).then(function(response){
      $scope.getInfo();
    }, function(error){
      console.log(error);
      $scope.getInfo();
    });
    angular.element('.close').trigger('click');
  }

  $scope.eliminarPrueba = function(prueba){

    var confirm = $mdDialog.confirm()
    .title('¡ALERTA!')
    .textContent('¿Realmente desea eliminar el registro?')
    .ariaLabel('Lucky day')
    .targetEvent()
    .ok('Si')
    .cancel('No, gracias');
    $mdDialog.show(confirm).then(function() {
      $http.delete($scope.url + '/' + prueba.id).then(function(response){
        $scope.getInfo();
      });
    });
    $scope.progress = true;
  }

}]);