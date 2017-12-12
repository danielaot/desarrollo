app.controller('consultaRemesasCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  	$scope.getUrl = "consultasinfo";
    $scope.getBusqueda = "consultasbusqueda";
    $scope.getFecha = "consultasfecha";
    $scope.progress = true;

  $scope.getConsultaRemesas = function(){
  	$http.get($scope.getUrl).then(function(response){
      console.log(response.data);
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

  $scope.getConsultaBusquedas = function(busqueda, radio){
    $scope.progress = true;
    $scope.busquedas = [];
    $scope.buscar = new Object();
    $scope.buscar.busqueda = busqueda;
    $scope.buscar.radio = radio;
    if (busqueda == undefined || radio == undefined) {
      $mdDialog.show(
      $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('Busqueda')
        .textContent('Favor diligenciar los campos de la búsqueda')
        .ariaLabel('Alert Dialog Demo')
        .ok('Entendido!')
        .targetEvent()
    );
    $scope.progress = false;    
    }else{
      $http.post($scope.getBusqueda, $scope.buscar).then(function(response){
        console.log(response.data);
        var data = response.data;
        $scope.consultas = angular.copy(data.consultaremesas);
        $scope.consultas.map(function(consulta){ 
          var fecha_ini = new Date(consulta.consulta.created_at);
          fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
          consulta.consulta.created_at = new Date(fecha_ini);

          return consulta;
        });
        console.log($scope.consultas);
        $scope.progress = false;
      });
      $scope.busquedas = []
    }
  }

  $scope.getConsultaFechas = function(inicial, final){
    $scope.progress = true;
    $scope.fechas = [];
    $scope.fech = new Object();
    $scope.fech.inicial = inicial;
    $scope.fech.final = final;

    if (inicial == undefined || final == undefined) {
      $mdDialog.show(
      $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('Busqueda')
        .textContent('Favor diligenciar los campos de la búsqueda')
        .ariaLabel('Alert Dialog Demo')
        .ok('Entendido!')
        .targetEvent()
        );
      $scope.progress = false;
    }else{
      if (inicial > final) {
        $mdDialog.show(
        $mdDialog.alert()
          .parent(angular.element(document.querySelector('#popupContainer')))
          .clickOutsideToClose(true)
          .title('Fecha incorrecta')
          .textContent('La fecha inicial no puede ser mayor a la fecha final')
          .ariaLabel('Alert Dialog Demo')
          .ok('Entendido!')
          .targetEvent()
          );
        $scope.progress = false;
      }else{
        $http.post($scope.getFecha, $scope.fech).then(function(response){
        console.log(response.data);
        var data = response.data;
        $scope.consultas = angular.copy(data.consultafechas);
        $scope.consultas.map(function(consulta){
          var fecha_ini = new Date(consulta.consulta.created_at);
          fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
          consulta.consulta.created_at = new Date(fecha_ini);

          return consulta;
        });
        console.log($scope.consultas);
        $scope.progress = false;
      });
      $scope.busquedas = []
      }
      
    }
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