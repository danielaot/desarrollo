app.controller('crearSolicitudCtrl', ['$scope', '$filter', '$http', '$mdDialog', function( $scope, $filter, $http, $mdDialog){

  $scope.getUrl = 'solicitudinfo';
  $scope.getUrlSoloPaises = 'paisesInfo';
  $scope.progress = true;
  $scope.url = 'solicitud';
  $scope.enviaAprobarUrl = 'solicitud/enviaAprobar';
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
    filter = $filter('filter')($scope.persona, {pen_nombre : query});
    return filter;
  }

  $scope.onChangeGrupo = function(){
  $scope.deshabilitarSelectCanal = false;
  if($scope.solicitud.grupoaprobacion != undefined && $scope.solicitud.grupoaprobacion.canales != undefined){
    $scope.canalesAprobacion = $scope.solicitud.grupoaprobacion.canales;
    if($scope.canalesAprobacion.length == 1){
      $scope.solicitud.canalaprobacion = $scope.canalesAprobacion[0];
      $scope.deshabilitarSelectCanal = true;
    }
  }
}

  $scope.onChangeTerritorio = function(){
    $scope.deshabilitarSelectCanal = false;
    if($scope.solicitud.territorioaprobacion != undefined && $scope.solicitud.territorioaprobacion.canales != undefined){
      $scope.canalesAprobacion = $scope.solicitud.territorioaprobacion.canales;
      if($scope.canalesAprobacion.length == 1){
        $scope.solicitud.canalaprobacion = $scope.canalesAprobacion[0];
        $scope.deshabilitarSelectCanal = true;
      }
    }
  }

  $scope.onBeneficiarioChange = function(){

    $scope.setEmptyInfoCanales();

    if($scope.solicitud.nombre != undefined){
      $scope.aprobador = $filter('filter')($scope.solicitud.nombre.detalle, {perdepPerIntCedPerNivel :  $scope.solicitud.nombre.pen_cedula});
      $scope.apro = $scope.aprobador[0].aprobador;

      if($scope.solicitud.nombre.pen_idtipoper == 4 || $scope.solicitud.nombre.pen_idtipoper == 3){
          $scope.solicitud.nombre.grupos = _.pluck($scope.solicitud.nombre.detalle,'grupo');
          $scope.solicitud.nombre.grupos = _.uniq($scope.solicitud.nombre.grupos, 'id');

          if($scope.solicitud.nombre.pen_nomnivel == 2){
            $scope.solicitud.nombre.grupos.map(function(grupo){
              grupo.canales = $filter('filter')($scope.solicitud.nombre.detalle,{perdepIntGrupo : grupo.id});
                        grupo.canales = _.pluck(grupo.canales,'canal');
                        return grupo;
            });
        }else{
          $scope.canalesAprobacion = $scope.canales;
        }

        $scope.mostrarSelectGrupo = true;
        $scope.mostrarSelectCanal = true;

      }else if($scope.solicitud.nombre.pen_idtipoper == 2 || $scope.solicitud.nombre.pen_idtipoper == 1){

        if($scope.solicitud.nombre.pen_idtipoper == 2){

          $scope.solicitud.nombre.territorios = _.pluck($scope.solicitud.nombre.detalle, 'territorio');
          $scope.solicitud.nombre.territorios = _.uniq($scope.solicitud.nombre.territorios, 'id');

          $scope.solicitud.nombre.territorios.map(function(territorio){
            territorio.canales = $filter('filter')($scope.solicitud.nombre.detalle,{perdepIntTerritorio : territorio.id});
                      territorio.canales = _.pluck(territorio.canales,'canal');
                      return territorio;
          });

          $scope.mostrarSelectTerritorio = true;
          $scope.mostrarSelectCanal = true;

        }else{
          $scope.solicitud.nombre.canales = _.pluck($scope.solicitud.nombre.detalle, 'canal');
          $scope.canalesAprobacion = $scope.solicitud.nombre.canales;
          $scope.mostrarSelectCanal = true;
          if($scope.canalesAprobacion.length == 1){
            $scope.solicitud.canalaprobacion = $scope.canalesAprobacion[0];
            $scope.deshabilitarSelectCanal = true;
          }
        }

      }else if($scope.solicitud.nombre.pen_idtipoper == 5){

        $scope.setEmptyInfoCanales();
      }else{
        $scope.setEmptyInfoCanales();
      }
    }
  }

  $scope.setEmptyInfoCanales = function(){
		$scope.canalesAprobacion = [];
		$scope.mostrarSelectCanal = false;
		$scope.mostrarSelectTerritorio = false;
		$scope.mostrarSelectGrupo = false;
		$scope.solicitud.canalaprobacion = undefined;
		$scope.solicitud.grupoaprobacion = undefined;
		$scope.solicitud.territorioaprobacion = undefined;
		$scope.deshabilitarSelectCanal = false;
	}

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
    $scope.solicitud.detsoli = {};
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
    $scope.solicitud.detsoliInt = {};
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

  $scope.validarFecha = function(fecha){
    console.log("---->");
    console.log(fecha);
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

  $scope.saveSolicitud = function(isCreating){
    $scope.progress = true;
    if (isCreating == true) {
      $http.post($scope.url, $scope.solicitud).then(function(response){
        console.log("-->");
      //  $scope.getInfo();
        $scope.progress = false;
      });
    }else {
      $http.post($scope.enviaAprobarUrl+"/"+isCreating, $scope.solicitud).then(function(response){
        console.log("-->2");
        $scope.progress = false;
      });
    }
  }




}]);
