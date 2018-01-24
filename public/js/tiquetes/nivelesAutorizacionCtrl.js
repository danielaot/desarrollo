app.controller('nivelesAutorizacionCtrl', ['$scope', '$filter', '$http', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.url = 'nivelesautorizacion';
  $scope.getUrl = 'nivelesautorizacioninfo';
  $scope.detalleper = [];
  $scope.nivel = {};
  $scope.estados = [{value: 'S' , key : 'Activo'},{value: 'N', key: 'Inactivo'}];
  $scope.tercerosFiltrados = [];
  $scope.nivelFiltrados = [];
  $scope.progress = true;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.tpersona = angular.copy(info.tpersona);
      $scope.canales = angular.copy(info.canal);
      $scope.territorios = angular.copy(info.territorios);
      $scope.grupo = angular.copy(info.grupo);
      $scope.usuarios = angular.copy(info.usuarios);
      $scope.niveles = angular.copy(info.niveles);
      $scope.gerencia = angular.copy(info.gerencia);
      $scope.usuariosN = angular.copy(info.usuariosN);
      $scope.nivelFiltrados = angular.copy(info.usuariosN);
      $scope.usuNivelUno =  $filter('filter')($scope.usuariosN, {pen_nomnivel : 1});
      $scope.usuNivelDos = $filter('filter')($scope.usuariosN, {pen_nomnivel : 2});
      $scope.usuNivelTres = $filter('filter')($scope.usuariosN, {pen_nomnivel : 3});
      $scope.ciudades = angular.copy(info.ciudades);
      $scope.progress = false;
      console.log($scope.usuariosN);
    }, function(error){
			$scope.getInfo();
		});
  }

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
            for(var x in $scope.infoPerNivel.tercero){
                var ref = $scope.infoPerNivel.tercero[x];
                if(ref['idRowTercero'] == infoPerNivel.idRowTercero){
                    $scope.infoPerNivel.tercero.splice(x, 1);
                }
            }
        }else if($scope.nivel[0].id > 1){
            for(var x in $scope.infoPerNivel.personasautoriza){
                var ref = $scope.infoPerNivel.personasautoriza[x];
                if(ref['id'] == tercero.id){
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
    $scope.progress = true; 
    $scope.infoPerNivel.nivel = $scope.nivel[0];
    $http.post($scope.url, $scope.infoPerNivel).then(function(response){
      $scope.progress = false;
      // $scope.getInfo();
      // angular.element('.close').trigger('click');
    });
  }


  $scope.filtrarPersonas = function(){
    if ($scope.nivel[0].id > 1 && $scope.infoPerNivel.tercero != undefined && $scope.infoPerNivel.tpersona != undefined) {
      if ($scope.infoPerNivel.tpersona.id === 1 || $scope.infoPerNivel.tpersona.id === 2) {
        if ($scope.infoPerNivel.canales != undefined) {
          var array = [];
          $scope.arregloNivel = [];
          $scope.nivelFiltrados.forEach(function(object){
            var canales = object.pen_idcanales.split(',');
            $scope.bandera = false;
            canales.forEach(function(obj){
              var filt = $filter('filter')($scope.infoPerNivel.canales, {can_id : obj});
              if (filt.length > 0) {
                $scope.bandera = true;
              }
            });
            if ($scope.bandera) {
              $scope.arregloNivel.push(object);
              //console.log($scope.arregloNivel);
            }
          });
          if ($scope.infoPerNivel.tpersona.id === 1) {
            $scope.arregloNivel = $filter('filter')($scope.arregloNivel, {pen_nivelpadre : $scope.nivel[0].id});
          //  console.log($scope.arregloNivel);
          }else if ($scope.infoPerNivel.tpersona.id === 2) {
            $scope.arregloNivel = $filter('filter')($scope.arregloNivel, {pen_nivelpadre : $scope.nivel[0].id, pen_idterritorios : $scope.infoPerNivel.territorio[0].id});
          }
        }
      }else if ($scope.infoPerNivel.tpersona.id == 3 || $scope.infoPerNivel.tpersona.id == 4) {
        if ($scope.infoPerNivel.grupo != undefined) {
          console.log($scope.infoPerNivel.grupo);
          var array = [];
           $scope.arregloNivel = [];
           $scope.nivelFiltrados.forEach(function(object){
             if (object.pen_idgrupos !== "") {
               var grupos = object.pen_idgrupos.split(',');
               $scope.bandera = false;
               grupos.forEach(function(obj){
                 var filt = $filter('filter')($scope.infoPerNivel.grupo, {gru_sigla : obj});
                 if (filt.length > 0) {
                   $scope.bandera = true;
                 }
               });
              }
             if ($scope.bandera) {
               $scope.arregloNivel.push(object);
               console.log($scope.arregloNivel);
             }
          });
        }
      }
      //HACER FILTRO PARA ADMINISTRATIVO
      // else if ($scope.infoPerNivel.tpersona.id == 5) {
      //     console.log($scope.infoPerNivel.grupo);
      //     var array = [];
      //      $scope.arregloNivel = [];
      //      $scope.nivelFiltrados.forEach(function(object){
      //        console.log(object);
           //$scope.bandera = false;
           //var filt = $filter('filter')($scope.infoPerNivel.pen_, {gru_sigla : obj});
           // if (filt.length > 0) {
           //      $scope.bandera = true;
           // }
           //
           // if ($scope.bandera) {
           //     $scope.arregloNivel.push(object);
           //     console.log($scope.arregloNivel);
           //  }
          //});
      //}
    }
  }


}]);
