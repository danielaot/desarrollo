app.controller('proyectosCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "proyectosinfo";
  $scope.url = "proyectos";

  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.proyectos = angular.copy(info.proyectos);
      $scope.proyectosterm = angular.copy(info.proyectosterm);
      $scope.proyectosproc = angular.copy(info.proyectosproc);
      $scope.proyectosxcert = angular.copy(info.proyectosxcert);
      $scope.proyectospau = angular.copy(info.proyectospau);
      $scope.proyectoscan = angular.copy(info.proyectoscan);
      $scope.procesos = angular.copy(info.procesos);
      angular.element('.close').trigger('click');
      $scope.progress = false;
    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(2).notSortable()
  ];

  $scope.getInfo();

  $scope.setProyecto = function(){
    $scope.proyecto = {};
    $scope.proyectoForm.$setPristine();
  }

  $scope.saveProyecto = function(){
    $scope.progress = true;
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

  $scope.editProyecto = function(proyecto){
    $scope.proyecto = angular.copy(proyecto);
    $scope.proyecto.proy_proc_id = $scope.proyecto.procesos;
    $scope.proyectoForm.$setPristine();
  }

  $scope.pausarProyecto = function(idproyecto){
    console.log(idproyecto);
    var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea pausar el proyecto?')
          .ariaLabel('proyecto')
          .ok('Pausar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.put($scope.url+'/pausar/'+idproyecto.id).then(function(response){
        console.log(response);
        $scope.getInfo();
      }, function(){});
    },function(){});
  }

  $scope.cancelarProyecto = function(idproyecto){
    console.log(idproyecto);
    var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea cancelar el proyecto?')
          .ariaLabel('proyecto')
          .ok('Cancelar')
          .cancel('Cerrar');

    $mdDialog.show(confirm).then(function(){
      $http.put($scope.url+'/cancelar/'+idproyecto.id).then(function(response){
        $scope.getInfo();
      }, function(){});
    },function(){});
  }

  $scope.activarProyecto = function(idproyecto){
    var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea activar el proyecto?')
          .ariaLabel('proyecto')
          .ok('Activar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.put($scope.url+'/activar/'+idproyecto.id).then(function(response){
        $scope.getInfo();
      }, function(){});
    },function(){});
  }

}]);
