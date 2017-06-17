app.controller('paso6Ctrl', ['$scope', '$http', '$mdDialog', function($scope, $http, $mdDialog){
  $scope.getUrl = 'paso6info';
  $scope.url = 'paso6';

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.tempaque = angular.copy(info.tempaque);
    $scope.tembalaje = angular.copy(info.tembalaje);
    $scope.cmanipulacion = angular.copy(info.cmanipulacion);
    console.log($scope.tembalaje);
  });

  $scope.producto = {};

}]);
