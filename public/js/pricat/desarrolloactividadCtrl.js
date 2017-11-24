app.controller('desarrolloactividadCtrl', ['$scope', '$http', '$filter', '$mdDialog' , function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "desarrolloactividadesGetInfo";
  $scope.url = "desarrolloactividades";
  $scope.progress = true;
  $scope.idAct = [];
  $scope.actividad = [];
  $scope.selected = [];
  $scope.objetoEnvio = {};

  $scope.getInfo = function(){
    if ($scope.error != undefined) {
      $mdDialog.show(
        $mdDialog.alert()
          .parent(angular.element(document.querySelector('body')))
          .clickOutsideToClose(true)
          .title('')
          .textContent('La referencia no tiene lista de materiales')
          .ariaLabel('Errores')
          .ok('Aceptar')
      );
    }
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.desarrollos = angular.copy(info.desarrollos);
      $scope.actividades = angular.copy(info.actividades);
      $scope.progress = false;
    }, function(error){
      console.log(error);
      $scope.getInfo();
    })
  }

  $scope.regresar = function(objActividad){

      var actividadesMostrar = [];
      angular.forEach($scope.actividades, function(actividad){
        if(actividad.id != objActividad.dac_act_id){
          actividadesMostrar.push(actividad);
        }else{
          $scope.grupoCheckboxPredecesores =  angular.copy(actividadesMostrar);
        }
      });
      $scope.proyecto = objActividad;
  }

  $scope.exists = function (acti, list) {
    return list.indexOf(acti) > -1;
  };

  $scope.toggle = function (acti, list) {
    var idx = list.indexOf(acti);
    if (idx > -1) {
      list.splice(idx, 1);
    }
    else {
      list.push(acti);
    }
  };

  $scope.setSolicitud = function(){
    $scope.reg = {};
    $scope.selected = {};
    $scope.regresarForm.$setPristine();
  }

  $scope.enviarSolicitud = function(){
    $scope.objetoEnvio.selected = $scope.selected;
    $scope.objetoEnvio.observacion = $scope.observacion;
    $scope.objetoEnvio.proyecto = $scope.proyecto.proyectos.id;
     $http.post($scope.url, $scope.objetoEnvio).then(function(response){
       var data = response.data;
       angular.element('.close').trigger('click');
     });
  }

}]);
