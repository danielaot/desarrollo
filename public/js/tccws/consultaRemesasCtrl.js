app.controller('consultaRemesasCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  	$scope.getUrl = "consultasinfo";

  $scope.getConsultaRemesas = function(){
  	$http.get($scope.getUrl).then(function(response){
    	var data = response.data;
     	$scope.consultas = angular.copy(data.consultafacturas);
    	console.log($scope.consultas);
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

  $scope.cambiaFecha = function(fecha){
  	var date = new Date(fecha);
  	return $filter('date')(date, 'shortDate');
  }
}]);