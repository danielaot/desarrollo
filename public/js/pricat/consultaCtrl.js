app.controller('consultaCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "consultainfo";
  $scope.url = "consulta";

  $scope.progress = true;
  $scope.autocompleteDemoRequireMatch = true;
  $scope.consultaref = [];

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.proyectos = angular.copy(info.proyectos);
      $scope.referencias = angular.copy(info.referencias);
      angular.element('.close').trigger('click');
      $scope.progress = false;
    });
  }

  $scope.getInfo();

  $scope.referenciasSearch = function(query){
    if(query){
      return $filter('filter')($scope.referencias, {ite_referencia : query});
    }
    else{
      return $scope.referencias;
    }
  }

   function transformChip(chip) {
    if (angular.isObject(chip)) {
      return chip;
    }
    return { name: chip, type: 'new' }
  }

  $scope.onAddReferencia = function(){

  }

  $scope.onRemoveReferencia = function(){

  }

  $scope.consultaReferencia = function(){
    console.log($scope.consultaref);
    $http.post($scope.url, $scope.consultaref).then(function(response){
      $scope.ref = $scope.consultaref;
    }, function(){});
  }

  $scope.detalleRef = function(){

  }



}]);
