app.controller('pedidosAgrupaCtrl', ['$scope', '$http', '$filter', '$element', '$mdDialog', function ($scope, $http, $filter, $element, $mdDialog) {
  $scope.urlGetInfo = "agrupaPedidosGetInfo";
  $scope.urlResource = "tccws";
  $scope.urlPlano = "obtenerPlano";
  $scope.urlUnidades = "unidadesLogisticas";
  $scope.urlExcluir = "excluirDocumentos";
  $scope.progress = true;
  $scope.sucursal = {};
  $scope.sucursalesArray = {};
  $scope.sucursalSelected = {};
  $scope.puedeEnviar = false;
  $scope.cantidadCajas = 0;
  $scope.cantidadLios = 0;
  $scope.cantidadPaletas = 0;
  $scope.kilosRealesLios = 0;
  $scope.kilosRealesEstibas = 0;
  $scope.kilosBaseLios = 30;
  $scope.sumaTotalKilos = 0;
  $scope.isError = false;
  $scope.pesosNoValidos = false;
  $scope.searchCliente;
  $scope.searchSucursal;


  $scope.getInfo = function(){
    $http.get($scope.urlGetInfo).then(function(response){
      data = response.data;
      $scope.agrupoCliente = angular.copy(data.agrupoCliente);
      $scope.terceros = angular.copy(data.terceros);
      $scope.terceros = $filter('orderBy')($scope.terceros,'razonSocialTercero');
      $scope.sucursales = angular.copy(data.sucursales);
      $scope.progress = false;
    }, function(errorResponse){
      $scope.getInfo();
    });
  }

  $scope.clearSearchTerm = function() {
   $scope.searchCliente = '';
  }

  $element.find('.input').on('keydown', function(ev) {
    ev.stopPropagation();
  });

  $scope.searchClienteTxt = function(searchCliente){
    var filter =[];
    if(searchCliente){
      filter = $filter('filter')($scope.terceros, {razonSocialTercero: searchCliente});
    }

    if(filter.length > 0){
      return filter;  
    }else{
      return $scope.terceros;
    }
    
  }

  $scope.getInfo();


  $scope.getSucursales = function(searchSucursal){
    if ($scope.cliente == undefined) {
      return [];
    }else{
      var filter = $filter('filter')($scope.sucursales, {nit_tercero : $scope.cliente.idTercero});
      filter = $filter('orderBy')(filter,'nombre');
      var filterTerm = $filter('filter')(filter,{nombre: searchSucursal});
      if(filterTerm.length > 0){
        return filterTerm;
      }else{
        return filter;
      }
    }
  }

  $scope.removeSucursal = function (sucursal) {
  var index = $scope.cliente.arregloFinal.sucursalesFiltradas.indexOf(sucursal);
  $scope.cliente.arregloFinal.sucursalesFiltradas.splice(index, 1);
  $scope.cantidadesNoValidas();
  };

  $scope.setSelectAllFacts = function(sucursal){
    $scope.sucursalSelected = sucursal;
    if(sucursal.facturas.length > 0){
      sucursal.facturas.map(function(factura){
        factura.isSelect = $scope.sucursalSelected.isSelectAll;
        return factura;
      })
      sucursal.hasOneOrMoreSelected = $scope.sucursalSelected.isSelectAll;
    }

    var filterSelected = $filter('filter')(sucursal.facturas, {isSelect : true});
    sucursal.cantSeleccionadas = filterSelected.length;

    var cantSeleccionadas = 0;

    $scope.cliente.sucursales.forEach(function(sucu){
      if(sucu.hasOneOrMoreSelected == true){
          cantSeleccionadas += 1;
      }
    });

    if(cantSeleccionadas > 0){
        $scope.puedeEnviar = true;
    }else{
        $scope.puedeEnviar = false;
    }

  }

  $scope.setSelectedFactura = function(factura,sucursal){


      var filterSelected = $filter('filter')(sucursal.facturas, {isSelect : true});

      if(filterSelected.length == sucursal.facturas.length){
        sucursal.isSelectAll = true;
        sucursal.hasOneOrMoreSelected = true;
        $scope.puedeEnviar = true;
      }else if((filterSelected.length > 0) && (filterSelected.length < sucursal.facturas.length)){
        sucursal.isSelectAll = false;
        sucursal.hasOneOrMoreSelected = true;
        $scope.puedeEnviar = true;
      }else if(filterSelected.length == 0){
        sucursal.hasOneOrMoreSelected = false;
        sucursal.isSelectAll = false;
        $scope.puedeEnviar = false;
      }

      sucursal.cantSeleccionadas = filterSelected.length;

  }

  $scope.onChangeClienteSelected = function(){
    $scope.puedeEnviar = false;
    if($scope.cliente.sucursales != undefined){
      $scope.cliente.sucursales = [];
    }
  }

  $scope.onChangeSucursales = function(){

    if($scope.cliente.sucursales != undefined){
      if($scope.cliente.sucursales.length > 0){

        var sucursal = $scope.cliente.sucursales[$scope.cliente.sucursales.length - 1];
        sucursal.isSelectAll = false;
        sucursal.hasOneOrMoreSelected = false;
        sucursal.cantSeleccionadas = 0;

        if($scope.agrupoCliente[$scope.cliente.idTercero].length > 0){
          var filterFacturas = $filter('filter')($scope.agrupoCliente[$scope.cliente.idTercero], {num_sucursal: sucursal.codigo});

          if(filterFacturas.length > 0){
            filterFacturas.map(function(factura){
              factura.isSelect = false;
              return factura;
            })
          }

          sucursal.facturas = filterFacturas;

        }

      }
    }

  }

  $scope.excluirFacturas = function(){

      var confirm = $mdDialog.confirm()
        .title('¿Realmente desea excluir estas facturas de la agrupacion de remesas?')
        .textContent('Al excluir estas facturas ya no podrán ser visualizadas desde esta vista')
        .ariaLabel('Lucky day')
        .ok('Si, deseo hacerlo')
        .cancel('No, Cancelar');

      $mdDialog.show(confirm).then(function() {

        $scope.cliente.sucursales.map(function(sucursal){
          if (sucursal.hasOneOrMoreSelected == true) {
            var filterSelectRemesas = $filter('filter')(sucursal.facturas, {isSelect : true});
            sucursal.facturasAEnviar = filterSelectRemesas;
          }else{
            sucursal.facturasAEnviar = [];
          }
          return sucursal;
        })

        $scope.progress = true;

        $http.post($scope.urlExcluir, $scope.cliente).then(function(response){
          $scope.cliente = undefined;
          $scope.puedeEnviar = false;
          $scope.getInfo();
        })

      }, function() {

      });
  }

  $scope.retornaListaFiltrada = function(){
    // var lista = $scope.agrupoCliente[$scope.cliente.idTercero];
  }

  $scope.clearSearchTerm = function() {
     $scope.searchTerm = '';
  };

    $scope.getUnidadesLogisticas = function(){

      angular.element('#modal').css('display', 'none');
      $scope.cantidadCajas = 0;
      $scope.cantidadLios = 0;
      $scope.cantidadPaletas = 0;
      $scope.kilosRealesLios = 0;
      $scope.kilosRealesEstibas = 0;
      $scope.sumaTotalKilos = 0;

      if($scope.cliente.arregloFinal != undefined){
        $scope.cliente.arregloFinal = {};
      }

      $scope.cliente.sucursales.map(function(sucursal){
        if (sucursal.hasOneOrMoreSelected == true) {
          var filterSelectRemesas = $filter('filter')(sucursal.facturas, {isSelect : true});
          sucursal.facturasAEnviar = filterSelectRemesas;
        }else{
          sucursal.facturasAEnviar = [];
        }
        return sucursal;
      })


      $scope.progress = true;

      $http.post($scope.urlUnidades, $scope.cliente).then(function(response){
        console.log(response);
        $scope.progress = false;
        $scope.cliente.arregloFinal = angular.copy(response.data);
        angular.element('#modal').css('display', 'block');


        $scope.cliente.arregloFinal.sucursalesFiltradas = $scope.cliente.arregloFinal.sucursalesFiltradas.map(function(sucursal){

          sucursal.kilosRealesEstibas = 0;
          sucursal.kilosRealesLios = 0;
          sucursal.sumaTotalKilos = 0;

          sucursal.objetoCajas = $filter('filter')(sucursal.unidades, {claseempaque: 'CLEM_CAJA'})[0];
          sucursal.objetoLios = $filter('filter')(sucursal.unidades, {claseempaque: 'CLEM_LIO'})[0];
          sucursal.objetoPaletas = $filter('filter')(sucursal.unidades, {claseempaque: 'CLEM_PALET'})[0];

          sucursal = $scope.sumatoriaKilos(sucursal);

          return sucursal;
        })

      });

    }

    $scope.enviarRemesa = function(){
      $scope.progress = true;
      $scope.isError = false;
      $http.post($scope.urlPlano, $scope.cliente.arregloFinal).then(function(response){

        $scope.progress = false;
        console.log(response.data);
        var encabezado = "";
        var filterSuccessTodas = $filter('filter')(response.data.message, {respuesta : "success"});
        var filterErrorLogin = $filter('filter')(response.data.message, {respuesta : "error_acceso"});
        var filterErrorPermisos = $filter('filter')(response.data.message, {respuesta : "error_permisos"});
        var filterErrorCiudad = $filter('filter')(response.data.message, {respuesta : "ciu_error"});
        var filterErrorSucursal = $filter('filter')(response.data.message, {respuesta : "sucu_error"});
        var filterErrorTodas = $filter('filter')(response.data.message, {respuesta : "error_normal"});


      if(filterErrorLogin.length == 0 &&  filterErrorPermisos.length == 0){

          if(filterSuccessTodas.length > 0 && filterErrorTodas.length == 0 && filterErrorCiudad.length == 0 && filterErrorSucursal.length == 0){

            var contOutBoomerang = 0;

            encabezado += "\n<br/><h5><strong>Excelente! </strong> Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5>";
            filterSuccessTodas.forEach(function(respuestaTcc){
              console.log(respuestaTcc);
              if(respuestaTcc.sucursal.tieneBoomerang == true){
                encabezado = $scope.mensajeRemesaBoomerang(encabezado,respuestaTcc);
              }else{

                if(contOutBoomerang == 0){
                  encabezado += "\n\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que no cuenta con el servicio de boomerang.</h5>\n";
                }
                encabezado += "\n<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
                contOutBoomerang ++;
              }
            })            

          }else if(filterSuccessTodas.length == 0 && filterErrorTodas.length > 0 && filterErrorCiudad.length == 0  && filterErrorSucursal.length == 0){
          
            $scope.isError = true;
            encabezado += "\n<br/><h5><strong>Error! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
            filterErrorTodas.forEach(function(respuestaTcc){
              encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
            })

          }else if(filterSuccessTodas.length == 0 && filterErrorTodas.length == 0 && filterErrorCiudad.length > 0  && filterErrorSucursal.length == 0){
            
            $scope.isError = true;
            encabezado += "\n<br/><h5><strong>Error Ciudad Destinatario! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
            filterErrorCiudad.forEach(function(respuestaTcc){
              encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
            })  

          }else if(filterSuccessTodas.length == 0 && filterErrorTodas.length == 0 && filterErrorCiudad.length == 0  && filterErrorSucursal.length > 0){
            
            $scope.isError = true;
            encabezado += "\n<br/><h5><strong>Error Inexistencia de Sucursal! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
            filterErrorSucursal.forEach(function(respuestaTcc){
              encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Codigo de Sucursal:</strong> "+respuestaTcc.sucursal.codigo+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
            })  

          }else if(filterSuccessTodas.length > 0 && filterErrorTodas.length > 0 && filterErrorCiudad.length == 0 && filterErrorSucursal.length == 0){
            
              var contOutBoomerang = 0;

              encabezado += "\n<br/><h5><strong>Excelente! </strong> Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5>";
              filterSuccessTodas.forEach(function(respuestaTcc){
                console.log(respuestaTcc);
                if(respuestaTcc.sucursal.tieneBoomerang == true){
                  encabezado = $scope.mensajeRemesaBoomerang(encabezado,respuestaTcc);
                }else{

                  if(contOutBoomerang == 0){
                    encabezado += "\n\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que no cuenta con el servicio de boomerang.</h5>\n";
                  }
                  encabezado += "\n<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
                  contOutBoomerang ++;
                }
              })            

              encabezado += "<br/><h5><strong>Error! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorTodas.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length > 0 && filterErrorTodas.length == 0 && filterErrorCiudad.length > 0 && filterErrorSucursal.length == 0){
          
              var contOutBoomerang = 0;

              encabezado += "\n<br/><h5><strong>Excelente! </strong> Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5>";
              filterSuccessTodas.forEach(function(respuestaTcc){
                console.log(respuestaTcc);
                if(respuestaTcc.sucursal.tieneBoomerang == true){
                  encabezado = $scope.mensajeRemesaBoomerang(encabezado,respuestaTcc);
                }else{

                  if(contOutBoomerang == 0){
                    encabezado += "\n\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que no cuenta con el servicio de boomerang.</h5>\n";
                  }
                  encabezado += "\n<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
                  contOutBoomerang ++;
                }
              })

              encabezado += "<br/><h5><strong>Error Ciudad Destinatario! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorCiudad.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length > 0 && filterErrorTodas.length == 0 && filterErrorCiudad.length == 0 && filterErrorSucursal.length > 0){
          
              var contOutBoomerang = 0;

              encabezado += "\n<br/><h5><strong>Excelente! </strong> Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5>";
              filterSuccessTodas.forEach(function(respuestaTcc){
                console.log(respuestaTcc);
                if(respuestaTcc.sucursal.tieneBoomerang == true){
                  encabezado = $scope.mensajeRemesaBoomerang(encabezado,respuestaTcc);
                }else{

                  if(contOutBoomerang == 0){
                    encabezado += "\n\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que no cuenta con el servicio de boomerang.</h5>\n";
                  }
                  encabezado += "\n<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
                  contOutBoomerang ++;
                }
              })

              encabezado += "<br/><h5><strong>Error Inexistencia de Sucursal! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorSucursal.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Codigo de Sucursal:</strong> "+respuestaTcc.sucursal.codigo+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length > 0 && filterErrorTodas.length > 0 && filterErrorCiudad.length > 0 && filterErrorSucursal.length == 0){
          
              var contOutBoomerang = 0;

              encabezado += "\n<br/><h5><strong>Excelente! </strong> Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5>";
              filterSuccessTodas.forEach(function(respuestaTcc){
                console.log(respuestaTcc);
                if(respuestaTcc.sucursal.tieneBoomerang == true){
                  encabezado = $scope.mensajeRemesaBoomerang(encabezado,respuestaTcc);
                }else{

                  if(contOutBoomerang == 0){
                    encabezado += "\n\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que no cuenta con el servicio de boomerang.</h5>\n";
                  }
                  encabezado += "\n<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
                  contOutBoomerang ++;
                }
              })

              encabezado += "<br/><h5><strong>Error! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorTodas.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

              encabezado += "<br/><h5><strong>Error Ciudad Destinatario! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorCiudad.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })              

          }else if(filterSuccessTodas.length > 0 && filterErrorTodas.length > 0 && filterErrorCiudad.length == 0 && filterErrorSucursal.length > 0){
          
              var contOutBoomerang = 0;

              encabezado += "\n<br/><h5><strong>Excelente! </strong> Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5>";
              filterSuccessTodas.forEach(function(respuestaTcc){
                console.log(respuestaTcc);
                if(respuestaTcc.sucursal.tieneBoomerang == true){
                  encabezado = $scope.mensajeRemesaBoomerang(encabezado,respuestaTcc);
                }else{

                  if(contOutBoomerang == 0){
                    encabezado += "\n\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que no cuenta con el servicio de boomerang.</h5>\n";
                  }
                  encabezado += "\n<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
                  contOutBoomerang ++;
                }
              })

              encabezado += "<br/><h5><strong>Error! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorTodas.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })              

              encabezado += "<br/><h5><strong>Error Inexistencia de Sucursal! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorSucursal.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Codigo de Sucursal:</strong> "+respuestaTcc.sucursal.codigo+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length > 0 && filterErrorTodas.length == 0 && filterErrorCiudad.length > 0 && filterErrorSucursal.length > 0){
          
              var contOutBoomerang = 0;

              encabezado += "\n<br/><h5><strong>Excelente! </strong> Las facturas de las siguientes sucursales se han enviado correctamente a TCC para su despacho</h5>";
              filterSuccessTodas.forEach(function(respuestaTcc){
                console.log(respuestaTcc);
                if(respuestaTcc.sucursal.tieneBoomerang == true){
                  encabezado = $scope.mensajeRemesaBoomerang(encabezado,respuestaTcc);
                }else{

                  if(contOutBoomerang == 0){
                    encabezado += "\n\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que no cuenta con el servicio de boomerang.</h5>\n";
                  }
                  encabezado += "\n<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
                  contOutBoomerang ++;
                }
              })

              encabezado += "<br/><h5><strong>Error Ciudad Destinatario! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorCiudad.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })              

              encabezado += "<br/><h5><strong>Error Inexistencia de Sucursal! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorSucursal.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Codigo de Sucursal:</strong> "+respuestaTcc.sucursal.codigo+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length == 0 && filterErrorTodas.length > 0 && filterErrorCiudad.length > 0 && filterErrorSucursal.length == 0){
        
              $scope.isError = true;

              encabezado += "<br/><h5><strong>Error! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorTodas.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

              encabezado += "<br/><h5><strong>Error Ciudad Destinatario! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorCiudad.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length == 0 && filterErrorTodas.length > 0 && filterErrorCiudad.length == 0 && filterErrorSucursal.length > 0){
        
              $scope.isError = true;

              encabezado += "<br/><h5><strong>Error! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorTodas.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

              encabezado += "<br/><h5><strong>Error Inexistencia de Sucursal! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorSucursal.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Codigo de Sucursal:</strong> "+respuestaTcc.sucursal.codigo+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length == 0 && filterErrorTodas.length == 0 && filterErrorCiudad.length > 0 && filterErrorSucursal.length > 0){
        
              $scope.isError = true;

              encabezado += "<br/><h5><strong>Error Ciudad Destinatario! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorCiudad.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

              encabezado += "<br/><h5><strong>Error Inexistencia de Sucursal! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorSucursal.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Codigo de Sucursal:</strong> "+respuestaTcc.sucursal.codigo+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }else if(filterSuccessTodas.length == 0 && filterErrorTodas.length > 0 && filterErrorCiudad.length > 0 && filterErrorSucursal.length > 0){
        
              $scope.isError = true;

              encabezado += "<br/><h5><strong>Error! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorTodas.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

              encabezado += "<br/><h5><strong>Error Ciudad Destinatario! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorCiudad.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

              encabezado += "<br/><h5><strong>Error Inexistencia de Sucursal! </strong> Se ha presentado un error al intentar enviar las facturas de las siguientes sucursales a TCC para su despacho</h5><br/>";
              filterErrorSucursal.forEach(function(respuestaTcc){
                encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal+"<br/><strong>Codigo de Sucursal:</strong> "+respuestaTcc.sucursal.codigo+"<br/><strong>Ciudad de Destinatario:</strong> "+respuestaTcc.ciudaddestinatario+"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
              })

          }
      }else if(filterErrorLogin.length > 0 || filterErrorPermisos.length > 0){
   
        $scope.isError = true;
        if(filterErrorLogin.length > 0){
          encabezado += "<br/><h5><strong>Error! </strong> El servicio de TCC ha respondido con error de acceso, por favor revise comuniquese con el area de sistemas.</h5><br/>";
          filterErrorLogin.forEach(function(respuestaTcc){
            encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
          })
        }else if(filterErrorPermisos.length > 0){
          encabezado += "<br/><h5><strong>Error! </strong> El servicio de TCC ha respondido con error de privilegios, por favor comuniquese con el area de sistemas.</h5><br/>";
          filterErrorPermisos.forEach(function(respuestaTcc){
            encabezado += "<pre><strong>Sucursal:</strong> "+respuestaTcc.nombreSucursal +"<br/><strong>Remesa:</strong> "+respuestaTcc.remesa+"<br/><strong>Mensaje Error Remesa:</strong> "+respuestaTcc.mensaje+"</pre>";
          })
        }
      }

      angular.element('.close').trigger('click');

        if($scope.isError == true){

          $mdDialog.show($mdDialog.confirm({
            title: 'Información Despacho de Remesas',
            htmlContent: encabezado,
            ok: 'Volver a Intentar',
            cancel: 'Cerrar',
          })).then(function(){
              $scope.enviarRemesa();
          }, function(){
              $scope.isError = false;
          });


        }else if($scope.isError == false){

          $mdDialog.show($mdDialog.alert({
            title: 'Información Despacho de Remesas',
            htmlContent: encabezado,
            ok: 'Cerrar',
          })).then(function(){
              $scope.progress = true;
              $scope.cliente = undefined;
              $scope.puedeEnviar = false;
              $scope.getInfo();
          });

        }

      });
    }


    $scope.mensajeRemesaBoomerang = function(encabezado,sucursal){

      encabezado += "\n<h5><strong>Nota: </strong>Las siguientes remesas han sido generadas para un cliente que cuenta con el servicio de boomerang.</h5>\n";

      //var filterErrorBoogmerang = $filter('filter')(filterSuccessTodas, {boomerangResponse : {respuesta : "-1"}});

      if(sucursal.boomerangResponse.respuesta < 0){//filterErrorBoogmerang.length > 0
        encabezado +="\n<h5><strong>Error de Boomerang! </strong> las siguientes sucursales han presentado errores en el envio de boogmeran para este despacho</h5><br/>";
        encabezado += "<pre><strong>Sucursal:</strong> "+sucursal.nombreSucursal +"<br/><strong>Remesa:</strong> "+sucursal.remesa+"<br/><strong>Mensaje Error de Boomerang:</strong> "+ sucursal.boomerangResponse.mensaje +"</pre>";
      }else{
        encabezado += "<pre><strong>Sucursal:</strong> "+sucursal.nombreSucursal +"<br/><strong>Remesa:</strong> "+sucursal.remesa+"<br/><strong>Mensaje Remesa:</strong> "+sucursal.mensaje+"<br/><strong>Remesa Boomerang:</strong> "+sucursal.boomerangResponse.remesa+"<br/><strong>Mensaje Boomerang:</strong> "+ sucursal.boomerangResponse.mensaje +"</pre>";
      }

      return encabezado;
    }

    $scope.sumatoriaKilos = function(sucursal){

      sucursal.kilosRealesLios = sucursal.objetoLios.cantidadunidades * $scope.kilosBaseLios;
      sucursal.sumaTotalKilos = sucursal.kilosRealesLios + sucursal.kilosRealesEstibas;

      sucursal.objetoLios.kilosreales = sucursal.kilosRealesLios;
      sucursal.objetoCajas.kilosreales = 0;
      sucursal.objetoPaletas.kilosreales = sucursal.kilosRealesEstibas;

      $scope.cantidadesNoValidas();

      return sucursal;

    }

    $scope.cantidadesNoValidas = function(){

      var cantErroneos = 0;

      $scope.cliente.arregloFinal.sucursalesFiltradas.forEach(function(sucu){
        if(sucu.sumaTotalKilos == 0){
          cantErroneos += 1;
        }
      });

      if(cantErroneos > 0){
          $scope.pesosNoValidos = true;
      }else if(cantErroneos == 0){
        $scope.pesosNoValidos = false;
      }

    }

}]);
