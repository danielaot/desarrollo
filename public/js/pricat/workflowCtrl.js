app.controller('workflowCtrl', ['$scope', '$http', '$filter', function($scope, $http, $filter){
  $scope.getUrl = 'workflowinfo';

  $scope.estados = {
    'En Proceso' : {
      label : 'label-primary',
      icon : 'glyphicon-wrench',
      state : 'inprogress'
    },
    'Pendiente' : {
      label : 'label-default',
      icon : 'glyphicon-record',
      state : ''
    },
    'Completado' : {
      label : 'label-success',
      icon : 'glyphicon-ok',
      state : 'complete'
    }
  };

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.proyectos = angular.copy(info.proyectos);
    $scope.estilos = angular.copy(info.estilos);
  });

  $scope.getEstilo = function(){
    return $scope.estilos[Math.floor(Math.random() * $scope.estilos.length)];
  }

  $scope.setProyecto = function(idproyecto){
    $scope.proyecto = angular.copy($filter('filter')($scope.proyectos, {id : idproyecto})[0]);
  }
}]);
