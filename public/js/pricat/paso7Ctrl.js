app.controller('paso7Ctrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = '../pricat/paso7info';
  $scope.url = '../pricat/paso7';

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.tempaque = angular.copy(info.tempaque);
    $scope.tembalaje = angular.copy(info.tembalaje);
    $scope.cmanipulacion = angular.copy(info.cmanipulacion);
  });

  $scope.producto = {};

}]);
