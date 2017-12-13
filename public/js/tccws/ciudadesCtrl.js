app.controller('ciudadesCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "ciudadesinfo";
	$scope.url = "ciudades";

  $scope.progress = true;
  $scope.isEdit == false;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var data = response.data;
      $scope.ciudades = angular.copy(data.ciu);
      $scope.ciuErp = angular.copy(data.ciuErp);
      $scope.deptoErp = angular.copy(data.deptoErp);
      $scope.infoDane = angular.copy(data.infoDane);
      console.log($scope.ciudades);
      console.log($scope.ciuErp);
      console.log($scope.deptoErp);
      $scope.progress = false;
      });
  } 
  $scope.getInfo();
  
  $scope.saveCiudad = function(){
    $scope.progress = true;
    if ($scope.isEdit == false) {
      $scope.validarDane();
      if ($scope.validarCode == false){
        $scope
        $http.post($scope.url, $scope.ciudad).then(function(response){
        console.log(response);
        $scope.getInfo();
        }, function(error){
        console.log(error);
        $scope.getInfo();
        });
      }else{
        $mdDialog.show(
        $mdDialog.alert()
          .parent(angular.element(document.querySelector('#popupContainer')))
          .clickOutsideToClose(true)
          .title('Error')
          .textContent('El codigo Dane diligenciado en el formulario ya se encuentra registrado')
          .ariaLabel('Alert Dialog Demo')
          .ok('Entendido!')
          .targetEvent()
        );
        $scope.progress = false;
      }
    }else{
      $http.put($scope.url + '/' + $scope.ciudad.id, $scope.ciudad).then(function(response){        
        console.log(response);
        $scope.ciudad = {};
        $scope.getInfo();
      });
    }
    angular.element('.close').trigger('click');
  }

  $scope.resetForm = function(){
    $scope.ciudad = {};
    $scope.isEdit = false;
  }
  
  $scope.editarCiudad = function(ciudad){
    $scope.ciudad = angular.copy(ciudad);
    $scope.isEdit = true;
  }
  
  $scope.validarDane = function(){
    $scope.getInfo();
    for (var i = 0; i < $scope.infoDane.length; i++) {
      if ($scope.ciudad.ctc_cod_dane == $scope.infoDane[i]) {
        $scope.validarCode = true;
      }else{
        $scope.validarCode = false;
      }
    }
  }

}]);