app.controller('notificacionsanitariaCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "notificacionsanitariainfo";
  $scope.url = "notificacionsanitaria";
  $scope.updateUrl = "notificacionsanitariaupdate";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.notificaciones = angular.copy(info.notificaciones);
      $scope.graneles = angular.copy(info.graneles);
      angular.element('.close').trigger('click');
    });
  }

  $scope.getInfo();

  $scope.notificacion = {};

  $scope.granelSearch = function(query){
    var graneles = $filter('xor')($scope.graneles, $scope.notigraneles, 'ite_id');

    if(query){
      var filtrado = $filter('filter')(graneles, {ite_txt_referencia : query});
      if(filtrado.length == 0){
        filtrado = $filter('filter')(graneles, {ite_txt_descripcion : query});
      }
      return filtrado;
    }
    else{
      return graneles;
    }
  }

  $scope.set = function(){
    $scope.notificacion = {};
    $scope.notigraneles = [];
    angular.element("input[type='file']").val(null);
    $scope.notificacionForm.$setPristine();
    $scope.granelesError = false;
  }

  $scope.addGranel = function(){
    if($scope.granel != ''){
      var exist = $filter('contains')($scope.notigraneles, $scope.granel);

      if(!exist){
        $scope.notigraneles.push($scope.granel);
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
    if($scope.notigraneles.length > 0)
      $scope.granelesError = false;
    else
      $scope.granelesError = true;

    if(!$scope.granelesError){
      $scope.notificacion.nosa_fecha_inicio = new Date($scope.nosa_fecha_inicio).toDateString();
      $scope.notificacion.nosa_fecha_vencimiento = new Date($scope.nosa_fecha_vencimiento).toDateString();

      var formData = new FormData();
      angular.forEach($scope.notificacion, function (value, key) {
        formData.append(key, value);
      });

      formData.append('documento', $scope.documento);

      angular.forEach($scope.notigraneles, function (value, key) {
        formData.append('notigraneles[]', value.ite_txt_referencia);
      });

      if($scope.notificacion.id != undefined){
        var url = $scope.updateUrl;
      }
      else{
        var url = $scope.url;
      }

      $http.post(url, formData, {
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined}
      })
      .then(function(response){
        $scope.getInfo();
      }, function(){});
    }
  }

  $scope.edit = function(idnotificacion){
    $scope.notificacion = angular.copy($filter('filter')($scope.notificaciones, {id : idnotificacion})[0]);

    var fecha_ini = new Date($scope.notificacion.nosa_fecha_inicio);
    fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
    $scope.nosa_fecha_inicio = new Date(fecha_ini);

    var fecha_fin = new Date($scope.notificacion.nosa_fecha_vencimiento);
    fecha_fin = fecha_fin.getTime() + fecha_fin.getTimezoneOffset()*60*1000;
    $scope.nosa_fecha_vencimiento = new Date(fecha_fin);

    $scope.notigraneles = [];
    for(var x in $scope.notificacion.graneles){
      var granel = $filter('filter')($scope.graneles, {ite_txt_referencia : $scope.notificacion.graneles[x].rsg_ref_granel})[0];
      $scope.notigraneles.push(granel);
    }
    angular.element("input[type='file']").val(null);
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
