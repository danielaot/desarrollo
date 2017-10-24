app.controller('missolicitudesCtrl', ['$scope', '$filter', '$http', function($scope, $filter, $http){
  $scope.getUrl = "solicitudinfo";

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.solicitudes = angular.copy(info.solicitudes);
  });

  $scope.solicitud = {};

  $scope.show = function(idsolicitud){
    $scope.solicitud = angular.copy($filter('filter')($scope.solicitudes, {id : idsolicitud})[0]);
  }
}]);
