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

        // $scope.consultas.forEach(function(consulta, key){
        //   var fecha_inifac = new Date(consulta.consulta.facturas.created_at);
        //   fecha_inifac = fecha_inifac.getTime() + fecha_inifac.getTimezoneOffset()*60*1000;
        //   consulta.consulta.facturas.created_at = new Date(fecha_inifac);
        // });

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
  	$scope.consulta = objeto;
  }

  $scope.cambiarFecha = function(fecha){
    fecha = new Date(fecha);
    return $filter('date')(fecha, 'shortDate');
  }

  $scope.retornarCadena = function(arregloDeObjetos){
    var arreglo = arregloDeObjetos.map(function(objeto){
      return objeto.fxr_tipodocto + '-' + objeto.fxr_numerodocto;
    });
    return arreglo.join(', ');
  }

}]);