app.controller('bandejaAprobacionCtrl', ['$scope', '$filter', '$http', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.url = 'bandejaaprobacion';
  $scope.urlInfo = 'bandejaaprobacioninfo';
  $scope.progress = true;

  $scope.getInfo = function(){
      $http.get($scope.urlInfo).then(function(response){
        var info = response.data;
        $scope.solipernivel =  angular.copy(info.solicitud);
        $scope.estados = angular.copy(info.estadosAprobacion);
        $scope.progress = false;
         console.log($scope.estados);
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

  $scope.saveAprobSolicitud = function(){
    $http.post($scope.url, $scope.aprobacionSolicitud).then(function(response){
      console.log($scope.aprobacionSolicitud);
    //  $scope.progress = false;
    });

  }

}]);
