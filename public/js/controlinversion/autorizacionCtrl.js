app.controller('autorizacionCtrl',
['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder',
function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder){


  $scope.urlGetInfo  = './aprobacionGetInfo';
  $scope.url  = 'aprobacion';
  $scope.zonasSolicitud = [];
  $scope.lineasSolicitud = [];
  $scope.solicitudes = {};


	$scope.getInfo = function(){
    $scope.progress = true;

    $http.get($scope.urlGetInfo).then(function(response){
      var res = response.data;
      $scope.usuarioLogeado = angular.copy(res.userLogged);
      $scope.solicitudes = angular.copy(res.solicitudesPorAceptar);
      console.log($scope.solicitudes);

      $scope.solicitudes.forEach(function(solicitud) {

          var fecha_ini = new Date(solicitud.solicitud.sci_fecha);
          fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
          solicitud.solicitud.sci_fecha = new Date(fecha_ini);

          solicitud.solicitud.historico.map(function(hist){

            var fecha_hist = new Date(hist.soh_fechaenvio);
            fecha_hist = fecha_hist.getTime() + fecha_hist.getTimezoneOffset()*60*1000;
            hist.soh_fechaenvio = new Date(fecha_hist);
            return hist;

          });

          //return solicitud;

      }, this);

      $scope.estados = angular.copy(res.estados);
      $scope.progress= false;
    }, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
  }

  $scope.getInfo();

  $scope.setSolicitud = function(solicitud, boton = 0){

    if (boton == 0) {

      $scope.solicitud = solicitud;

      if($scope.solicitud.sci_tipopersona == 1){

        solicitud.clientes.forEach(function(cliente){
          if($scope.zonasSolicitud.length == 0){
            $scope.zonasSolicitud.push(cliente.clientes_zonas);
          }else{
            var filterZonas = $filter('filter')($scope.zonasSolicitud, {scz_zon_id: cliente.clientes_zonas.scz_zon_id});
            if(filterZonas.length == 0){
              $scope.zonasSolicitud.push(cliente.clientes_zonas);
            }else if(filterZonas[0].scz_zon_id != cliente.clientes_zonas.scz_zon_id){
              $scope.zonasSolicitud.push(cliente.cliente_zonas);
            }
          }
        })
      }


        if(solicitud.clientes.length > 0){

          solicitud.clientes.forEach(function(cliente){

            cliente.clientes_referencias.forEach(function(referencia){
              console.log($scope.lineasSolicitud);

              if($scope.lineasSolicitud.length == 0){
                $scope.lineasSolicitud.push(referencia);
              }else{

                var filterLineas = $filter('filter')($scope.lineasSolicitud, {linea_producto : {lcc_codigo: referencia.linea_producto.lcc_codigo}});

                if(filterLineas.length == 0){
                  $scope.lineasSolicitud.push(referencia);
                }else if(filterLineas[0].linea_producto.lcc_codigo != referencia.linea_producto.lcc_codigo){
									$scope.lineasSolicitud.push(referencia);
								}
              }
            });
          });
        }

    }else if(boton == 1){
      $scope.solicitud = solicitud;
    }

  }

  $scope.enviarAprobacion = function(){
    $scope.progress = true;
    console.log($scope.solicitud);
    $scope.solicitud.usuarioLogeado = $scope.usuarioLogeado;
    $http.post($scope.url, $scope.solicitud).then(function(response){
      var data = response.data;
      console.log('Respuesta:');
      if (data == 'errorNoExisteNivelTres') {
        // Muestro mensaje de error
        $scope.progress = false;
        alert("No se encuentra ninguna persona para realizar la aprobacion en niveles de autorizacion");
      }else{
        $window.location.reload();
      }
    }, function(errorResponse){

    });
  }






}]);
