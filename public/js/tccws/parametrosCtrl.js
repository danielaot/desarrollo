app.controller('parametrosCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "parametrosinfo";
	$scope.url = "parametros";
	$scope.progress = true;
  $scope.isEdit == false;

	$scope.getInfo = function(){
		$http.get($scope.getUrl).then(function(response){
    		var data = response.data;
        	$scope.parametros = angular.copy(data.parametros);
        	$scope.progress = false;
    		console.log($scope.parametros);
    	});
	}

	$scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(2).notSortable()
  ];

  $scope.getInfo();

  $scope.saveParametro = function(){
    $scope.progress = true;
    if ($scope.isEdit == false) {
      $http.post($scope.url, $scope.parametro).then(function(response){
        $scope.getInfo();
      }, function(error){
        console.log(error);
        $scope.getInfo();
      });
    }else{
      $http.put($scope.url + '/' + $scope.parametro.id, $scope.parametro).then(function(response){        
        console.log(response);
        $scope.parametro = {};
        $scope.getInfo();
      });
    }
    angular.element('.close').trigger('click');
  }

  $scope.editarParametro = function(parametro){
    $scope.parametro = angular.copy(parametro);
    $scope.isEdit = true;
  }

  $scope.resetForm = function(){
    $scope.parametro = {};
    $scope.isEdit = false;
    }

  $scope.eliminarParametro = function(parametro){

    var confirm = $mdDialog.confirm()
    .title('¡ALERTA!')
    .textContent('¿Realmente desea eliminar el registro?')
    .ariaLabel('Lucky day')
    .targetEvent()
    .ok('Si')
    .cancel('No, gracias');
    $mdDialog.show(confirm).then(function() {
      $http.delete($scope.url + '/' + parametro.id).then(function(response){
        $scope.getInfo();
        $scope.progress = true;
      });
    });
  }

}]);