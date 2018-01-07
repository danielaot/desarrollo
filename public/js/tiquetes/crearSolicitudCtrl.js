app.controller('crearSolicitudCtrl', ['$scope', '$filter', '$http', function( $scope, $filter, $http){

  $scope.getUrl = 'solicitudinfo';
  $scope.urlCiudades = 'ciudadesinfo';
  $scope.detsoli = [];
  $scope.detsoli.nodias = 1;
  $scope.progress = true;
  //var personas = {};

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.persona = angular.copy(info.persona);
    console.log($scope.persona);
    $scope.aprueba = angular.copy(info.aprueba);
    $scope.ciudad = angular.copy(info.ciudad);
    $scope.paises = angular.copy(info.paises);
    $scope.progress = false;
  });

  $scope.nombreSearch = function(query){
    var filter = [];
    filter = $filter('filter')($scope.persona, {infopersona:{perTxtNomtercero : query}});
    return filter;
  }

  // $scope.aprobadorSearch = function(query){
  //   var filter = [];
  //   filter = $filter('filter')($scope.persona, {aprueba:{perTxtNomtercero : query}});
  //   return filter;
  // }

  $scope.paisoriSearch = function(query){
    var filter = [];
    filter =  $filter('filter')($scope.paises, {Pais : query});
    return filter;
  }

  $scope.ciupaisoriSearch = function(query){
      var filter = [];
      filter = $filter('filter')($scope.detsoli.porigen.ciudades, {Ciudad : query});
      return filter;
  }

  $scope.paisdestSearch = function(query){
    var filter = [];
    filter = $filter('filter')($scope.paises, {Pais : query});
    return filter;
  }

  $scope.ciupaisdestSearch = function(query){
      var filter = [];
      filter = $filter('filter')($scope.detsoli.pdestino.ciudades, {Ciudad : query});
      return filter;
  }

  $scope.saveSolicitud = function(query){
    $http.post($scope.urlSolicitud, $scope.solicitud).then(function(response){
      console.log();
    });
  }
}]);
