app.controller('fotosCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "fotosinfo";
  $scope.url = "fotos";
  $scope.autocompleteDemoRequireMatch = true;
  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.referencias = angular.copy(info.referencias);
      angular.element('.close').trigger('click');
      $scope.progress = false;
    });
  }

  $scope.getInfo();

  $scope.referenciasSearch = function(query){
    if(query){
      return $filter('filter')($scope.referencias, {ite_referencia : query});
    }
    else{
      return $scope.referencias;
    }
  }

  $scope.save = function(){

      var formData = new FormData();
      console.log($scope.imagen);

      formData.append('file', $scope.imagen);
      console.log(formData);

        $http.post($scope.url, formData, {
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined}
        })
        .then(function(response){
          $scope.progress = false;
        }, function(){});
    }

}]);
