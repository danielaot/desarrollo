app.controller('paso1Ctrl', ['$scope', '$window', '$http', '$filter', function($scope, $window, $http, $filter){
  $scope.getUrl = 'paso1info';
  $scope.url = 'paso1';
  //$scope.pattern = '[a-zA-Z0-9\s]+';
  $scope.progress = false;

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.vocabas = angular.copy(info.vocabas);
    $scope.catlogyca = $filter('orderBy')(angular.copy(info.catlogyca), 'tcl_descripcion');
    $scope.marca = angular.copy(info.marca);
    $scope.origen = angular.copy(info.origen);
    $scope.tipomarca = angular.copy(info.tipomarca);
    $scope.tipooferta = angular.copy(info.tipooferta);
    $scope.menupromociones = angular.copy(info.menupromociones);
    $scope.tipopromocion = angular.copy(info.tipopromocion);
    $scope.presentacion = angular.copy(info.presentacion);
    $scope.variedad = angular.copy(info.variedad);
    $scope.categoria = angular.copy(info.categoria);
    $scope.linea = angular.copy(info.linea);
    $scope.sublinea = angular.copy(info.sublinea);
    $scope.sublinmercadeo = angular.copy(info.sublinmercadeo);
    $scope.sublinmercadeo2 = angular.copy(info.sublinmercadeo2);
    $scope.submarca = angular.copy(info.submarca);
    $scope.regalias = angular.copy(info.regalias);
    $scope.segmento = angular.copy(info.segmento);
    $scope.acondicionamiento = angular.copy(info.acondicionamiento);
    $scope.referencia = angular.copy(info.referencia);
    $scope.items = angular.copy(info.items);
  });

  $scope.producto = {
                      'categoria' : '',
                      'variedad' : [],
                      'tipo' : 'Regular',
                      'fabricante' : 'Belleza Express SA'
                    };

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
      return $filter('filter')($scope.marca, {mar_nombre : query});
    }
    else{
      return $scope.marca;
    }
  }

  $scope.categoriaSearch = function(query){
    if(query){
      return $filter('filter')($scope.catlogyca, {tcl_descripcion : query});
    }
    else{
      return $scope.catlogyca;
    }
  }

  $scope.itemSearch = function(query){
    if(query){
      return $filter('filter')($scope.items, {ite_txt_referencia : query});
    }
    else{
      return $scope.items;
    }
  }

  $scope.sublineaSearch = function(query){
    if(query){
      return $filter('filter')($scope.sublinea, {descripcionItemCriterioMayor : query});
    }
    else{
      return $scope.sublinea;
    }
  }

  $scope.sublinmercadeoSearch = function(query){
    if(query){
      return $filter('filter')($scope.sublinmercadeo, {descripcionItemCriterioMayor : query});
    }
    else{
      return $scope.sublinmercadeo;
    }
  }

  $scope.sublinmercadeo2Search = function(query){
    if(query){
      return $filter('filter')($scope.sublinmercadeo2, {descripcionItemCriterioMayor : query});
    }
    else{
      return $scope.sublinmercadeo2;
    }
  }

  $scope.presentacionSearch = function(query){
    if(query){
      return $filter('filter')($scope.presentacion, {descripcionItemCriterioMayor : query});
    }
    else{
      return $scope.presentacion;
    }
  }

  $scope.variedadbesaSearch = function(query){
    if(query){
      return $filter('filter')($scope.variedad, {descripcionItemCriterioMayor : query});
    }
    else{
      return $scope.variedad;
    }
  }

  $scope.validateTipo = function(){
    $scope.usodisabled = $scope.producto.tipo == 'Etch.';
    if($scope.usodisabled){
      $scope.producto.uso = $filter('filter')($scope.vocabas, {tvoc_abreviatura : $scope.producto.tipo}, true)[0];
    }
    else {
      $scope.producto.uso = undefined;
    }

    $scope.createDescripciones();
  }

  $scope.createDescripciones = function(){
    $scope.producto.deslogyca = '';
    $scope.producto.desbesa = '';
    $scope.producto.descorta = '';
    $scope.producto.varserie = [];

    if($scope.producto.tipo != 'Regular' && $scope.producto.tipo != 'Etch.'){
      $scope.producto.deslogyca += $scope.producto.tipo;
      $scope.producto.desbesa += $scope.producto.tipo;
      $scope.producto.descorta += $scope.producto.tipo;
    }

    if($scope.producto.uso != undefined){
      $scope.producto.deslogyca += $scope.producto.uso.tvoc_abreviatura;
      $scope.producto.desbesa += $scope.producto.uso.tvoc_palabra;
      $scope.producto.descorta += $scope.producto.uso.tvoc_abreviatura;
    }

    if($scope.producto.marca != undefined){
      $scope.producto.deslogyca += $scope.producto.marca.mar_nombre;
      $scope.producto.desbesa += ' '+$scope.producto.marca.mar_nombre;
      var lineas = $filter('filter')($scope.linea, {mar_nombre : $scope.producto.marca.mar_nombre});
      $scope.producto.categoria = lineas[0].lineas[0].categorias.categorias;
    }
    else{
      $scope.producto.categoria = '';
    }

    if($scope.producto.variedad.length > 0){
      $scope.producto.deslogyca += ' ';
      $scope.producto.desbesa += ' ';

      angular.forEach($scope.producto.variedad, function(value, key) {
        $scope.producto.deslogyca += $filter('lowercase')(value.tvoc_abreviatura);
        $scope.producto.desbesa += ' '+value.tvoc_palabra;
        $scope.producto.varserie.push(value.id);
      });
    }

    if($scope.producto.contenido != undefined){
      $scope.producto.deslogyca += 'X'+$scope.producto.contenido;
      $scope.producto.desbesa += ' X '+$scope.producto.contenido;
      $scope.producto.descorta += 'X'+$scope.producto.contenido;
    }

    if($scope.producto.contum != undefined){
      $scope.producto.deslogyca += $scope.producto.contum;
      $scope.producto.desbesa += $scope.producto.contum;
      $scope.producto.descorta += $scope.producto.contum;
    }
  }

  $scope.saveProducto = function(){
    $scope.progress = true;
    //console.log($scope.producto);
    $http.post($scope.url, $scope.producto).then(function(response){
      $scope.progress = false;
      $window.parent.location = response.data;
    }, function(){});
  }
}]);
