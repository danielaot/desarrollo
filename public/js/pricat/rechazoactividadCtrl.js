app.controller('rechazoactividadCtrl', ['$scope', '$http', '$filter','$window',  function($scope, $http, $filter, $window){
  $scope.getUrl = "rechazoactividadesGetInfo";
  $scope.url = "rechazoactividades";
  $scope.paso = {};
  $scope.actividad = [];
  $scope.dato = [];
  var mostrar = [];
//  $scope.progress = true;


  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.datos = angular.copy(info.datos);
      $scope.actividades = angular.copy(info.actividades);

      actividadesMostrar = [];
      angular.forEach($scope.datos, function(dato){
        $scope.dat = dato;
      });

      var parar = true;
      angular.forEach($scope.actividades, function(actividad){
        if (actividad.id !== $scope.dat.idactividad && parar) {
          actividadesMostrar.push(actividad);
        }else{
          parar = false;
        }
      });
      actividadesMostrar.push($scope.dat.infoCompleta.actividades);
      $scope.actividad = actividadesMostrar;

      console.log(actividadesMostrar);
    });
  }

  $scope.getInfo();

  $scope.aceptarPaso =  function(dato){
    $scope.dato = dato;
    $http.post($scope.url, $scope.dato).then(function(response){
      var data = response.data;
      //$window.location = data;
    });
  }


}]);
