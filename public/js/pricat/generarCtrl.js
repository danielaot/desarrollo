app.controller('generarCtrl', ['$scope', '$filter', '$http', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$window', function($scope, $filter, $http, DTOptionsBuilder, DTColumnDefBuilder, $window){
  $scope.getUrl = "generarinfo";
  $scope.solicitudd = {};
  $scope.urlPricat = "generarpricat";

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

  $scope.solicitar = function(idsolicitud){
    console.log($scope.solicitudd);
    $http.post($scope.urlPricat, $scope.solicitudd).then(function(response){
      $scope.progress = false;

    });
  }


}]);
