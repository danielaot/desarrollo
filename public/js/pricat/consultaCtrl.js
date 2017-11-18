app.controller('consultaCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "consultainfo";
  $scope.url = "consulta";

  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.proyectos = angular.copy(info.proyectos);
      $scope.procesos = angular.copy(info.procesos);
      angular.element('.close').trigger('click');
      $scope.progress = false;
    });
  }


  $scope.getInfo();

}]);
