app.controller('consultaCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "consultainfo";
  $scope.url = "consulta";
  $scope.autocompleteDemoRequireMatch = true;
  $scope.consultaref = [];
  $scope.producto = {};
  $scope.empaque = {};
  $scope.patron = {};
  $scope.progress = true;
  //$scope.referencia = {};

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.proyectos = angular.copy(info.proyectos);
      $scope.referencias = angular.copy(info.referencias);
      console.log($scope.referencias);
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

   function transformChip(chip) {
    if (angular.isObject(chip)) {
      return chip;
    }
    return { name: chip, type: 'new' }
  }

  $scope.onAddReferencia = function(){

  }

  $scope.onRemoveReferencia = function(){

  }

  $scope.consultaReferencia = function(){
    $http.post($scope.url, $scope.consultaref).then(function(response){
      $scope.ref = $scope.consultaref;
    }, function(){});
  }

  $scope.setReferencia = function(referencia){
  $scope.referencia = referencia;
  //Inicio Paso 1
  $scope.producto.origen = angular.copy($scope.referencia.detalles.origen.descripcionItemCriterioMayor);
  $scope.producto.tipomarca = angular.copy($scope.referencia.detalles.ide_tmarca);
  $scope.producto.variedad = angular.copy($scope.referencia.detalles.variedad.descripcionItemCriterioMayor);
  $scope.producto.linea = angular.copy($scope.referencia.detalles.linea.descripcionItemCriterioMayor);
  $scope.producto.sublinmercadeo = angular.copy($scope.referencia.detalles.submercadeo.descripcionItemCriterioMayor);
  //$scope.producto.submarca = angular.copy($scope.referencia.detalles.ide_submarca);
  $scope.producto.clase = angular.copy($scope.referencia.detalles.clase.descripcionItemCriterioMayor);
  $scope.producto.presentacion = angular.copy($scope.referencia.detalles.presentacion.descripcionItemCriterioMayor);
  $scope.producto.categoria = angular.copy($scope.referencia.detalles.categoria.descripcionItemCriterioMayor);
  $scope.producto.sublinea = angular.copy($scope.referencia.detalles.sublinea.descripcionItemCriterioMayor);
  $scope.producto.submercadeo2 = angular.copy($scope.referencia.detalles.submercadeo2.descripcionItemCriterioMayor);
  $scope.producto.regalias = angular.copy($scope.referencia.detalles.ide_regalias);
  $scope.producto.tipooferta = angular.copy($scope.referencia.detalles.ide_tiprom);
  $scope.producto.menupromo = angular.copy($scope.referencia.detalles.ide_meprom);
  $scope.producto.tipo = angular.copy($scope.referencia.ite_tproducto);
  var fecha = new Date($scope.referencia.ite_dat_captura);
  fecha = fecha.getTime() + fecha.getTimezoneOffset()*60*1000;
  $scope.referencia.ite_dat_captura = new Date(fecha);
  $scope.captura = $scope.referencia.ite_dat_captura;
  //Fin Paso 1
  //Inicio Paso 6
  $scope.producto.alto = angular.copy($scope.referencia.detalles.ide_alto);
  $scope.producto.ancho = angular.copy($scope.referencia.detalles.ide_ancho);
  $scope.producto.profundo = angular.copy($scope.referencia.detalles.ide_profundo);
  $scope.producto.volumen = angular.copy($scope.referencia.detalles.ide_volumen);
  $scope.producto.pesobruto = angular.copy($scope.referencia.detalles.ide_pesobruto);
  $scope.producto.pesoneto = angular.copy($scope.referencia.detalles.ide_pesoneto);
  $scope.producto.tara = angular.copy($scope.referencia.detalles.ide_tara);

  $scope.empaque.alto = angular.copy($scope.referencia.eanppal.iea_alto);
  $scope.empaque.ancho = angular.copy($scope.referencia.eanppal.iea_ancho);
  $scope.empaque.profundo = angular.copy($scope.referencia.eanppal.iea_profundo);
  $scope.empaque.volumen = angular.copy($scope.referencia.eanppal.iea_volumen);
  $scope.empaque.pesobruto = angular.copy($scope.referencia.eanppal.iea_pesobruto);
  $scope.empaque.pesoneto = angular.copy($scope.referencia.eanppal.iea_pesoneto);
  $scope.empaque.tara = angular.copy($scope.referencia.eanppal.iea_tara);

  $scope.producto.cantemb = angular.copy($scope.referencia.eanppal.iea_cantemb);
  $scope.patron.numtendidos = angular.copy($scope.referencia.patrones.ipa_numtendidos);
  $scope.patron.cajten = angular.copy($scope.referencia.patrones.ipa_cajten);
  $scope.patron.tenest = angular.copy($scope.referencia.patrones.ipa_tenest);
  $scope.patron.undten = angular.copy($scope.referencia.patrones.ipa_undten);
  $scope.patron.undest = angular.copy($scope.referencia.patrones.ipa_undest);
  $scope.patron.caest = angular.copy($scope.referencia.patrones.ipa_caest);
  //Fin Paso 6

  }



}]);
