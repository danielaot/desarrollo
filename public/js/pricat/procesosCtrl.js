app.controller('procesosCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "../pricat/procesosinfo";
  $scope.url = "../pricat/procesos";
  $scope.urlActividades = "../pricat/actividades";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.procesos = angular.copy(info.procesos);
      $scope.usuarios = angular.copy(info.usuarios);
      $scope.areas = angular.copy(info.areas);
      $scope.actividades = angular.copy(info.actividades);
      angular.element('.close').trigger('click');
    });
  }

  $scope.getInfo();

  $scope.proceso = {};

  $scope.saveProceso = function(){
    $http.post($scope.url, $scope.proceso).then(function(response){
      $scope.getInfo();
      $scope.proceso = {};
      $scope.procesoForm.$setPristine();
    }, function(){});
  }

  $scope.setProceso = function(idproceso){
    $scope.actividad = {};
    $scope.actividadForm.$setPristine();
    $scope.actividad.act_proc_id = idproceso;
  }

  $scope.editProceso = function(idproceso){
    console.log(idproceso);
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
    $scope.actividad.act_ar_id = $scope.actividad.act_ar_id.id;
    $scope.actividad.pre_act_pre_id = $scope.actividad.pre_act_pre_id != undefined ? $scope.actividad.pre_act_pre_id.id : '';

    $http.post($scope.urlActividades, $scope.actividad).then(function(response){
      $scope.getInfo();
      $scope.actividad = {};
      $scope.actividadForm.$setPristine();
    }, function(){});
  }

  $scope.editActividad = function(idactividad){
    console.log(idactividad);
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
