app.controller('nivelesAutorizacionCtrl', ['$scope', '$filter', '$http', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.get = 'nivelesautorizacion';
  $scope.getUrl = 'nivelesautorizacioninfo';

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.tpersona = angular.copy(info.tpersona);
      $scope.canal = angular.copy(info.canal);
      $scope.zona = angular.copy(info.zona);
      console.log($scope.tpersona);
    });
  }

  $scope.getInfo();
}]);
