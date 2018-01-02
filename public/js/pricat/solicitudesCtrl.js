app.controller('solicitudesCtrl', ['$scope', '$http', '$filter', '$window', function($scope, $http, $filter, $window){
  $scope.getUrl = "../solicitudcreateinfo";
  $scope.url = "../solicitud";
  $scope.urlPrecio = "../solicitudprecio";
  $scope.urlRef = "../solicitudref";

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.itemslogyca = angular.copy(info.itemslogyca);
      $scope.itemserp = angular.copy(info.itemserp);
      angular.element('.close').trigger('click');
    });
  }


  $scope.getInfo();

  $scope.precioBruto = function(){
    $http.post($scope.urlPrecio, $scope.referencia.ref).then(function(response){
      $scope.referencia.prebru = parseInt(response.data[0].precio);
    });
  }

  $scope.showRef = false;
  $scope.showPre = false;
  $scope.showFini = false;
  $scope.showFfin = false;

  $scope.hoy = new Date();
  $scope.referencias = [];
  $scope.solicitud = { 'tnovedad' : '', 'fecini' : $scope.hoy };

  $scope.changeNovedad = function(){
    $scope.referencias = [];
    $scope.referencia = {};
    $scope.showRef = false;
    $scope.showPre = false;
    $scope.showFini = false;
    $scope.showFfin = false;

    if($scope.solicitud.tnovedad == 'modificacion'){
      $scope.showIteLog = false;
      switch ($scope.solicitud.tmodifica) {
        case 'suspension':
            $scope.showRef = true;
            $scope.showPre = false;
            $scope.showFini = true;
            $scope.showFfin = true;
          break;
        case 'activacion':
        case 'precios':
            $scope.showRef = true;
            $scope.showPre = true;
            $scope.showFini = true;
            $scope.showFfin = true;
          break;
      }
    }
    else{
      $scope.showRef = true;
      $scope.showFini = true;
      $scope.showIteLog = false;
      if($scope.solicitud.tnovedad == 'codificacion'){
        $scope.showPre = true;
        $scope.showFfin = true;
        $scope.showIteLog = true;
      }
    }
  }

  $scope.itemSearchErp = function(query){
    if(query){
      return $filter('filter')($scope.itemserp, {referenciaItem : query});
    }
    else{
      return $scope.itemserp;
    }
  }

  $scope.itemSearchLog = function(query){
    if(query){
      return $filter('filter')($scope.itemslogyca, {ite_referencia : query});
    }
    else{
      return $scope.itemslogyca;
    }
  }

  $scope.addReferencia = function(){
    if($scope.solicitudForm.$valid){
      if($scope.solicitud.tnovedad == 'codificacion'){
        var referencia = {
            'referencia' : $scope.referencia.ref.ite_referencia,
            'descripcion' : $scope.referencia.ref.detalles.ide_descompleta
        };
      }
      else{
        var referencia = {
            'referencia' : $scope.referencia.ref.referenciaItem,
            'descripcion' : $scope.referencia.ref.descripcionItem
        };
      }
      referencia['prebru'] = $scope.referencia.prebru == undefined ? '' : $scope.referencia.prebru;
      referencia['presug'] = $scope.referencia.presug == undefined ? '' : $scope.referencia.presug;

      $scope.referencias.push(referencia);
      $scope.referencia = {};
      $scope.solicitudForm.$setPristine();
    }
  }

  $scope.saveSolicitud = function(){
    $scope.progress = true;
    $scope.solicitud.inicio = angular.copy(new Date($scope.solicitud.fecini).toDateString());
    $scope.solicitud.fin = angular.copy(new Date($scope.solicitud.fecfin).toDateString());
    $scope.solicitud.referencias = angular.copy($scope.referencias);

    $http.post($scope.url, $scope.solicitud).then(function(response){
      $scope.progress = false;
      $window.location = response.data;
    }, function(){});
  }

  $scope.read = function (workbook){

    var headerNames = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]], { header: 1 })[0];
  	var data = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]]);

    $scope.archivo = data;
console.log($scope.archivo);
    $http.post($scope.urlRef, $scope.archivo).then(function(response){
      var datos = response.data;

      angular.forEach(angular.copy(datos), function(value, key){
        $scope.datos = value;
        angular.forEach(angular.copy($scope.datos), function(value2, key2){
          $scope.ref = value2;

        var referencia = {
              'referencia' : $scope.ref.informacionPrecio.referencia,
              'descripcion' : $scope.ref.informacionPrecio.descripcion,
              'prebru' : $scope.ref.informacionPrecio.precio,
              'presug' : $scope.ref.presug
            }

        $scope.referencias.push(referencia);
        $scope.referencia = {};

        });
      });
    });
  }

}]);
