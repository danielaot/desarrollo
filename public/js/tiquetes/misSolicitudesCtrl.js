app.controller('misSolicitudesCtrl', ['$scope', '$filter', '$http', '$window', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $window, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.getUrl = 'missolicitudesinfo';
  $scope.progress = true;
  $scope.urlEnviar = 'enviarSol';
  $scope.urlAnular = 'anularSol';

  $scope.getInfo = function(){
    $scope.todas = [];
    $http.get($scope.getUrl).then(function(response){
      console.log(response);
      var info = response.data;
      $scope.todas = angular.copy(info.solicitudes);
      $scope.elaboracion =  $filter('filter')($scope.todas, {solIntEstado : 1}, true);
      $scope.correcciones = $filter('filter')($scope.todas, {solIntEstado : 2}, true);
      $scope.anuladas = $filter('filter')($scope.todas, {solIntEstado : 3}, true);
      $scope.paprobacion = $filter('filter')($scope.todas, {solIntEstado : 4}, true);
      $scope.cerradas = $filter('filter')($scope.todas, {solIntEstado : 9}, true);

      $scope.filtrosAprobacion = [7, 12];
      $scope.aprobadas = [];
      $scope.filtrosAprobacion.forEach(function(element){
        var arregloAprobacion = $filter('filter')($scope.todas, {solIntEstado : element}, true);
        arregloAprobacion.forEach(function(obj){
          $scope.aprobadas.push(obj);
        });
      });
      
      $scope.rutaPdf = angular.copy(info.rutaPdf);
      $scope.progress = false;
    });
  }
  $scope.getInfo();

  $scope.solicitud = function(toda){
    $scope.infoCompleta = toda;
    $scope.reset = true;
    console.log($scope.infoCompleta);
  }

  $scope.editSolicitud = function(solicitud){

    $window.location = solicitud.urlEdit;

  }

  $scope.enviarSolicitud = function(info){
    $scope.infoEnviar = info;

    var confirm = $mdDialog.confirm()
    .title('Enviar Solicitud')
    .textContent('Realmente desea enviar la Solicitud Nro. '+$scope.infoEnviar.solIntSolId+'?')
    .ariaLabel('info')
    .ok('Enviar')
    .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.post($scope.urlEnviar, $scope.infoEnviar).then(function(response){
      });
    });
  }

  $scope.anularSolicitud = function(info){
    $scope.infoEnviar = info;

    var confirm = $mdDialog.confirm()
    .title('¡ALERTA!')
    .textContent('Realmente desea Anular la Solicitud Nro '+$scope.infoEnviar.solIntSolId+'?')
    .ariaLabel('info')
    .ok('Anular')
    .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.post($scope.urlAnular, $scope.infoEnviar).then(function(response){
        console.log("exitoso");
      });
    });
  }

  $scope.saberSiEsParClass = function(numero){
    var modulo = numero % 2;
    if (modulo == 0) {
      return 'timeline';
    }else{
      return 'timeline-inverted';
    }
   }

  $scope.generarPdf = function(objSolicitud){
    $window.location = $scope.rutaPdf + '?objSolicitud=' + objSolicitud;
  }

  $scope.resetTab = function(){
    $scope.reset = false;
  }

}]);
