app.controller('generarCtrl', ['$scope', '$filter', '$http', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $filter, $http, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "generarinfo";

  $scope.progress = true;

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.solicitadas = angular.copy(info.solicitadas);
    $scope.generadas = angular.copy(info.generadas);
    $scope.items = angular.copy(info.items);
    $scope.progress = false;
  });

  $scope.dtOptions1 = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs1 = [
    DTColumnDefBuilder.newColumnDef(4).notSortable()
  ];

  $scope.dtOptions2 = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs2 = [
    DTColumnDefBuilder.newColumnDef(4).notSortable()
  ];

  $scope.solicitud = {};

  $scope.show = function(idsolicitud){
    $scope.solicitud = angular.copy($filter('filter')($scope.solicitudes, {id : idsolicitud})[0]);
  }
}]);
