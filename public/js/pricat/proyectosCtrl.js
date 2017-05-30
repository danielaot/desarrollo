app.controller('proyectosCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "proyectosinfo";
  $scope.url = "proyectos";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.proyectos = angular.copy(info.proyectos);
      $scope.procesos = angular.copy(info.procesos);
      angular.element('.close').trigger('click');
    });
  }

  $scope.getInfo();

  $scope.setProyecto = function(){
    $scope.proyecto = {};
    $scope.proyectoForm.$setPristine();
  }

  $scope.saveProyecto = function(){
    $scope.proyecto.proy_proc_id = $scope.proyecto.proy_proc_id.id;
    if($scope.proyecto.id != undefined){
      $http.put($scope.url+'/'+$scope.proyecto.id, $scope.proyecto).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
    else{
      $http.post($scope.url, $scope.proyecto).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
  }

  $scope.editProyecto = function(idproyecto){
    $scope.proyecto = $filter('filter')($scope.proyectos, {id : idproyecto})[0];
    $scope.proyecto.proy_proc_id = $scope.proyecto.procesos;
    $scope.proyectoForm.$setPristine();
  }

  $scope.deleteProyecto = function(ev, idproyecto){
    var confirm = $mdDialog.confirm()
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
    },function(){});
  }
}]);
