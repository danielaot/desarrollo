app.controller('nivelesautorizacionCtrl', ['$scope', '$http', '$filter', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', function ($scope, $http, $filter, $window, DTOptionsBuilder, DTColumnDefBuilder, $mdDialog) {
	$scope.getUrl = "nivelesAutorizacionGetInfo";
	$scope.url = "nivelesAutorizacion";
	$scope.objeto = {};
	$scope.arregloFiltrar = [];
	$scope.progress = true;
	$scope.canalesBool = false;
	$scope.lineasBool = false;

	$scope.tipoPersona = [
	{
		id : 1,
		tip_descripcion : 'Vendedor'
	},
	{
		id : 2,
		tip_descripcion : 'Mercadeo'
	},
	{
		id : 3,
		tip_descripcion : 'Colaborador'
	},
	];

	$scope.objeto.lineas = [];
	$scope.objeto.canales = [];
	$scope.validoSiGrabo = true;
	$scope.validoSiExisteNombre = false;



	$scope.getInfo = function(){
		$scope.perniveles = [];
		$http.get($scope.getUrl).then(function(response){			
			var res = response.data;
			$scope.terceros = angular.copy(res.terceros);
			$scope.niveles = angular.copy(res.niveles);
			$scope.VendedorZona = angular.copy(res.VendedorZona);
			$scope.arregloFiltrar = angular.copy($scope.terceros);
			$scope.lineas = angular.copy(res.lineas);
			$scope.canales = angular.copy(res.canales);
			$scope.canalPernivel = angular.copy(res.canalPernivel);
			$scope.perniveles = angular.copy(res.perniveles);
			

			// Filtros para cada pestaña/nivel
			$scope.nivelUno = $filter('filter')($scope.perniveles, {pern_nomnivel : 1});
			$scope.nivelDos = $filter('filter')($scope.perniveles, {pern_nomnivel : 2});
			$scope.nivelTres = $filter('filter')($scope.perniveles, {pern_nomnivel : 3});
			$scope.nivelCuatro = $filter('filter')($scope.perniveles, {pern_nomnivel : 4});
			$scope.progress = false;
		},function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});


		$scope.dtOptions = DTOptionsBuilder.newOptions()
		.withOption('aaSorting', [[0, 'desc']]);

		$scope.dtColumnDefs0 = [
		DTColumnDefBuilder.newColumnDef(0).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(1).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(2).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(3).withClass('text-center')];

	};

	$scope.getInfo();

	$scope.querySearch = function(string){
		var persona = $filter('filter')($scope.arregloFiltrar, {idTercero : string});	
		if(persona.length == 0){
			return $filter('filter')($scope.arregloFiltrar, {razonSocialTercero : string});
		}else{
			return persona;
		}
	}

	$scope.cambioConsultaArreglo = function(){
		if ($scope.objeto.tipo.id == 1) {
			$scope.arregloFiltrar = angular.copy($scope.VendedorZona);
			$scope.objeto.selectedItem = undefined;
		}else{
			$scope.arregloFiltrar = angular.copy($scope.terceros);
			$scope.objeto.selectedItem = undefined;
		}		
	}

	$scope.nivelesCambio = function(){
		if($scope.objeto.nivel.id != 1){
			$scope.arregloFiltrar = $scope.terceros;
			$scope.objeto.tipo = undefined;
			$scope.objeto.selectedItem = undefined;
		}
		if($scope.objeto.nivel.id != 3){
			$scope.objeto.canales = [];
			$scope.objeto.lineas = [];
		}
	}

	$scope.save = function(){
		if (($scope.objeto.canales.length > 0 && $scope.objeto.lineas.length > 0 && $scope.objeto.nivel.id == 3) || ($scope.objeto.nivel.id != 3)) {
			$scope.progress = true;
			$http.post($scope.url, $scope.objeto).then(function(response){
				$window.location.reload();						
			});
		}		
	}

	// Funciones del multiselect
	$scope.clearSearchTerm = function() {
		$scope.searchTerm = '';
	};

	$scope.agregarLinea = function(objeto){
		$scope.validoSiGrabo = true;
		$scope.objeto.canales.forEach(function(canal){
			var validemos = $filter('filter')($scope.canalPernivel, { cap_idlinea : objeto.lin_id, cap_idcanal : canal.can_id.trim()});
			if (validemos.length > 0) {
				$scope.validoSiGrabo = false;
			}
		});
		if ($scope.validoSiGrabo) {
			$scope.objeto.lineas.push(objeto);
			$scope.lineas = angular.copy($filter('removeWith')($scope.lineas, { lin_id : objeto.lin_id}));	
		}		
	}

	$scope.borrarEsteElemento = function(objeto){
		$scope.objeto.lineas = angular.copy($filter('removeWith')($scope.objeto.lineas, { lin_id : objeto.lin_id}));
		$scope.lineas.push(objeto);
	}

    //AgregarCanal
    $scope.AgregarCanal = function(objeto){
    	$scope.objeto.canales.push(objeto);
    	$scope.canales = angular.copy($filter('removeWith')($scope.canales, { can_id : objeto.can_id}));
    }

    //BorrarElemento
    $scope.borrarElemento = function(objeto){
    	$scope.objeto.canales = angular.copy($filter('removeWith')($scope.objeto.canales, { can_id : objeto.can_id}));
    	$scope.canales.push(objeto);

    }

    $scope.cambioPersonaInAutocomplete = function(objeto){
    	if(objeto != undefined && objeto != null){
    		var buscoSiExiste = $filter('filter')($scope.perniveles, { pern_cedula : objeto.idTercero});
    		if (buscoSiExiste.length > 0 && $scope.objeto.id == undefined) {
    			$scope.objeto.selectedItem = undefined;
    			$scope.validoSiExisteNombre = true;
    		}else{
    			$scope.validoSiExisteNombre = false;
    		}
    	}
    	
    }

    $scope.filtroNiveles = function(idNivel){
    	return $filter('filter')($scope.perniveles, {pern_nomnivel : idNivel});
    }

    $scope.pintarTipoPersona = function(idVista){
    	var desc_vista = $filter('filter')($scope.tipoPersona, {id : idVista});
    	return desc_vista[0].tip_descripcion;
    }

    $scope.inactivar = function(objeto){
    	$scope.progress = true;

    	console.log(objeto);
    	var obtengoPerniveles = $filter('filter')($scope.perniveles, {pern_jefe : objeto.id});
    	console.log(obtengoPerniveles);

    	if (obtengoPerniveles.length == 0) {
    		$http.delete($scope.url + "/" + objeto.id , objeto).then(function(response){
    			$window.location.reload();		
    		});		
    	}else{
    		$scope.progress = false;

    		var hijosString = "<div class='panel panel-default'> <div class='panel-heading'>Este elemento no puede ser borrado debido a que tiene asociados los siguientes usuarios:</div> <div class='panel-body'><ul class='list-group'>";
    		obtengoPerniveles.forEach( function(element, index) {
    			hijosString += "<li class='list-group-item'> " + element.pern_nombre + '- Nivel:' + element.pern_nomnivel + "</li>";
    		});
    		hijosString += "</ul></div></div> ";
    		console.log(hijosString);
		   	$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('IMPOSIBLE BORRAR ESTE ELEMENTO')
		        .htmlContent(hijosString)
		        .ariaLabel('')
		        .ok('Entendido')
		    );
    	}

    	
    }

    $scope.actualizar = function(objeto){
    	// Vaciar el objeto.
    	$scope.objeto = {};
    	$scope.objeto.lineas = [];
		$scope.objeto.canales = [];

    	console.log(objeto);
    	// Seteo el id del objeto en el formulario
    	$scope.objeto.id = angular.copy(objeto.id);
    	// Seteo el nivel
    	var obtengoNivel = $filter('filter')($scope.niveles, {id : objeto.pern_nomnivel});
    	$scope.objeto.nivel = angular.copy(obtengoNivel[0]);
    	// Seteo el tercero
    	var obtengoTercero = $filter('filter')($scope.terceros, {idTercero : objeto.pern_cedula});
    	$scope.objeto.selectedItem = angular.copy(obtengoTercero[0]);
    	// seteo el objeto Jefe
    	var obtengoJefe = $filter('filter')($scope.perniveles, {id : objeto.pern_jefe});
    	$scope.objeto.jefe = angular.copy(obtengoJefe[0]);
    	// Agrupo los canales para obtener los que voy a pintar solo los diferentes
    	var agruparCanales = $filter('groupBy')(objeto.canales, 'cap_idcanal');
    	console.log(agruparCanales);
    	var log = [];
    	// Seteo los canales en el arreglo de canales
    	angular.forEach(agruparCanales, function(value, key) {
		   	var obtengoCanal = $filter('filter')($scope.canales, {can_id : key});
    		$scope.AgregarCanal(angular.copy(obtengoCanal[0]));
		}, log);

    	// Seteo los canales en el arreglo de canales
    	angular.forEach($scope.canales, function(value, key) {
		   	var obtengoLinea = $filter('filter')($scope.lineas, {lin_id : value.cap_idlinea});
    		$scope.agregarLinea(angular.copy(obtengoLinea[0]));
		}, log);






    }

}])