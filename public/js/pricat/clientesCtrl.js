app.controller('clientesCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "clientesinfo";
  $scope.url = "clientes";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.terceros = angular.copy(info.terceros);
      $scope.clientes = angular.copy(info.clientes);
      angular.element('.close').trigger('click');
    });
  }

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

  $scope.saveCliente = function(){
    if($scope.cliente.id != undefined){
      $http.put($scope.url+'/'+$scope.cliente.id, $scope.cliente).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
    else{
      $http.post($scope.url, $scope.cliente).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
  }
}]);
