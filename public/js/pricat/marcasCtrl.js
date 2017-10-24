app.controller('marcasCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "marcasinfo";
  $scope.url = "marcas";

  $scope.errorNombreExist = false;
  $scope.errorLineas = false;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.marcas = angular.copy(info.marcas);
      $scope.lineas = angular.copy(info.lineas);
      angular.element('.close').trigger('click');
    });
  }

  $scope.getInfo();

  $scope.setMarca = function(){
    $scope.marca = { 'lineas' : [], 'action' : 'new' };
    $scope.errorNombreExist = false;
    $scope.errorLineas = false;
    $scope.marcaForm.$setPristine();
  }

  $scope.editMarca = function(idmarca){
    $scope.marca = { 'mar_nombre' : idmarca, 'lineas' : angular.copy($scope.marcas[idmarca]), 'action' : 'edit' };
    $scope.mar_nombre_init = idmarca;
    $scope.errorNombreExist = false;
    $scope.errorLineas = false;
    $scope.marcaForm.$setPristine();
  }

  $scope.saveMarca = function(){
    if($scope.marca.action == 'edit'){
      var marca = $scope.mar_nombre_init == $scope.marca.mar_nombre ? {'lineas' : $scope.marca.lineas} : $scope.marca;
      $http.put($scope.url+'/'+$scope.mar_nombre_init, marca).then(function(response){
        if(!response.data.errors){
          $scope.getInfo();
        }
        else{
          $scope.errorNombreExist = response.data.errors.mar_nombre ? true : false;
          $scope.errorLineas = response.data.errors.lineas ? true : false;
        }
      }, function(){});
    }
    else{
      $http.post($scope.url, $scope.marca).then(function(response){
        if(!response.data.errors){
          $scope.getInfo();
        }
        else{
          $scope.errorNombreExist = response.data.errors.mar_nombre ? true : false;
          $scope.errorLineas = response.data.errors.lineas ? true : false;
        }
      }, function(){});
    }
  }

  $scope.deleteMarca = function(ev, idmarca){
    /*var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea eliminar el proyecto?')
          .ariaLabel('proyecto')
          .targetEvent(ev)
          .ok('Eliminar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.delete($scope.url+'/'+idproyecto).then(function(response){
        $scope.getInfo();
      }, function(){});
    },function(){});*/
  }

  $scope.deleteLinea = function(ev, idmarca){
    /*var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea eliminar el proyecto?')
          .ariaLabel('proyecto')
          .targetEvent(ev)
          .ok('Eliminar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.delete($scope.url+'/'+idproyecto).then(function(response){
        $scope.getInfo();
      }, function(){});
    },function(){});*/
  }

  $scope.lineaSearch = function(query){
    //$scope.errorLineas = false;
    if(query){
      return $filter('filter')($scope.lineas, {descripcionItemCriterioMayor : query});
    }
    else{
      return $scope.lineas;
    }
  }
}]);
