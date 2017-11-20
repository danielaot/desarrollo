app.controller('consultaCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "consultainfo";
  $scope.url = "consulta";

  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.proyectos = angular.copy(info.proyectos);
      $scope.referencias = angular.copy(info.referencias);
      console.log($scope.referencias);
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

  $scope.onAddReferencia = function(){

  }

  $scope.onRemoveReferencia = function(){

  }

}]);
