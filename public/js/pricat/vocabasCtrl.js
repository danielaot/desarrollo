app.controller('vocabasCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "vocabasinfo";
  $scope.url = "vocabas";

  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.vocabas = angular.copy(info.vocabas);
      angular.element('.close').trigger('click');
      $scope.progress = false;
    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(2).notSortable()
  ];

  $scope.getInfo();

  $scope.setPalabra = function(){
    $scope.palabra = {};
    $scope.palabraForm.$setPristine();
  }

  $scope.savePalabra = function(){
    if($scope.palabra.id != undefined){
      $http.put($scope.url+'/'+$scope.palabra.id, $scope.palabra).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
    else{
      $http.post($scope.url, $scope.palabra).then(function(response){
        $scope.getInfo();
      }, function(){});
    }
  }

  $scope.editPalabra = function(idpalabra){
    $scope.palabra = $filter('filter')($scope.vocabas, {id : idpalabra})[0];
    $scope.palabraForm.$setPristine();
  }
}]);
