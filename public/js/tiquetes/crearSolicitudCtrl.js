app.controller('crearSolicitudCtrl', ['$scope', '$filter', '$http', '$mdDialog', '$window', function( $scope, $filter, $http, $mdDialog, $window){

  $scope.getUrl = 'solicitudinfo';
  $scope.getUrlSoloPaises = 'paisesInfo';
  $scope.progress = true;
  $scope.url = 'solicitudTiquetes';
  $scope.enviaAprobarUrl = 'solicitudTiquetes/enviaAprobar';
  $scope.urlEditar = '../editarSoli';
  $scope.enviaEditAprobarUrl = '../editarSoli/enviaEditAprobar';
  $scope.detallesol = [];
  $scope.detallesolInt = [];
  $scope.paises = undefined;
  $scope.getUrlSolicitudes = 'solicitudes';
  $scope.solicitud = {'detsoli' : {}, 'detsoliInt' : {}};
  $scope.hotel = [{value: 'S' , key : 'Si'},{value: 'N', key: 'No'}];
  $scope.solicitud.detsoli.hotel = $scope.hotel[1];
  $scope.solicitud.detsoliInt.hotel = $scope.hotel[1];
  $scope.solicitudes;

  $scope.getInfo = function(){

    if ($scope.solicitudes !== undefined ) {
      $scope.getUrl = '../solicitudinfo';
      //$scope.getUrlSoloPaises = '../paisesInfo';
      $scope.urlEditar = '../editarSoli';
      $scope.enviaEditAprobarUrl = '../editarSoli/enviaEditAprobar';
    }

    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.persona = angular.copy(info.persona);
      $scope.ciudad = angular.copy(info.ciudad);
      $scope.canales =  angular.copy(info.canales);
      $scope.fechahoy = angular.copy(info.fechahoy.date);
      var today = new Date();
      $scope.today = today.toISOString();

      $scope.fechavalidacion = angular.copy(info.fechavalidacion.date)
      $scope.progress = false;

      if ($scope.solicitudes !== undefined) {
          $scope.solicitud = {};
          $scope.detsoli = {};
          $scope.detsoliInt = {};

          $scope.solicitud.nombre = $filter('filter')($scope.persona, {pen_cedula : $scope.solicitudes[0].pen_cedula})[0];

          $scope.solicitud.solAnterior = angular.copy($scope.solicitudes[0].solTxtSolAnterior);

          if ($scope.solicitudes[0].solIntTiposolicitud == 1) {
            $scope.solicitud.tipo = "1";
          }else if ($scope.solicitudes[0].solIntTiposolicitud == 2) {
            $scope.solicitud.tipo = "2";
          }

          $scope.solicitud.numtelefono = parseInt($scope.solicitudes[0].solTxtNumTelefono);

          if ($scope.solicitudes[0].solTxtPerExterna == 1) {
            $scope.solicitud.tviajero = "1";
          }else if ($scope.solicitudes[0].solTxtPerExterna == 2) {
            $scope.solicitud.tviajero = "2";
            $scope.solicitud.ccexterno = parseInt($scope.solicitudes[0].per_externa.pereTxtCedula);
            //$scope.solicitud.fnacimientoext = angular.copy($scope.solicitudes[0].per_externa.pereTxtFNacimiento);
            $scope.solicitud.numcelexter = parseInt($scope.solicitudes[0].per_externa.pereTxtNumCelular);
            $scope.solicitud.nomexterno = angular.copy($scope.solicitudes[0].per_externa.pereTxtNombComple);
            $scope.solicitud.corexterno = angular.copy($scope.solicitudes[0].per_externa.pereTxtEmail);
          }

          if ($scope.solicitudes[0].solIntTiposolicitud == 1) {
            $scope.solicitud.tviaje = "1";
          }else if ($scope.solicitudes[0].solIntTiposolicitud == 2) {
            $scope.solicitud.tviaje = "2";
          }

          $scope.solicitud.aprobador = $filter('filter')($scope.solicitud.nombre.detalle, {perdepPerIntCedPerNivel :  $scope.solicitud.nombre.pen_cedula})[0];

          $scope.solicitud.motivo = angular.copy($scope.solicitudes[0].solTxtObservacion);

          $scope.solicitud.idSolicitud = $scope.solicitudes[0].solIntSolId;

          if ($scope.solicitudes[0].solIntTiposolicitud == 1) {

            angular.forEach($scope.solicitudes[0].detalle, function(value, key){

              $scope.value = value;
              var viaje = {
                idorigen : $scope.value.dtaIntOCiu,
                origen : $scope.value.ciu_origen.ciuTxtNom,
                destino : $scope.value.ciu_destino.ciuTxtNom,
                iddestino : $scope.value.dtaIntDCiu,
                fviaje : $scope.value.dtaIntFechaVuelo,
                hotel : $scope.value.dtaTxtHotel,
                dtaIntid : $scope.value.dtaIntid
              };

              if ($scope.detsoli != undefined) {
                $scope.detallesol.push(viaje);
                $scope.solicitud.detalleNac = $scope.detallesol;
              }
            });
          }

        $scope.solicitud.canalaprobacion = angular.copy($scope.solicitudes[0].canal);

        }
    });
  }

  $scope.getInfoPaises = function(){

     if ($scope.solicitudes !== undefined ) {
          $scope.getUrl = '../solicitudinfo';
          $scope.getUrlSoloPaises = '../paisesInfo';
          $scope.urlEditar = '../editarSoli';
     }

    $http.get($scope.getUrlSoloPaises).then(function(response){
      var info = response.data;
      $scope.paises = angular.copy(info.paises);
      $scope.progress = false;
    });

    if ($scope.solicitudes !== undefined) {
        $scope.detsoliInt = {};

      if ($scope.solicitudes[0].solIntTiposolicitud == 2) {

          angular.forEach($scope.solicitudes[0].detalle, function(value, key){
            $scope.value = value;
            console.log($scope.value);
            var viaje = {
              porigen : $scope.value.ciu_int_origen.porigen.Pais,
              ciuorigen : $scope.value.dtaTxtOCiu,
              pdestino : $scope.value.ciu_int_destino.pdestino.Pais,
              ciudestino : $scope.value.dtaTxtDCiudad,
              fviaje : $scope.value.dtaIntFechaVuelo,
              hotel : $scope.value.dtaTxtHotel,
            };

            if ($scope.detsoliInt != undefined) {
              $scope.detallesolInt.push(viaje);
            //  $scope.solicitud.detalleInt = $scope.detallesolInt;
            }
          });
      }

    }
  }

  $scope.solicitudesMod =  function(){
    $http.get($scope.getUrlSolicitudes).then(function(response){
      var info = response.data;
      $scope.solicitudesAnt = angular.copy(info);
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

      $scope.aprobador = $filter('filter')($scope.solicitud.nombre.detpersona.detallenivelpersona, {perdepIntCanal : $scope.solicitud.canalaprobacion.can_id});
      console.log($scope.aprobador);
    }
  }

  $scope.onBeneficiarioChange = function(){

    $scope.setEmptyInfoCanales();

    if($scope.solicitud.nombre != undefined){

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

          $scope.aprobador = $filter('filter')($scope.solicitud.nombre.detpersona.detallenivelpersona, {perdepIntCanal : $scope.solicitud.canalaprobacion.can_id});
        }

      }else if($scope.solicitud.nombre.pen_idtipoper == 5){

        $scope.setEmptyInfoCanales();
      }else{
        $scope.setEmptyInfoCanales();
      }
    }

  }

  $scope.seleccionaAprobador = function(){

    if ($scope.solicitud.nombre.pen_idtipoper == '1') {
      $scope.aprobador = $filter('filter')($scope.solicitud.nombre.detpersona.detallenivelpersona, {perdepIntCanal : $scope.solicitud.canalaprobacion.can_id});
    }else if ($scope.solicitud.nombre.pen_idtipoper == '3' || $scope.solicitud.pen_idtipoper == '4') {

        $scope.aprobador = $scope.solicitud.grupoaprobacion.gru_responsable;

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

    $scope.fechaNormal = $filter('date')(new Date($scope.solicitud.detsoli.fviaje), 'yyyy-MM-dd HH:mm:ss');

    var viaje = {
      idorigen : $scope.detsoli.origen.ciuIntId,
      origen : $scope.detsoli.origen.ciuTxtNom,
      destino : $scope.detsoli.destino.ciuTxtNom,
      iddestino : $scope.detsoli.destino.ciuIntId,
      fviaje : $scope.fechaNormal,
      hotel : $scope.detsoli.hotel.value,
      nodias : $scope.detsoli.nodias
    };
    $scope.detallesol.push(viaje);
    $scope.solicitud.detalleNac = $scope.detallesol;
    $scope.solicitud.detsoli = {};
    $scope.detsoli = {};
  }

  $scope.AgregarTramoInternacional = function(detsoliInt){
    $scope.detsoliInt = detsoliInt;

    $scope.fechaNormal = $filter('date')(new Date($scope.solicitud.detsoliInt.fviaje), 'yyyy-MM-dd HH:mm:ss');

    var viaje = {
      porigen : $scope.detsoliInt.porigen.Pais,
      ciuorigen : $scope.detsoliInt.ciuorigen.Ciudad,
      pdestino : $scope.detsoliInt.pdestino.Pais,
      ciudestino : $scope.detsoliInt.ciudestino.Ciudad,
      fviaje : $scope.fechaNormal,
      hotel : $scope.detsoliInt.hotel.value,
      nodias : $scope.detsoliInt.nodias
    };
    $scope.detallesolInt.push(viaje);
    $scope.solicitud.detalleInt = $scope.detallesolInt;
    $scope.solicitud.detsoliInt = {};
    $scope.detalleInt = {};
  }

  $scope.QuitarTramo = function(detalle){
    console.log(detalle);
    var confirm = $mdDialog.confirm()
      .title('Alerta')
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
      .title('Alerta')
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
    console.log($scope.solicitud.detsoli);
    $scope.fechaSolicitud = $filter('date')(new Date($scope.solicitud.detsoli.fviaje), 'yyyy-MM-dd');
    $scope.fechahoyVal = $filter('date')(new Date($scope.fechahoy), 'yyyy-MM-dd');
    $scope.fechaminVal = $filter('date')(new Date($scope.fechavalidacion), 'yyyy-MM-dd');

    if ($scope.fechaSolicitud == $scope.fechahoyVal || $scope.fechaSolicitud > $scope.fechahoyVal && $scope.fechaSolicitud < $scope.fechaminVal) {

          var confirm = $mdDialog.prompt()
            .title('Motivo Viaje')
            .textContent('Por favor indique el motivo por el cual la solicitud del viaje es menor de 12 días')
            .placeholder('')
            .ariaLabel('fecha')
            .ok('Aceptar')
            .cancel('Cancelar');

          $mdDialog.show(confirm).then(function(result) {
            $scope.solicitud.motivoViaje = result;
          });

      }
  }

  $scope.infoCompleta = function(soli){
    $scope.infoSolicitud = soli;
    $scope.solicitud.solAnterior = angular.copy($scope.infoSolicitud.solIntSolId);
    $scope.solicitud.nombre = $filter('filter')($scope.persona, {pen_cedula : $scope.infoSolicitud.solTxtCedtercero})[0];
    $scope.solicitud.numtelefono = parseInt($scope.infoSolicitud.solTxtNumTelefono);
    //$scope.solicitud.aprobador = $filter('filter')($scope.aprobador, {nivaprobador : {pen_cedula : $scope.infoSolicitud.per_autoriza.aprueba.perTxtCedtercero}});


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

    if ($scope.infoSolicitud.solIntTiposolicitud == 1) {
      angular.forEach($scope.infoSolicitud.detalle, function(value, key){

        $scope.value = value;
        var viaje = {
          idorigen : $scope.value.dtaIntOCiu,
          origen : $scope.value.ciu_origen.ciuTxtNom,
          destino : $scope.value.ciu_destino.ciuTxtNom,
          iddestino : $scope.value.dtaIntDCiu,
          fviaje : $scope.value.dtaIntFechaVuelo,
          hotel : $scope.value.dtaTxtHotel
        };

        if ($scope.detsoli != undefined) {
          $scope.detallesol.push(viaje);
          $scope.solicitud.detalleNac = $scope.detallesol;
        }
      });
    }else {
      angular.forEach($scope.infoSolicitud.detalle, function(value, key){

        $scope.value = value;
        var viaje = {
          porigen : $scope.value.ciu_int_origen.porigen.Pais,
          ciuorigen : $scope.value.dtaTxtOCiu,
          pdestino : $scope.value.ciu_int_destino.pdestino.Pais,
          ciudestino : $scope.value.dtaTxtDCiudad,
          fviaje : $scope.value.dtaIntFechaVuelo,
          hotel : $scope.value.dtaTxtHotel,
        };
        $scope.detallesolInt.push(viaje);
        $scope.solicitud.detalleInt = $scope.detallesolInt;
      });
    }

  }

  $scope.saveSolicitud = function(isCreating){

    console.log($scope.solicitud);

    if ($scope.solicitud.detalleNac === undefined && $scope.solicitud.detalleInt === undefined) {

      var confirm = $mdDialog.confirm()
        .title('Alerta')
        .textContent('Debe ingresar la ruta de viaje')
        .ariaLabel('detalle')
        .ok('Ok')
        .cancel('Cancelar');

        $mdDialog.show(confirm).then(function(){

        });
    }else {

        $scope.progress = true;

        if (isCreating == true) {

          $http.post($scope.url, $scope.solicitud).then(function(response){
             $scope.progress = true;
             $window.location = response.data.respuestaCreacion.rutaMisSolicitudes;
          });
        }else {
          $http.post($scope.enviaAprobarUrl+"/"+isCreating, $scope.solicitud).then(function(response){
            console.log("-->2");
            $scope.progress = false;

            var respuesta = response.data.rutaAprobacion.respuestaAutorizacion;
            var titulo = respuesta.isSuccess == true ? 'Exito!' : 'Error!';
            var mensaje = respuesta.message;
            var alerta = $mdDialog.alert()
            .parent(angular.element(document.querySelector('#popupContainer')))
            .clickOutsideToClose(false)
            .title(titulo)
            .textContent(mensaje)
            .ariaLabel('Alert Dialog Demo')
            .ok('Ok')

            $mdDialog.show(alerta).then(function(){
              $scope.progress = true;
              $window.location = response.data.respuestaCreacion.rutaMisSolicitudes;
            });
          });
        }
    }

  }

  $scope.editarSolicitud = function(isCreating){

    if (isCreating == true) {
      $http.post($scope.urlEditar, $scope.solicitud).then(function(response){

        $scope.progress = true;
        $window.location = response.data.respuestaCreacion.rutaMisSolicitudes;
        
      });
    }else {

      $http.post($scope.enviaEditAprobarUrl+"/"+isCreating, $scope.solicitud).then(function(response){
          $scope.getInfo();
          $scope.progress = false;

          var respuesta = response.data.rutaAprobacion.respuestaAutorizacion;
          var titulo = respuesta.isSuccess == true ? 'Exito!' : 'Error!';
          var mensaje = respuesta.message;
          var alerta = $mdDialog.alert()
            .parent(angular.element(document.querySelector('#popupContainer')))
            .clickOutsideToClose(false)
            .title(titulo)
            .textContent(mensaje)
            .ariaLabel('Alert Dialog Demo')
            .ok('Ok')

            $mdDialog.show(alerta).then(function(){
                $scope.progress = true;
                $window.location = respuesta.rutaMisSolicitudes;
          });
      });
    }

  /*  console.log(isCreating);
    console.log($scope.solicitud);

      $http.post($scope.urlEditar, $scope.solicitud).then(function(response){
        var data = response.data;
      });
    // }else {
    //   $http.post($scope.enviaEditAprobar+"/"+isCreating, $scope.solicitud).then(function(response){
    //     console.log("-->2");
    //   });
    // }*/
  }



}]);
