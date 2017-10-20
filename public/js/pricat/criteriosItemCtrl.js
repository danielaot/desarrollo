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
      angular.element('.close').trigger('click');
      $scope.progress = false;
    }, function(error){
      $scope.getInfo();
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
    $scope.progress = true;
    $scope.criterio.cri_plan = $scope.criterio.planes.idCriterioPlan;
    $http.post($scope.url, $scope.criterio).then(function(response){
      $scope.getInfo();
    }, function(error){
      console.log(error);
      alert(error);
      $scope.getInfo();
    });   
  }

  $scope.editCriterio = function(objeto){
    var criterio = angular.copy(objeto);

    $scope.criterio = criterio;

    $scope.titulo = criterio.planes.nombreCriterioPlan;

    if(criterio.cri_oferta == 1){
      $scope.criterio.cri_oferta = true;
    }

    if(criterio.cri_estuche == 1){
      $scope.criterio.cri_estuche = true;
    }
    
    if(criterio.cri_regular == 1){
      $scope.criterio.cri_regular = true;
    }
  }

}]);
