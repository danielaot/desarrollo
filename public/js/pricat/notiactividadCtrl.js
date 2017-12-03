
app.controller('notiactividadCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "notiactividadinfo";
  $scope.url = "notiactividad";

  $scope.usuario = '';
  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.usuarios = angular.copy(info.usuarios);
      $scope.actividad = angular.copy(info.actividad);
      $scope.notificacion = angular.copy(info.notificacion);
      $scope.progress = false;
      angular.element('.close').trigger('click');
    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(3).notSortable()
  ];

  $scope.getInfo();

  $scope.setNotificacion = function(){
    $scope.notificacion = {};
    $scope.responsables = [];
    $scope.notificacionForm.$setPristine();
    $scope.responsableError = false;
  }

  $scope.addResponsable = function(){
    if($scope.usuario != ''){
      var responsable = $filter('filter')($scope.usuarios, {dir_txt_nombre : $scope.usuario});
      var exist = $filter('contains')($scope.responsables, responsable[0]);

      if(!exist){
        $scope.responsables.push(responsable[0]);
        $scope.responsableError = false;
      }
      $scope.usuario = '';
    }
  }

  $scope.saveNotificacion = function(){
    if($scope.responsables.length > 0)
      $scope.responsableError = false;
    else
      $scope.responsableError = true;

    if(!$scope.responsableError){
      $scope.progress = true;
      $scope.notificacion.responsables = $scope.responsables;
      if($scope.notificacion.id != undefined){
        $http.put($scope.url+'/'+$scope.notificacion.id, $scope.notificacion).then(function(response){
          $scope.getInfo();
        }, function(){});
      }
       else{
        $http.post($scope.url, $scope.notificacion).then(function(response){
          console.log($scope.notificacion);
          $scope.getInfo();
        }, function(){});
       }
     }
  }

  $scope.editNotificacion = function(notificacion){

     $scope.notificacion = notificacion;
     $scope.responsables = [];
     for(var y in $scope.notificacion.notiactividad){
       $scope.responsables.push($scope.notificacion.notiactividad[y].usuarios);
     }


  }

  $scope.deleteResponsable = function(id){
    for(var x in $scope.responsables){
      var responsable = $scope.responsables[x];
      if(responsable['dir_id'] == id){
        $scope.responsables.splice(x, 1);
      }
    }
  }

  // $scope.deleteArea = function(ev, idarea){
  //   var confirm = $mdDialog.confirm()
  //         .title('')
  //         .textContent('Desea eliminar el área?')
  //         .ariaLabel('area')
  //         .targetEvent(ev)
  //         .ok('Eliminar')
  //         .cancel('Cancelar');
  //
  //   $mdDialog.show(confirm).then(function(){
  //     $http.delete($scope.url+'/'+idarea).then(function(response){
  //       $scope.getInfo();
  //     }, function(){});
  //   },function(){});
  // }

}]);
