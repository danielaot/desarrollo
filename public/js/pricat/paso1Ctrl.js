app.controller('paso1Ctrl', ['$scope', '$window', '$http', '$filter', '$mdDialog', function($scope, $window, $http, $filter, $mdDialog){
  if ($scope.itemdet == undefined) {
    $scope.getUrl = 'paso1info';
    $scope.url = 'paso1';
  }else {
    $scope.getUrl = '../../paso1info';
    $scope.url = '../../paso1';
    $scope.urledit = '../../paso1edit';
  }
  //$scope.pattern = '[a-zA-Z0-9\s]+';
  $scope.itemdet;
  $scope.progress = true;

  $scope.getInfo = function (){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.vocabas = angular.copy(info.vocabas);
      $scope.catlogyca = $filter('orderBy')(angular.copy(info.catlogyca), 'tcl_descripcion');
      $scope.marcas = angular.copy(info.marcas);
      $scope.origen = angular.copy(info.origen);
      $scope.clase = angular.copy(info.clase);
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
      $scope.nomtemporada = angular.copy(info.nomtemporada);
      $scope.items = angular.copy(info.items);

      // inicio edit
      if ($scope.itemdet !== undefined) {
        $scope.producto.uso = angular.copy($scope.itemdet[0].uso);
        $scope.producto.marca = $filter('filter')($scope.marcas, {mar_nombre : $scope.itemdet[0].ide_marca})[0];
        $scope.producto.variedad = [];
        angular.forEach(angular.copy($scope.itemdet[0].ide_variedad), function(value, key) {
          var variedad = $filter('filter')($scope.vocabas, {id : value})[0];
          $scope.producto.variedad.push(variedad);
        });
        $scope.producto.contenido = parseInt(angular.copy($scope.itemdet[0].ide_contenido), 10);
        $scope.producto.contum = angular.copy($scope.itemdet[0].ide_umcont);
        $scope.producto.deslogyca = angular.copy($scope.itemdet[0].ide_deslarga);
        $scope.producto.desbesa = angular.copy($scope.itemdet[0].ide_descompleta);
        $scope.producto.descorta = angular.copy($scope.itemdet[0].ide_descorta);
        $scope.producto.catlogyca = angular.copy($scope.itemdet[0].logcategorias);
        $scope.producto.embalaje = angular.copy($scope.itemdet[0].itemean.iea_cantemb);
        $scope.producto.origen = angular.copy($scope.itemdet[0].origen);
        $scope.producto.tipomarca = angular.copy($scope.itemdet[0].tipomarcas);
        $scope.producto.variedadbesa = angular.copy($scope.itemdet[0].variedad);
        var filterLinea = $filter('filter')($scope.linea, {lineas:{descripcionItemCriterioMayor: $scope.itemdet[0].linea.descripcionItemCriterioMayor}});
        $scope.producto.linea = filterLinea[0];
        $scope.producto.sublinmercadeo = angular.copy($scope.itemdet[0].submercadeo);
        $scope.producto.submarca = angular.copy($scope.itemdet[0].submarca);
        $scope.producto.clase = angular.copy($scope.itemdet[0].clase);
        $scope.producto.presentacion = angular.copy($scope.itemdet[0].presentacion);
        $scope.producto.sublinea = angular.copy($scope.itemdet[0].sublinea);
        $scope.producto.sublinmercadeo2 = angular.copy($scope.itemdet[0].submercadeo2);
        $scope.producto.regalias = angular.copy($scope.itemdet[0].regalias);
        var fecha = new Date($scope.itemdet[0].items.ite_dat_captura);
        fecha = fecha.getTime() + fecha.getTimezoneOffset()*60*1000;
        $scope.itemdet[0].items.ite_dat_captura = new Date(fecha);
        $scope.captura = $scope.itemdet[0].items.ite_dat_captura;
      }
      //fin edit
      $scope.progress = false;
    });
  }

  $scope.getInfo();

  $scope.hoy = new Date();
  $scope.producto = {
                      'categoria' : '',
                      'variedad' : [],
                      'tipo' : 'Regular',
                      'fabricante' : 'Belleza Express SA'
                    };

  $scope.descvariedad = '';

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
      var lineas = $filter('filter')($scope.linea, {mar_nombre : $scope.producto.marca.mar_nombre})[0];
      $scope.producto.categoria = lineas.lineas[0].categorias.categorias;
    }
    else{
      $scope.producto.categoria = '';
    }

    if($scope.producto.variedad.length > 0){
      $scope.producto.deslogyca += ' ';
      $scope.producto.desbesa += ' ';
      $scope.descvariedad = ' ';

      angular.forEach($scope.producto.variedad, function(value, key) {
        $scope.producto.deslogyca += $filter('lowercase')(value.tvoc_abreviatura);
        $scope.producto.desbesa += ' '+value.tvoc_palabra;
        $scope.descvariedad += $filter('lowercase')(value.tvoc_abreviatura);
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

  $scope.modifyDescripciones = function(){
    $scope.producto.deslogyca = '';

    if($scope.producto.tipo != 'Regular' && $scope.producto.tipo != 'Etch.')
      $scope.producto.deslogyca += $scope.producto.tipo;

    if($scope.producto.uso != undefined)
      $scope.producto.deslogyca += $scope.producto.uso.tvoc_abreviatura;

    if($scope.producto.marca != undefined)
      $scope.producto.deslogyca += $scope.producto.marca.mar_nombre;

    if($scope.producto.variedad.length > 0){
      $scope.producto.deslogyca += ' '+$filter('lowercase')($scope.descvariedad);
    }

    if($scope.producto.contenido != undefined)
      $scope.producto.deslogyca += 'X'+$scope.producto.contenido;

    if($scope.producto.contum != undefined)
      $scope.producto.deslogyca += $scope.producto.contum;
  }

  $scope.saveProducto = function(ev){
    if($scope.producto.descorta.length > 18 || $scope.producto.deslogyca.length > 40){
      $mdDialog.show(
        $mdDialog.alert()
          .parent(angular.element(document.querySelector('.interno')))
          .clickOutsideToClose(true)
          .title('')
          .textContent('Revisar las descripciones antes de continuar')
          .ariaLabel('Descripciones')
          .ok('Aceptar')
          .targetEvent(ev)
      );
    }
    else{
      $scope.progress = true;
      $scope.producto.captura = new Date($scope.captura).toDateString();
      $http.post($scope.url, $scope.producto).then(function(response){
        $scope.progress = false;
        $window.location = response.data;
      }, function(){});
    }
  }

  $scope.editProducto = function(ev){
    if($scope.producto.descorta.length > 18 || $scope.producto.deslogyca.length > 40){
      $mdDialog.show(
        $mdDialog.alert()
          .parent(angular.element(document.querySelector('.interno')))
          .clickOutsideToClose(true)
          .title('')
          .textContent('Revisar las descripciones antes de continuar')
          .ariaLabel('Descripciones')
          .ok('Aceptar')
          .targetEvent(ev)
      );
    }
    else{
    //  $scope.progress = true;
      $scope.producto.captura = new Date($scope.captura).toDateString();
      $http.post($scope.urledit, $scope.producto).then(function(response){
        $scope.progress = false;
      //  $window.location = response.data;
      }, function(){});
    }
  }

}]);
