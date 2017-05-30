app.controller('notificacionsanitariaCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "notificacionsanitariainfo";
  $scope.url = "notificacionsanitaria";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.notificaciones = angular.copy(info.notificaciones);
      $scope.graneles = angular.copy(info.graneles);
      angular.element('.close').trigger('click');
      //console.log($scope.notificaciones);
      /*$scope.procesos = angular.copy(info.procesos);*/
    });
  }

  $scope.getInfo();

  $scope.notificacion = {};

  $scope.granelSearch = function(query){
    if(query){
      var filtrado = $filter('filter')($scope.graneles, {ite_txt_referencia : query});
      if(filtrado.length == 0){
        filtrado = $filter('filter')($scope.graneles, {ite_txt_descripcion : query});
      }
      return filtrado;
    }
    else{
      return $scope.graneles;
    }
  }

  $scope.set = function(){
    $scope.notificacion = {};
    $scope.notigraneles = [];
    $scope.notificacionForm.$setPristine();
    $scope.granelesError = false;
  }

  $scope.addGranel = function(){
    if($scope.granel != ''){
      var exist = $filter('contains')($scope.notigraneles, $scope.granel);
      console.log($scope.granel);
      console.log($scope.notigraneles);
      if(!exist){
        $scope.notigraneles.push(angular.copy($scope.granel));
        $scope.granelesError = false;
      }
      $scope.granel = '';
    }
  }

  $scope.deleteGranel = function(idgranel){
    for(var x in $scope.notigraneles){
      var granel = $scope.notigraneles[x];
      if(granel['ite_id'] == idgranel){
        $scope.notigraneles.splice(x, 1);
      }
    }
  }

  $scope.save = function(){
    console.log($scope.notificacion);
    if($scope.notigraneles.length > 0)
      $scope.granelesError = false;
    else
      $scope.granelesError = true;
    /*
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
    */
  }

  $scope.edit = function(idnotificacion){
    $scope.notificacion = angular.copy($filter('filter')($scope.notificaciones, {id : idnotificacion})[0]);

    var fecha_ini = new Date($scope.notificacion.nosa_fecha_inicio);
    fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
    $scope.notificacion.nosa_fecha_inicio = new Date(fecha_ini);

    var fecha_fin = new Date($scope.notificacion.nosa_fecha_vencimiento);
    fecha_fin = fecha_fin.getTime() + fecha_fin.getTimezoneOffset()*60*1000;
    $scope.notificacion.nosa_fecha_vencimiento = new Date(fecha_fin);

    $scope.notigraneles = [];

    $scope.notificacionForm.$setPristine();
  }

  $scope.delete = function(ev, idnotificacion){
    var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea eliminar la notificación?')
          .ariaLabel('notificacion')
          .targetEvent(ev)
          .ok('Eliminar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      console.log($scope.notificacion);
      /*$http.delete($scope.url+'/'+idnotificacion).then(function(response){
        $scope.getInfo();
      }, function(){});*/
    },function(){});
  }
}]);
