app.controller('nivelesAutorizacionCtrl', ['$scope', '$filter', '$http', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.url = 'nivelesautorizacion';
  $scope.getUrl = 'nivelesautorizacioninfo';
  $scope.detalleper = [];
  $scope.nivel = {};
  $scope.estados = [{value: 'S' , key : 'Activo'},{value: 'N', key: 'Inactivo'}];

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.tpersona = angular.copy(info.tpersona);
      $scope.canal = angular.copy(info.canal);
      $scope.territorios = angular.copy(info.territorios);
      $scope.grupo = angular.copy(info.grupo);
      $scope.usuarios = angular.copy(info.usuarios);
      $scope.niveles = angular.copy(info.niveles);
      $scope.gerencia = angular.copy(info.gerencia);
      $scope.usuariosN = angular.copy(info.usuariosN);
      $scope.ciudades = angular.copy(info.ciudades);
      console.log($scope.usuariosN);
    }, function(error){
			$scope.getInfo();
		});

  $scope.getInfo();

  $scope.nombreSearch = function(query){
    var filter = [];
    filter = $filter('filter')($scope.usuarios, {nombreEstablecimientoTercero : query});
    return filter;
  }

  $scope.ciudades = function(query){
      var filter = [];
      filter = $filter('filter')($scope.ciudades, {ciuTxtNom : query});
      return filter;
  }

  $scope.quitarPersona = function(infoPerNivel){

    if(infoPerNivel){
        if($scope.nivel[0].id === 1){
            for(var x in $scope.infoPerNivel.detPersona){
                var ref = $scope.infoPerNivel.detPersona[x];
                if(ref['idRowTercero'] == infoPerNivel.idRowTercero){
                    $scope.infoPerNivel.detPersona.splice(x, 1);
                }
            }
        }else if($scope.nivel[0].id > 1){
            for(var x in $scope.infoPerNivel.personasautoriza){
                var ref = $scope.infoPerNivel.personasautoriza[x];
                if(ref['id'] == detPersona.id){
                    $scope.infoPerNivel.personasautoriza.splice(x, 1);
                }
            }
         }
      }

  //   if (infoPerNivel) {
  //     for(var x in $scope.infoPerNivel.detPersona){
  //         var info = $scope.infoPerNivel.detPersona[x];
  //           if(info['idTercero'] == infoPerNivel.idTercero){
  //               $scope.infoPerNivel.detPersona.splice(x, 1);
  //           }
  //     }
  //   }
   }

   $scope.cambiarNivel = function(nivel){
     $scope.nivel = $filter('filter')($scope.niveles, {id: nivel}, true);
     $scope.infoPerNivel = {};
   }

  $scope.savePerNivel = function(){
    $scope.infoPerNivel.nivel = $scope.nivel[0];
    $http.post($scope.url, $scope.infoPerNivel).then(function(response){
      console.log($scope.infoPerNivel);
      $scope.getInfo();
      angular.element('.close').trigger('click');
    });
  }


  $scope.filtrarPersonas = function(){
    	if($scope.nivel[0].id > 1 && $scope.infoPerNivel.terceros != undefined){
    		if($scope.infoPerNivel.tipopersona != undefined){

	    		if($scope.infoPerNivel.tipopersona.id === 1 || $scope.infoPerNivel.tipopersona.id === 2){

					if($scope.infoPerNivel.canales != undefined){


    					var filterTerceros = [];

    					$scope.infoPerNivel.canales.forEach(function(canal){
    						var canId = canal.can_id;
    						filterTerceros = $filter('filter')($scope.perniveles,{pen_idcanales: canId});
    						if(filterTerceros.length > 0){
    							filterTerceros.forEach(function(tercero){
    								if($scope.tercerosFiltrados.length > 0){
    									var filterExist = $filter('filter')($scope.tercerosFiltrados,{id : tercero.id});
    									if(filterExist.length === 0){
    										$scope.tercerosFiltrados.push(tercero);
    									}
    								}else{
    									$scope.tercerosFiltrados.push(tercero);
    								}
    							})
    						}
    					});

		    			if($scope.infoPerNivel.tipopersona.id === 1){

		    				$scope.tercerosFiltrados = $filter('filter')($scope.tercerosFiltrados, {pen_nomnivel: ($scope.nivel[0].id - 1)});

		    			}else if($scope.infoPerNivel.tipopersona.id === 2){

		    				if($scope.infoPerNivel.territorio != undefined){

		    					var filterTercerosTerritorio = [];
		    					var tercerosFiltradosTerritorio = [];

		    					$scope.infoPerNivel.territorio.forEach(function(territorio){

		    						var territorioId = territorio.id;
		    						filterTercerosTerritorio = $filter('filter')($scope.tercerosFiltrados,{pen_nomnivel: ($scope.nivel[0].id - 1), pen_idterritorios: territorioId});

		    						if(filterTercerosTerritorio.length > 0){

			    						filterTercerosTerritorio.forEach(function(terceroTerritorio){
			    							tercerosFiltradosTerritorio.push(terceroTerritorio);
			    						});
		    						}
		    					});
		    					$scope.tercerosFiltrados = tercerosFiltradosTerritorio;
		    				}

		    			}

    				}

	    		}

    		}
    	}
    }


}]);
