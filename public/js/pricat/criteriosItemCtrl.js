app.controller('criteriosCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "criteriosinfo";
  $scope.url = "criterios";

  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.criterios = angular.copy(info.criterios);
      $scope.planes = [];
      angular.forEach(info.planes, function (value, key) {
        var pick = $filter('pick')($scope.criterios, 'cri_plan == '+value.idCriterioPlan);
        if(pick.length == 0)
          $scope.planes.push(angular.copy(value));
      });
      $scope.progress = false;
      angular.element('.close').trigger('click');
    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(5).notSortable()
  ];

  $scope.getInfo();

  $scope.setCriterio = function(){
    $scope.criterio = {};
    $scope.criterioForm.$setPristine();
  }

  $scope.saveCriterio = function(){
    $scope.criterio.cri_plan = $scope.criterio.plan.idCriterioPlan;
    $http.post($scope.url, $scope.criterio).then(function(response){
      $scope.getInfo();
    }, function(){});
  }
}]);
