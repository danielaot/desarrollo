app.controller('solicitudesCtrl', ['$scope', '$http', '$filter', '$window', function($scope, $http, $filter, $window){
  $scope.getUrl = "../solicitudcreateinfo";
  $scope.url = "../solicitud";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.items = angular.copy(info.items);
      angular.element('.close').trigger('click');
    });
  }

  $scope.getInfo();

  $scope.showRef = false;
  $scope.showPre = false;
  $scope.showFini = false;
  $scope.showFfin = false;

  $scope.hoy = new Date();
  $scope.referencias = [];
  $scope.solicitud = { 'tnovedad' : '' };

  $scope.changeNovedad = function(){
    $scope.referencias = [];
    $scope.referencia = {};
    $scope.showRef = false;
    $scope.showPre = false;
    $scope.showFini = false;
    $scope.showFfin = false;
    if($scope.solicitud.tnovedad == 'modificacion'){
      switch ($scope.solicitud.tmodifica) {
        case 'activacion':
        case 'suspension':
            $scope.showRef = true;
            $scope.showPre = false;
            $scope.showFini = true;
            $scope.showFfin = true;
          break;
        case 'precios':
            $scope.showRef = true;
            $scope.showPre = true;
            $scope.showFini = true;
            $scope.showFfin = true;
          break;
      }
    }
    else{
      $scope.showRef = true;
      $scope.showFini = true;
      if($scope.solicitud.tnovedad == 'codificacion'){
        $scope.showPre = true;
        $scope.showFfin = true;
      }
    }
  }

  $scope.itemSearch = function(query){
    if(query){
      var filtrado = $filter('filter')($scope.items, {ite_referencia : query});
      if(filtrado.length == 0){
        filtrado = $filter('filter')($scope.items, {ite_ean13 : query});
      }
      return filtrado;
    }
    else{
      return $scope.items;
    }
  }

  $scope.addReferencia = function(){
    if($scope.solicitudForm.$valid){
      $scope.referencias.push(angular.copy($scope.referencia));
      $scope.referencia = {};
      $scope.solicitudForm.$setPristine();
    }
  }

  $scope.saveSolicitud = function(){
    $scope.progress = true;
    $scope.solicitud.inicio = angular.copy(new Date($scope.solicitud.fecini).toDateString());
    $scope.solicitud.fin = angular.copy(new Date($scope.solicitud.fecfin).toDateString());
    $scope.solicitud.referencias = angular.copy($scope.referencias);

    $http.post($scope.url, $scope.solicitud).then(function(response){
      $scope.progress = false;
      $window.location = response.data;
    }, function(){});
  }
}]);
