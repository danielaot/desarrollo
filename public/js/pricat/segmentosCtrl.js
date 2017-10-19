app.controller('segmentosCtrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = "segmentosinfo";
  $scope.url = "segmentos";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.encabezado = angular.copy(info.encabezado);
      $scope.cierre = angular.copy(info.cierre);
      $scope.segmentos = angular.copy(info.segmentos);
      angular.element('.close').trigger('click');
    });
  }

  $scope.getInfo();

  $scope.setSegmento = function(){
    $scope.segmento = {};
    $scope.segmentoForm.$setPristine();
  }

  $scope.editSegmento = function(idsegmento,tnovedad){
    if(tnovedad == 'encabezado'){
      $scope.segmento = angular.copy($filter('filter')($scope.encabezado, {id : idsegmento})[0]);
      $scope.cantsgtos = $scope.encabezado.length;
    }
    else if(tnovedad == 'cierre'){
      $scope.segmento = angular.copy($filter('filter')($scope.cierre, {id : idsegmento})[0]);
      $scope.cantsgtos = $scope.cierre.length;
    }
    else{
      var segmentos = $scope.segmentos[tnovedad];
      $scope.segmento = angular.copy($filter('filter')(segmentos, {id : idsegmento})[0]);
      $scope.cantsgtos = segmentos.length;
    }
  }

  $scope.saveSegmento = function(){
    console.log($scope.segmento);
    if($scope.segmento.id != undefined){
      $http.put($scope.url+'/'+$scope.segmento.id, $scope.segmento).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
    else{
      $http.post($scope.url, $scope.segmento).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
  }
}]);
