app.controller('misSolicitudesCtrl', ['$scope', '$filter', '$http', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.getUrl = 'missolicitudesinfo';
  $scope.progress = true;
  $scope.urlEnviar = 'enviarSol';
  $scope.urlAnular = 'anularSol';

  $scope.getInfo = function(){
     $scope.todas = [];
     $http.get($scope.getUrl).then(function(response){
       var info = response.data;
       $scope.todas = angular.copy(info.solicitudes);
       $scope.elaboracion =  $filter('filter')($scope.todas, {solIntEstado : 1});
       $scope.correcciones = $filter('filter')($scope.todas, {solIntEstado : 2});
       $scope.anuladas = $filter('filter')($scope.todas, {solIntEstado : 3});
       $scope.paprobacion = $filter('filter')($scope.todas, {solIntEstado : 4});
       $scope.cerradas = $filter('filter')($scope.todas, {solIntEstado : 9});
       $scope.rutaPdf = info.rutaPdf;

       $scope.filtrosAprobacion = [7, 12, 14];
       $scope.aprobadas = [];
       $scope.filtrosAprobacion.forEach(function(element){
         var arregloAprobacion = $filter('filter')($scope.todas, {solIntEstado : element});
         arregloAprobacion.forEach(function(obj){
           $scope.aprobadas.push(obj);
         });
       });
     });
    $scope.progress = false;
   }

   $scope.getInfo();

   $scope.solicitud = function(toda){
     $scope.infoCompleta = toda;
     console.log($scope.infoCompleta);
   }

   $scope.enviarSolicitud = function(info){
     $scope.infoEnviar = info;

     var confirm = $mdDialog.confirm()
       .title('')
       .textContent('Desea enviar la Solicitud?')
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
        .title('')
        .textContent('Desea Anular la Solicitud?')
        .ariaLabel('info')
        .ok('Anular')
        .cancel('Cancelar');

       $mdDialog.show(confirm).then(function(){
         $http.post($scope.urlAnular, $scope.infoEnviar).then(function(response){
           console.log("exitoso");
         });
       });
     }
}]);
