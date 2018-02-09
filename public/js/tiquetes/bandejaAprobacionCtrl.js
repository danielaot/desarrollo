app.controller('bandejaAprobacionCtrl', ['$scope', '$filter', '$http', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.url = 'bandejaaprobacion';
  $scope.urlInfo = 'bandejaaprobacioninfo';
  $scope.progress = true;
  console.log($scope.getInfo);

  $scope.getInfo = function(){
      $http.get($scope.urlInfo).then(function(response){
        var info = response.data;
        $scope.solipernivel =  angular.copy(info.solicitud);
        $scope.progress = false;
         console.log($scope.solipernivel);
      });
  }

  $scope.getInfo();


  $scope.infosolicitud = function(sol){
    console.log(sol);
    $scope.infoCompleta = sol;
  }

  $scope.aprosolicitud = function(sol){
    console.log(sol);
    $scope.aprobacionSolicitud = sol;
  }

}]);
