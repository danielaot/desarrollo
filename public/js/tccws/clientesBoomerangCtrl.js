app.controller('clientesBoomerangCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "clientesinfo";
	$scope.url = "clientes";

  $scope.progress = true;

  $scope.clientesSelected = [];
  $scope.isDelete = true;

  $scope.getInfo = function(){

    $scope.clientes = [];

    $http.get($scope.getUrl).then(function(response){
      var data = response.data;
      $scope.clientes = angular.copy(data.clientes);
      $scope.clientesAgregados = angular.copy(data.clientesAgregados);
      console.log($scope.clientes);
      console.log($scope.clientesAgregados);
      $scope.progress = false;
      });
  } 
  $scope.getInfo();

  function transformChip(chip) {

    if (angular.isObject(chip)) {
      return chip;
    }
    return { name: chip, type: 'new' }
  }

  $scope.buscarTercero = function(searchText){
    var filterClientes = $filter('filter')($scope.clientes, {suc_txt_nombre: searchText});
    if (filterClientes.length == 0) {
      filterClientes = $filter('filter')($scope.clientes, {suc_num_codigo: searchText});
    }
    return filterClientes;
    $scope.getInfo();
  }

  $scope.agregarCliente = function(){
    $scope.progress = true;
    console.log($scope.clientesSelected);
    $http.post($scope.url, $scope.clientesSelected).then(function(response){
      $scope.getInfo();
      console.log(response.data);
    }, function(error){
      console.log(error);
      $scope.getInfo();
    });
    $scope.clientesSelected = [];
  }

  $scope.eliminar = function(clientea){
    var confirm = $mdDialog.confirm()
    .title('¡ALERTA!')
    .textContent('¿Realmente desea eliminar el registro?')
    .ariaLabel('Lucky day')
    .targetEvent()
    .ok('Si')
    .cancel('No, gracias');
    $mdDialog.show(confirm).then(function() {
      $http.delete($scope.url + '/' + clientea.id).then(function(response){
        $scope.getInfo();
        $scope.progress = true;
      });
    });
  }

}]);