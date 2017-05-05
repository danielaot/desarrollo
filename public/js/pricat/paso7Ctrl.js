app.controller('paso7Ctrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = '../pricat/paso4info';
  $scope.url = '../pricat/paso4';

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.vocabas = angular.copy(info.vocabas);
    $scope.tembalaje = angular.copy(info.tembalaje);
  });

  $scope.producto = {};

  $scope.querySearch = function(query){
    if(query){
      return $filter('filter')($scope.vocabas, {tvoc_palabra : angular.uppercase(query)});
    }
    else{
      return $scope.vocabas;
    }
  }

  $scope.selectedItemChange = function(item){
    $scope.producto.tempaque = item;
  }
}]);
