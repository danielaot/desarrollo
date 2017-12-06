app.controller('consultaRemesasCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  	$scope.getUrl = "consultasinfo";
    $scope.progress = true;

  $scope.getConsultaRemesas = function(){
  	$http.get($scope.getUrl).then(function(response){
    	var data = response.data;
     	$scope.consultas = angular.copy(data.consultafacturas);
      $scope.consultas.map(function(consulta){
        var fecha_ini = new Date(consulta.consulta.created_at);
        fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
        consulta.consulta.created_at = new Date(fecha_ini);
        return consulta;
      });
    	console.log($scope.consultas);
      $scope.progress = false;
    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(2).notSortable()
  ];

  $scope.getConsultaRemesas();

  $scope.setFactura = function(objeto){
  	console.log(objeto);
  	$scope.consulta = objeto;
  }

}]);