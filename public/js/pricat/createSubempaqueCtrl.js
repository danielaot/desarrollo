app.controller('createSubempaqueCtrl', ['$scope', '$http', function($scope, $http){
  $scope.getUrl = 'createsubempaqueinfo';
  $scope.url = 'createsubempaque';

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.items = angular.copy(info.items);
  });

  $scope.subempaque = {};

  $scope.itemSearch = function(query){
    if(query){
      return $filter('filter')($scope.items, {ite_referencia : query});
    }
    else{
      return $scope.items;
    }
  }

  $scope.saveSubempaque = function(){
    $scope.progress = true;
    $http.post($scope.url, $scope.subempaque).then(function(response){
      $scope.progress = false;
      $window.location = response.data;
    }, function(){});
  }
}]);
