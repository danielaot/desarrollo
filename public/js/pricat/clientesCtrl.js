app.controller('clientesCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "clientesinfo";
  $scope.url = "clientes";

  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.terceros = angular.copy(info.terceros);
      $scope.clientes = angular.copy(info.clientes);
      $scope.listaprecio = angular.copy(info.listaprecio);
      console.log($scope.listaprecio);
      angular.element('.close').trigger('click');
      $scope.progress = false;
    }, function(error){
      console.log(error);
      $scope.getInfo();
    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(6).notSortable()
  ];

  $scope.getInfo();

  $scope.setCliente = function(){
    $scope.cliente = {};
    $scope.clienteForm.$setPristine();
  }

  $scope.clientesSearch = function(query){
    if(query){
      var filtrado = $filter('filter')($scope.terceros, {idTercero : query});
      if(filtrado.length == 0){
        filtrado = $filter('filter')($scope.terceros, {razonSocialTercero : query});
      }
      return filtrado;
    }
    else{
      return $scope.terceros;
    }
  }

  $scope.listaSearch = function(query){
    if(query){
      var filtrado = $filter('filter')($scope.listaprecio, {f112_id : query});
      return filtrado;
    }
    else{
      return $scope.listaprecio;
    }
  }

  $scope.saveCliente = function(){
    $scope.progress = true;
    if($scope.cliente.id != undefined){
      console.log($scope.cliente);
      $http.put($scope.url+'/'+$scope.cliente.id, $scope.cliente).then(function(response){
        data = response.data;
        console.log(data);
        $scope.getInfo();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
    }
    else{
      $http.post($scope.url, $scope.cliente).then(function(response){
        $scope.getInfo();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
    }
  }

  $scope.editCliente = function(cliente){
    $scope.cliente = angular.copy(cliente);
    if ($scope.cliente.cli_codificacion == 1) {
      $scope.cliente.codificacion = true;
    }
    if ($scope.cliente.cli_eliminacion == 1) {
      $scope.cliente.eliminacion = true;
    }
    if ($scope.cliente.cli_modificacion == 1) {
      $scope.cliente.modificacion = true;
    }
    $scope.cliente.gln = parseInt($scope.cliente.cli_gln);
  }

  $scope.inactivarCliente = function(cliente){
    $scope.progress = true;
     $http.delete($scope.url+'/'+cliente.id, cliente).then(function(response){
        data = response.data;
        console.log(data);
        $scope.getInfo();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
  }

}]);
