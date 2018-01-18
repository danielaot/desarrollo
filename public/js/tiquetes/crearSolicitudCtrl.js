app.controller('crearSolicitudCtrl', ['$scope', '$filter', '$http', '$mdDialog', function( $scope, $filter, $http, $mdDialog){

  $scope.getUrl = 'solicitudinfo';
  $scope.getUrlSoloPaises = 'paisesInfo';
  $scope.progress = true;
  $scope.url = 'solicitud';
  $scope.detallesol = [];
  $scope.detallesolInt = [];
  $scope.paises = undefined;
  $scope.getUrlSolicitudes = 'solicitudes';

  $http.get($scope.getUrl).then(function(response){
    var info = response.data;
    $scope.persona = angular.copy(info.persona);
    $scope.ciudad = angular.copy(info.ciudad);
    $scope.progress = false;
  });

  $http.get($scope.getUrlSoloPaises).then(function(response){
    var info = response.data;
    $scope.paises = angular.copy(info.paises);
    $scope.progress = false;
  });

  $scope.solicitudes =  function(){
    $http.get($scope.getUrlSolicitudes).then(function(response){
      var info = response.data;
      $scope.solicitudes = angular.copy(info);
    });
  }

  $scope.validarTipoViajeCargarData = function(){
    if ($scope.solicitud.tviaje == 2 && $scope.paises == undefined) {
      $scope.progress = true;
    }
  }


  $scope.nombreSearch = function(query){
    var filter = [];
    filter = $filter('filter')($scope.persona, {infopersona:{perTxtNomtercero : query}});
    return filter;
  }

  // $scope.aprobadorSearch = function(query){
  //   var filter = [];
  //   filter = $filter('filter')($scope.persona, {aprueba:{perTxtNomtercero : query}});
  //   return filter;
  // }

  $scope.paisoriSearch = function(query){
    var filter = [];
    filter =  $filter('filter')($scope.paises, {Pais : query});
    return filter;
  }

  $scope.ciupaisoriSearch = function(query){
      var filter = [];
      filter = $filter('filter')($scope.solicitud.detsoliInt.porigen.ciudades, {Ciudad : query});
      return filter;
  }

  $scope.paisdestSearch = function(query){
    var filter = [];
    filter = $filter('filter')($scope.paises, {Pais : query});
    return filter;
  }

  $scope.ciupaisdestSearch = function(query){
      var filter = [];
      filter = $filter('filter')($scope.solicitud.detsoliInt.pdestino.ciudades, {Ciudad : query});
      return filter;
  }

  $scope.AgregarTramo = function(detsoli){
    $scope.detsoli = detsoli;

    var viaje = {
      idorigen : $scope.detsoli.origen.ciuIntId,
      origen : $scope.detsoli.origen.ciuTxtNom,
      destino : $scope.detsoli.destino.ciuTxtNom,
      iddestino : $scope.detsoli.destino.ciuIntId,
      fviaje : $scope.detsoli.fviaje,
      hotel : $scope.detsoli.hotel,
      nodias : $scope.detsoli.nodias
    };
    $scope.detallesol.push(viaje);
    $scope.solicitud.detalleNac = $scope.detallesol;

  }

  $scope.AgregarTramoInternacional = function(detsoliInt){
    $scope.detsoliInt = detsoliInt;

    var viaje = {
      porigen : $scope.detsoliInt.porigen.Pais,
      ciuorigen : $scope.detsoliInt.ciuorigen.Ciudad,
      pdestino : $scope.detsoliInt.pdestino.Pais,
      ciudestino : $scope.detsoliInt.ciudestino.Ciudad,
      fviaje : $scope.detsoliInt.fviaje,
      hotel : $scope.detsoliInt.hotel,
      nodias : $scope.detsoliInt.nodias
    };
    $scope.detallesolInt.push(viaje);
    $scope.solicitud.detalleInt = $scope.detallesolInt;
  }

  $scope.QuitarTramo = function(detalle){
    var confirm = $mdDialog.confirm()
      .title('')
      .textContent('Desea eliminar este tramo?')
      .ariaLabel('detalle')
      .ok('Eliminar')
      .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      if (detalle) {
        for(var x in $scope.detallesol){
                var det = $scope.detallesol[x];
                if(det['dtaIntid'] == detalle.dtaIntid){
                    $scope.detallesol.splice(x, 1);
              }
          }
      }
    });
  }

  $scope.QuitarTramoInt = function(detalleInt){
    var confirm = $mdDialog.confirm()
      .title('')
      .textContent('Desea eliminar este tramo?')
      .ariaLabel('detalleInt')
      .ok('Eliminar')
      .cancel('Cancelar');

    $mdDialog.show(confirm).then(function(){
      if (detalleInt) {
        for(var x in $scope.detallesolInt){
            var det = $scope.detallesolInt[x];
              if(det['dtaIntid'] == detalleInt.dtaIntid){
                 $scope.detallesolInt.splice(x, 1);
              }
        }
      }
    });
  }

  $scope.infoCompleta = function(soli){
    $scope.infoSolicitud = soli;
    console.log(soli);
    $scope.solicitud.solAnterior = angular.copy($scope.infoSolicitud.solIntSolId);
    $scope.solicitud.nombre = angular.copy($scope.infoSolicitud.solTxtNomtercero);
    //$scope.solicitud.nombre.infopersona.perTxtCedtercero = angular.copy($scope.infoSolicitud.solTxtCedtercero);
    // $scope.solicitud.nombre.infopersona.perTxtEmailter = angular.copy($scope.infoSolicitud.solTxtEmail);
    // $scope.solicitud.nombre.infopersona.perTxtFechaNac = angular.copy($scope.infoSolicitud.perTxtFechaNac);
     $scope.solicitud.numtelefono = parseInt($scope.infoSolicitud.solTxtNumTelefono);

    //$scope.solicitud.aprobador = angular.copy($scope.infoSolicitud.solTxtNumTelefono);

    if ($scope.infoSolicitud.solTxtPerExterna == 1) {
      $scope.solicitud.tviajero = "1";
    }else if ($scope.infoSolicitud.solTxtPerExterna == 2) {
      $scope.solicitud.tviajero = "2";
      $scope.solicitud.ccexterno = parseInt($scope.infoSolicitud.per_externa.pereTxtCedula);
      //$scope.solicitud.fnacimientoext = angular.copy($scope.infoSolicitud.per_externa.pereTxtFNacimiento);
      $scope.solicitud.numcelexter = parseInt($scope.infoSolicitud.per_externa.pereTxtNumCelular);
      $scope.solicitud.nomexterno = angular.copy($scope.infoSolicitud.per_externa.pereTxtNombComple);
      $scope.solicitud.corexterno = angular.copy($scope.infoSolicitud.per_externa.pereTxtEmail);
    }

    if ($scope.infoSolicitud.solIntTiposolicitud == 1) {
      $scope.solicitud.tviaje = "1";
    }else if ($scope.infoSolicitud.solIntTiposolicitud == 2) {
      $scope.solicitud.tviaje = "2";
    }

    $scope.solicitud.motivo = angular.copy($scope.infoSolicitud.solTxtObservacion);

    angular.forEach($scope.infoSolicitud.detalle, function(value, key){
      console.log(value);
      $scope.det = value;
      $scope.solicitud.detsoli = angular.copy($scope.det.dtaIntOCiu);
      console.log($scope.solicitud.detsoli);
    });
    // $scope.solicitud.detsoli.hotel = angular.copy($scope.infoSolicitud.solTxtNumTelefono);
    // $scope.solicitud.aprobador = angular.copy($scope.infoSolicitud.solTxtNumTelefono);
    // $scope.solicitud.aprobador = angular.copy($scope.infoSolicitud.solTxtNumTelefono);
    // $scope.solicitud.aprobador = angular.copy($scope.infoSolicitud.solTxtNumTelefono);
    // $scope.solicitud.aprobador = angular.copy($scope.infoSolicitud.solTxtNumTelefono);
  }

  $scope.saveSolicitud = function(){
    $http.post($scope.url, $scope.solicitud).then(function(response){

    });
  }
}]);
