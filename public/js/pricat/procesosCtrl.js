app.controller('procesosCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "procesosinfo";
  $scope.url = "procesos";
  $scope.urlActividades = "actividades";
  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.procesos = angular.copy(info.procesos);
      $scope.usuarios = angular.copy(info.usuarios);
      $scope.areas = angular.copy(info.areas);
      $scope.actividades = angular.copy(info.actividades);
      angular.element('.close').trigger('click');
      $scope.progress = false;
    });
  }

  $scope.getInfo();

  $scope.set = function(){
    $scope.proceso = {};
    $scope.procesoForm.$setPristine();
  }

  $scope.saveProceso = function(){
    $scope.progress = true;
    if($scope.proceso.id != undefined){
      $http.put($scope.url+'/'+$scope.proceso.id, $scope.proceso).then(function(response){
        $scope.getInfo();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
    }
    else{
      $http.post($scope.url, $scope.proceso).then(function(response){
        $scope.getInfo();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
    }
  }

  $scope.setProceso = function(idproceso){
    $scope.actividad = {};
    $scope.actividadForm.$setPristine();
    $scope.actividad.act_proc_id = idproceso;
  }

  $scope.editProceso = function(idproceso){
    $scope.proceso = angular.copy($filter('filter')($scope.procesos, {id : idproceso})[0]);
  }

  $scope.deleteProceso = function(ev, idproceso){
    var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea eliminar el proceso?')
          .ariaLabel('proceso')
          .targetEvent(ev)
          .ok('Eliminar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.delete($scope.url+'/'+idproceso).then(function(response){
        $scope.getInfo();
      }, function(){});
    },function(){});
  }

  $scope.saveActividad = function(){
    $scope.progress = true;
    $scope.actividad.act_ar_id = $scope.actividad.act_ar_id.id;
    $scope.actividad.pre_act_pre_id = $scope.actividad.pre_act_pre_id != undefined ? $scope.actividad.pre_act_pre_id.id : '';
    console.log($scope.actividad);
    if($scope.actividad.id != undefined){
      $http.put($scope.urlActividades+'/'+$scope.actividad.id, $scope.actividad).then(function(response){
        $scope.getInfo();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
    }
    else{
      $http.post($scope.urlActividades, $scope.actividad).then(function(response){
        $scope.getInfo();
        $scope.actividad = {};
        $scope.actividadForm.$setPristine();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
    }
  }

  $scope.editActividad = function(idactividad){
    $scope.actividad = angular.copy($filter('filter')($scope.actividades, {id : idactividad})[0]);
    $scope.actividad.act_ar_id = angular.copy($filter('filter')($scope.areas, {id : $scope.actividad.act_ar_id})[0]);
    if($scope.actividad.predecesoras.length > 0){
      var act_pre_id = $scope.actividad.predecesoras[0].pre_act_pre_id;
      $scope.actividad.pre_act_pre_id = angular.copy($filter('filter')($scope.actividades, {id : act_pre_id})[0]);
    }
  }

  $scope.deleteActividad = function(ev, idactividad){
    var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea eliminar la actividad para este proceso?')
          .ariaLabel('actividad')
          .targetEvent(ev)
          .ok('Eliminar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.delete($scope.urlActividades+'/'+idactividad).then(function(response){
        $scope.getInfo();
      }, function(){});
    },function(){});
  }
}]);
