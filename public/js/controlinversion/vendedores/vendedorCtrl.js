app.controller('vendedorCtrl',
['$scope', '$filter', '$http', '$timeout', 'DTOptionsBuilder', 'DTColumnDefBuilder',
function($scope, $filter, $http, $timeout, DTOptionsBuilder, DTColumnDefBuilder){


	$scope.progress = true;
	$scope.getUrl = 'vendedoresGetInfo';
  $scope.url = 'vendedores';
  $scope.searchVendedor = '';


	$scope.getInfo = function(){
		$http.get($scope.getUrl).then(function(response){
			var res = response.data;
			console.log(res);
      $scope.vendedoresZona = res.vendedoresZona;
      $scope.vendedoresBesa = res.vendedoresBesa;
      $scope.zonas = res.zonas;
      $scope.subzonas = res.subzonas;
      $scope.progress = false;
      angular.element('.close').trigger('click');
		});
	}

  $scope.dtOptions = DTOptionsBuilder.newOptions();

  $scope.dtColumnDefs = [
      DTColumnDefBuilder.newColumnDef(0).withOption('width', '60px'),
      DTColumnDefBuilder.newColumnDef(1).withOption('width', '200px'),
      DTColumnDefBuilder.newColumnDef(2).withOption('width', '85px'),
      DTColumnDefBuilder.newColumnDef(3).withOption('width', '90px'),
      DTColumnDefBuilder.newColumnDef(4).withOption('width', '80px'),
      DTColumnDefBuilder.newColumnDef(5).withOption('width', '60px'),
      DTColumnDefBuilder.newColumnDef(6).notSortable().withOption('width', '50px')
  ];

  $scope.setVendedor = function(){
    $scope.vendedor = {'vendedores' : []};
  }

	$scope.getInfo();


  $scope.vendedorSearch=function(query){
    if(query){
        var filtrado = $filter('filter')($scope.vendedoresBesa, {NomVendedor: query});
        if(filtrado.length == 0){
            filtrado = $filter('filter')($scope.vendedoresBesa, {IdVendedor: query});
        }
        return filtrado;
    }
    else{
        return $scope.vendedoresBesa;
    }
  }

  $scope.agregarVendedor = function(vendedor){

      if(vendedor){
          console.log('entre');
          vendedor.esNuevo = 1;
          vendedor.CodZona = $scope.vendedor.zona.CodZona;
          vendedor.NomZona = $scope.vendedor.zona.NomZona;
          vendedor.CodSubZona = $scope.vendedor.subzona.CodSubZona;
          vendedor.CodSubZona_ant = $scope.vendedor.subzona.CodSubZona;
          vendedor.NomSubZona = $scope.vendedor.subzona.NomSubZona;
          vendedor.NomSubZona_ant = $scope.vendedor.subzona.NomSubZona;
          vendedor.dir_territorio = "--";
          vendedor.ger_zona = "--";
          vendedor.estado = 1;
          vendedor.estadoModificado = 1;
          vendedor.existente = 0;
          console.log(vendedor);
          console.log($scope.vendedor);
          console.log('sali');
          $scope.vendedor.vendedores.push(vendedor);
      }

  }

  $scope.eliminarVendedor = function(vendedor){

        if(vendedor){
            for(var x in $scope.vendedor.vendedores){
                var ref = $scope.vendedor.vendedores[x];
                if(ref['NitVendedor'] == vendedor.NitVendedor){
                    $scope.vendedor.vendedores.splice(x, 1);
                }
            }
        }

  }

  $scope.filtrarSubZonas = function(){

    if($scope.vendedor.zona){
      console.log($scope.vendedor.zona.CodZona);

      var filtrado = $filter('filter')($scope.subzonas, {CodZona: $scope.vendedor.zona.CodZona});
      $scope.subzonasfilter = filtrado;

    }else{
      $scope.subzonasfilter = $scope.subzonas;
    }

  }


  $scope.filtrarVendedores = function(){
    if($scope.vendedor.subzona){

      var filtrado = $filter('filter')($scope.vendedoresZona,{CodZona: $scope.vendedor.subzona.CodZona, CodSubZona: $scope.vendedor.subzona.CodSubZona});
      $scope.vendedor.vendedores = filtrado;

      $scope.vendedor.vendedores.map(function(vendedor){
        vendedor.esNuevo = 0;
        vendedor.estadoModificado = vendedor.estado;
        vendedor.existente = 1;
        return vendedor;
      });

      console.log($scope.vendedor.vendedores);

    }

  }

  $scope.inhabilitarVendedor = function(vendedor){
    if(vendedor){
      console.log(vendedor.estadoModificado);
      if(vendedor.estadoModificado == 1){
        vendedor.estadoModificado = 0;
      }else if (vendedor.estadoModificado == 0){
        vendedor.estadoModificado = 1;
      }
    }
  }

  $scope.saveVendedor = function(){
    $scope.progress = true;
    $http.post($scope.url, $scope.vendedor)
    .then(function(response){
      $scope.getInfo();
    });
  }

}]);
