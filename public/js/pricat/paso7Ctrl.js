app.controller('paso7Ctrl', ['$scope', '$http', '$mdDialog', function($scope, $http, $mdDialog){
  $scope.getUrl = 'paso7info';
  $scope.url = 'paso7';

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.tempaque = angular.copy(info.tempaque);
    $scope.tembalaje = angular.copy(info.tembalaje);
    $scope.cmanipulacion = angular.copy(info.cmanipulacion);
  });

  $scope.producto = {};

}]);
