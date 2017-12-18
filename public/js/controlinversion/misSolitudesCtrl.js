app.controller('misSolitudesCtrl', ['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder, $mdDialog){

	$scope.getInfoMisolicitudes = "getInfoMisolicitudes";
	$scope.anularUrl = "misSolicitudes/anular";
	$scope.progress = true;
	$scope.count = [];
	$scope.elaboracion = "0";
	$scope.solicitud =  {};
	$scope.lineasSolicitud = [];
	$scope.zonasSolicitud = [];

	$scope.getInfo = function(){
		$scope.todas = [];
		$http.get($scope.getInfoMisolicitudes).then(function(response){
			data = response.data;
			$scope.todas = angular.copy(data.solicitudes);
			console.log($scope.todas);

			$scope.todas.map(function(solicitud) {

					var fecha_ini = new Date(solicitud.sci_fecha);
					fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
					solicitud.sci_fecha = new Date(fecha_ini);

					solicitud.historico.map(function(hist){

						var fecha_hist = new Date(hist.soh_fechaenvio);
						fecha_hist = fecha_hist.getTime() + fecha_hist.getTimezoneOffset()*60*1000;
						hist.soh_fechaenvio = new Date(fecha_hist);
						return hist;

					});


					return solicitud;
			}, this);

			$scope.elaboracion =  $filter('filter')($scope.todas, {sci_soe_id : 0});
			$scope.solicitudes =  $filter('filter')($scope.todas, {sci_soe_id : 1});
			$scope.correcciones =  $filter('filter')($scope.todas, {sci_soe_id : 2});
			$scope.anulada =  $filter('filter')($scope.todas, {sci_soe_id : 3});
			$scope.aprobacion =  $filter('filter')($scope.todas, {sci_soe_id : 4});
			$scope.aprobada =  $filter('filter')($scope.todas, {sci_soe_id : 5});
			$scope.cerrada =  $filter('filter')($scope.todas, {sci_soe_id : 6});
			$scope.aprobacionAuditoria =  $filter('filter')($scope.todas, {sci_soe_id : 7});
			$scope.progress = false;
		}, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});

		$scope.dtOptions = DTOptionsBuilder.newOptions()
										.withOption('aaSorting', [[0, 'desc']]);


		$scope.dtColumnDefs0 = [
		DTColumnDefBuilder.newColumnDef(0).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(1).withClass('text-center').withOption('width', '100px'),
		DTColumnDefBuilder.newColumnDef(2).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(3).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(4).withClass('text-center').withOption('width', '90px'),
		DTColumnDefBuilder.newColumnDef(5).withClass('text-center').withOption('width', '110px'),
		DTColumnDefBuilder.newColumnDef(6).withClass('text-center').withOption('width','60px'),
		DTColumnDefBuilder.newColumnDef(7).withClass('text-left'),
		DTColumnDefBuilder.newColumnDef(8).notSortable().withClass('text-center').withOption('width', '69px')];



		$scope.dtColumnDefs1 = [
		DTColumnDefBuilder.newColumnDef(0).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(1).withClass('text-center').withOption('width', '100px'),
		DTColumnDefBuilder.newColumnDef(2).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(3).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(4).withClass('text-center').withOption('width', '90px'),
		DTColumnDefBuilder.newColumnDef(5).withClass('text-center').withOption('width', '110px'),
		DTColumnDefBuilder.newColumnDef(6).withClass('text-center').withOption('width','60px'),
		DTColumnDefBuilder.newColumnDef(7).withClass('text-left'),
		DTColumnDefBuilder.newColumnDef(8).notSortable().withClass('text-center').withOption('width', '69px'),
		DTColumnDefBuilder.newColumnDef(9).notSortable().withClass('text-center').withOption('width', '69px'),
		DTColumnDefBuilder.newColumnDef(10).notSortable().withClass('text-center').withOption('width', '69px')];


	};

	$scope.getInfo();

	$scope.setSolicitud = function(solicitud){

		console.log(solicitud);

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
			console.log($scope.zonasSolicitud);
		}


		if(solicitud.clientes.length > 0){

				solicitud.clientes.forEach(function(cliente){

					cliente.clientes_referencias.forEach(function(referencia){
						console.log(referencia);
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

	}

	$scope.terminarSolicitud = function(solicitud){
		window.location = solicitud.rutaEdit;
	}

	$scope.corregirSolicitud = function(solicitud){
		window.location = solicitud.rutaCorrecion;
	}

	$scope.anularSolicitud = function(solicitud){

		var confirm = $mdDialog.confirm()
			.title('Anular Solicitud')
			.textContent('¿Esta seguro(a) de querer anular esta solicitud?, Despues de anulada no podra realizar ninguna acción sobre está solicitud.')
			.ariaLabel('Lucky day')
			.ok('Continuar')
			.cancel('Cancelar');

			$mdDialog.show(confirm).then(function() {
				$scope.progress = true;
				$http.delete($scope.anularUrl+"/"+solicitud.sci_id).then(function(response){
					console.log(response.data);
					$scope.getInfo();

				});

			}, function() {


			});



	}



}]);
