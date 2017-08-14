app.controller('paso7Ctrl', ['$scope', '$http', '$filter', '$mdDialog', function($scope, $http, $filter, $mdDialog){
  $scope.getUrl = 'paso7info';
  $scope.url = 'paso7update';

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.vocabas = angular.copy(info.vocabas);
    $scope.marcas = angular.copy(info.marcas);
    $scope.producto.deslogyca = angular.copy($scope.item.detalles.ide_deslarga);
    $scope.producto.desbesa = angular.copy($scope.item.detalles.ide_descompleta);
    $scope.producto.descorta = angular.copy($scope.item.detalles.ide_descorta);
    $scope.producto.uso = angular.copy($scope.item.detalles.uso);
    $scope.producto.marca = $filter('filter')($scope.marcas, {mar_nombre : $scope.item.detalles.ide_marca})[0];
    $scope.producto.contenido = parseInt(angular.copy($scope.item.detalles.ide_contenido), 10);
    $scope.producto.contum = angular.copy($scope.item.detalles.ide_umcont);
    $scope.producto.variedad = [];
    angular.forEach(angular.copy($scope.item.detalles.ide_variedad), function(value, key) {
      var variedad = $filter('filter')($scope.vocabas, {id : value})[0];
      $scope.producto.variedad.push(variedad);
    });
  });

  $scope.vocabasSearch = function(query){
    if(query){
      return $filter('filter')($scope.vocabas, {tvoc_palabra : query});
    }
    else{
      return $scope.vocabas;
    }
  }

  $scope.marcaSearch = function(query){
    if(query){
      return $filter('filter')($scope.marcas, {mar_nombre : query});
    }
    else{
      return $scope.marcas;
    }
  }

  $scope.createDescripciones = function(){
    // $scope.producto.deslogyca = '';
    // $scope.producto.desbesa = '';
    // $scope.producto.descorta = '';
    // $scope.producto.varserie = [];
    //
    // if($scope.producto.tipo != 'Regular' && $scope.producto.tipo != 'Etch.'){
    //   $scope.producto.deslogyca += $scope.producto.tipo;
    //   $scope.producto.desbesa += $scope.producto.tipo;
    //   $scope.producto.descorta += $scope.producto.tipo;
    // }
    //
    // if($scope.producto.uso != undefined){
    //   $scope.producto.deslogyca += $scope.producto.uso.tvoc_abreviatura;
    //   $scope.producto.desbesa += $scope.producto.uso.tvoc_palabra;
    //   $scope.producto.descorta += $scope.producto.uso.tvoc_abreviatura;
    // }
    //
    // if($scope.producto.marca != undefined){
    //   $scope.producto.deslogyca += $scope.producto.marca.mar_nombre;
    //   $scope.producto.desbesa += ' '+$scope.producto.marca.mar_nombre;
    //   var lineas = $filter('filter')($scope.linea, {mar_nombre : $scope.producto.marca.mar_nombre});
    //   $scope.producto.categoria = lineas[0].lineas[0].categorias.categorias;
    // }
    // else{
    //   $scope.producto.categoria = '';
    // }
    //
    // if($scope.producto.variedad.length > 0){
    //   $scope.producto.deslogyca += ' ';
    //   $scope.producto.desbesa += ' ';
    //   $scope.descvariedad = ' ';
    //   angular.forEach($scope.producto.variedad, function(value, key) {
    //     $scope.producto.deslogyca += $filter('lowercase')(value.tvoc_abreviatura);
    //     $scope.producto.desbesa += ' '+value.tvoc_palabra;
    //     $scope.descvariedad += $filter('lowercase')(value.tvoc_abreviatura);
    //     $scope.producto.varserie.push(value.id);
    //   });
    // }
    //
    // if($scope.producto.contenido != undefined){
    //   $scope.producto.deslogyca += 'X'+$scope.producto.contenido;
    //   $scope.producto.desbesa += ' X '+$scope.producto.contenido;
    //   $scope.producto.descorta += 'X'+$scope.producto.contenido;
    // }
    //
    // if($scope.producto.contum != undefined){
    //   $scope.producto.deslogyca += $scope.producto.contum;
    //   $scope.producto.desbesa += $scope.producto.contum;
    //   $scope.producto.descorta += $scope.producto.contum;
    // }
  }

  $scope.saveProducto = function(){
    console.log($scope.producto);
  }
}]);
