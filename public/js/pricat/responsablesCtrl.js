
app.controller('responsablesCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "responsablesinfo";
  $scope.url = "responsables";

  $scope.usuario = '';
  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.usuarios = angular.copy(info.usuarios);
      $scope.areas = angular.copy(info.areas);
      $scope.progress = false;
      angular.element('.close').trigger('click');
    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(3).notSortable()
  ];

  $scope.getInfo();

  $scope.setArea = function(){
    $scope.area = {};
    $scope.responsables = [];
    $scope.areaForm.$setPristine();
    $scope.responsableError = false;
  }

  $scope.addResponsable = function(){
    if($scope.usuario != ''){
      var responsable = $filter('filter')($scope.usuarios, {dir_txt_nombre : $scope.usuario});
      var exist = $filter('contains')($scope.responsables, responsable[0]);

      if(!exist){
        $scope.responsables.push(responsable[0]);
        $scope.responsableError = false;
      }
      $scope.usuario = '';
    }
  }

  $scope.saveArea = function(){
    if($scope.responsables.length > 0)
      $scope.responsableError = false;
    else
      $scope.responsableError = true;

    if(!$scope.responsableError){
      $scope.progress = true;
      $scope.area.responsables = $scope.responsables;
      if($scope.area.id != undefined){
        $http.put($scope.url+'/'+$scope.area.id, $scope.area).then(function(response){
          $scope.getInfo();
        }, function(){});
      }
      else{
        $http.post($scope.url, $scope.area).then(function(response){
          $scope.getInfo();
        }, function(){});
      }
    }
  }

  $scope.editArea = function(idarea){
    $scope.area = angular.copy($filter('filter')($scope.areas, {id : idarea})[0]);
    $scope.responsables = [];
    for(var y in $scope.area.responsables){
      $scope.responsables.push($scope.area.responsables[y].usuarios);
    }
  }

  $scope.deleteResponsable = function(id){
    for(var x in $scope.responsables){
      var responsable = $scope.responsables[x];
      if(responsable['dir_id'] == id){
        $scope.responsables.splice(x, 1);
      }
    }
  }

  $scope.deleteArea = function(ev, idarea){
    var confirm = $mdDialog.confirm()
          .title('')
          .textContent('Desea eliminar el área?')
          .ariaLabel('area')
          .targetEvent(ev)
          .ok('Eliminar')
          .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      $http.delete($scope.url+'/'+idarea).then(function(response){
        $scope.getInfo();
      }, function(){});
    },function(){});
  }
}]);
