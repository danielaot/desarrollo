app.controller('nivelesAutorizacionCtrl', ['$scope', '$filter', '$http', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function( $scope, $filter, $http, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){

  $scope.url = 'nivelesautorizacion';
  $scope.getUrl = 'nivelesautorizacioninfo';
  $scope.urlEdit = 'nivelesautorizacionedit';
  $scope.urlDelete = 'nivelesautorizaciondelete';
  $scope.detalleper = [];
  $scope.nivel = {};
  $scope.estados = [{value: 'S' , key : 'Activo'},{value: 'N', key: 'Inactivo'}];
  $scope.progress = true;
  $scope.tercerosFiltrados = [];
  $scope.canalesFiltrados = [];
  $scope.gruposFiltrados = [];
  $scope.gerenciasFiltradas = [];

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      $scope.tpersona = angular.copy(info.tpersona);
      $scope.canales = angular.copy(info.canal);
      $scope.territorios = angular.copy(info.territorios);
      $scope.grupos = angular.copy(info.grupos);
      $scope.gerencias = angular.copy(info.gerencias);
      $scope.usuarios = angular.copy(info.usuarios);
      $scope.niveles = angular.copy(info.niveles);
      $scope.gerencias = angular.copy(info.gerencias);
      $scope.usuariosN = angular.copy(info.usuariosN);
      $scope.usuariosSinFiltro = angular.copy(info.usuariosSinFiltro);
      $scope.nivelFiltrados = angular.copy(info.usuariosN);
      $scope.usuNivelUno =  $filter('filter')($scope.usuariosN, {pen_nomnivel : 1});
      $scope.usuNivelDos = $filter('filter')($scope.usuariosN, {pen_nomnivel : 2});
      $scope.usuNivelTres = $filter('filter')($scope.usuariosN, {pen_nomnivel : 3});
      $scope.usuNivelCuatro = $filter('filter')($scope.usuariosN, {pen_nomnivel : 4});
      $scope.usuSerAdmin = $filter('filter')($scope.usuariosN, {pen_isServiAdmon : 1});
      $scope.ciudades = angular.copy(info.ciudades);
      $scope.progress = false;
    }, function(error){
			$scope.getInfo();
		});
  }

  $scope.getInfo();

  /*$scope.nombreSearch = function(query){
    var filter = [];
    filter = $filter('filter')($scope.usuarios, {nombreEstablecimientoTercero : query});
    return filter;
  }*/

  /*$scope.ciudades = function(query){
      var filter = [];
      filter = $filter('filter')($scope.ciudades, {ciuTxtNom : query});
      return filter;
  }*/

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
     if($scope.nivel[0].id == 4){
      $scope.infoPerNivel.tpersona = $filter('filter')($scope.tpersona,{id: 5},true)[0];
      $scope.filtrarPersonasArreglo();
    }
   }

   $scope.savePerNivel = function(){

    $scope.progress = true;
    $scope.infoPerNivel.nivel = $scope.nivel[0];
    $http.post($scope.url, $scope.infoPerNivel).then(function(response){
      //$scope.getInfo();
      //angular.element('.close').trigger('click');
      //$scope.progress = false;
      });
    }

   $scope.onChangeTipoPersona = function(){

       if($scope.infoPerNivel.tpersona.id == 1 || $scope.infoPerNivel.tpersona.id == 2 || $scope.infoPerNivel.tpersona.id == 3 || $scope.infoPerNivel.tpersona.id == 4 || $scope.infoPerNivel.tpersona.id == 5){
         if(($scope.infoPerNivel.canales != undefined && $scope.infoPerNivel.canales.length > 0) ||
           ($scope.infoPerNivel.territorio != undefined && $scope.infoPerNivel.territorio.length > 0) ||
           ($scope.infoPerNivel.grupos != undefined && $scope.infoPerNivel.grupos.length > 0)){
           $scope.infoPerNivel.grupos = undefined;
           $scope.infoPerNivel.canales = undefined;
           $scope.infoPerNivel.territorio = undefined;
         }
       }
       $scope.filtrarPersonas();
     }

   $scope.filtrarPersonas = function(){

        if($scope.infoPerNivel.tpersona.id == 1 || $scope.infoPerNivel.tpersona.id == 2){

          if($scope.infoPerNivel.tpersona.id == 1){
            if($scope.infoPerNivel.canales != undefined){
              $scope.infoPerNivel.canales.map(function(canal){
                canal.tercerosFiltrados = $scope.filtrarPersonasArreglo(canal);
                return canal;
              });
            }
          }else{
            if($scope.infoPerNivel.territorio != undefined){
              $scope.infoPerNivel.territorio.forEach(function(territorio){
                $scope.filtrarPersonasArreglo(territorio);
              });
            }
          }

        }else if($scope.infoPerNivel.tpersona.id == 3 || $scope.infoPerNivel.tpersona.id == 4){

          if($scope.nivel[0].id == 2){
            if($scope.infoPerNivel.grupos != undefined){
              $scope.infoPerNivel.grupos.map(function(grupo){
                grupo.canalesFiltrados = $scope.filtrarPersonasArreglo(grupo);
                return grupo;
              });
            }
          }else if($scope.nivel[0].id == 3){
            $scope.filtrarPersonasArreglo();
          }

        }else if($scope.infoPerNivel.tpersona.id == 5){
          $scope.filtrarPersonasArreglo();
        }
      }

      $scope.filtrarPersonasArreglo = function(objeto = null){

        $scope.tercerosFiltrados = [];
        $scope.canalesFiltrados = [];
        $scope.gerenciasFiltradas = [];

        if($scope.nivel[0].id > 1 && $scope.nivel[0].id < 4){
console.log($scope.nivel[0].id);
          if($scope.infoPerNivel.tpersona.id == 1 || $scope.infoPerNivel.tpersona.id == 2){

            if($scope.infoPerNivel.tpersona.id == 1){
                $scope.tercerosFiltrados = $filter('filter')
                ($scope.usuariosN,
                  {
                    nivel: {niv_padre: $scope.nivel[0].id},
                    pen_idtipoper: $scope.infoPerNivel.tpersona.id,
                    detpersona: {detallenivelpersona : {perdepIntCanal: objeto.can_id,perdepPerIntIdAprueba: 0}}
                  }
                );
                return $scope.tercerosFiltrados;
            }else if($scope.infoPerNivel.tpersona.id == 2){
              if(objeto.canales != undefined){
                    objeto.canales.map(function(canal){
                      $scope.tercerosFiltrados = $filter('filter')
                      ($scope.usuariosN,{
                        nivel: {niv_padre: $scope.nivel[0].id},
                        pen_idtipoper: $scope.infoPerNivel.tpersona.id,
                        detpersona: {detallenivelpersona : {perdepIntCanal: objeto.can_id,perdepPerIntIdAprueba: 0}}
                        //detpersona: {detallenivelpersona : {perdepIntCanal: canal.can_id,perdepIntTerritorio: objeto.id,perdepPerIntIdAprueba: 0}}
                      });
                      canal.tercerosFiltrados = $scope.tercerosFiltrados;
                      return canal;
                    });
                }
console.log("------>2");
            }
          }
          //else if($scope.infoPerNivel.tpersona.id == 3 || $scope.infoPerNivel.tpersona.id == 4){
          //
          //     if($scope.nivel[0].id == 2){
          //
          //       $scope.canalesFiltrados = $filter('filter')($scope.canales, {canalperniveles:{perdepIntGrupo: objeto.id, perdepIntNivel: $scope.nivel[0].id, perdepPerIntIdtipoper: $scope.infoPerNivel.tpersona.id}});
          //
          //       var canales = angular.copy($scope.canales);
          //
          //       if($scope.canalesFiltrados.length > 0){
          //         $scope.canalesFiltrados.forEach(function(canal){
          //           canales.forEach(function(cn,k2){
          //             if(canal.can_id == cn.can_id){
          //               canales.splice(k2,1);
          //             }
          //           })
          //         })
          //       }
          //
          //       $scope.canalesFiltrados = canales;
          //       return $scope.canalesFiltrados;
          //
          //
          //     }else if($scope.nivel[0].id == 3){
          //
          //       var gruposFiltrados = $filter('filter')($scope.grupos,{gruppernivel:{pnd_nivel: $scope.nivel[0].id, pnd_tipopersona: $scope.infoPerNivel.tipopersona.id}});
          //       var grupos = angular.copy($scope.grupos);
          //
          //       if(gruposFiltrados.length > 0){
          //
          //         gruposFiltrados.forEach(function(grupo){
          //           grupos.forEach(function(gr,k2){
          //             if(grupo.id == gr.id){
          //               grupos.splice(k2,1);
          //             }
          //           })
          //         });
          //       }
          //       $scope.gruposFiltrados = grupos;
          //       console.log($scope.gruposFiltrados);
          //     }
          //
          // }
          else if($scope.infoPerNivel.tpersona.id == 5){
            $scope.tercerosFiltrados = $filter('filter')($scope.usuariosN,{nivel: {niv_padre: $scope.nivel[0].id},pen_idtipoper: $scope.infoPerNivel.tpersona.id, detpersona : {detallenivelpersona : {perdepPerIntIdAprueba: 0}}});
          }

        }
        else if($scope.nivel[0].id == 4){

          var gerenciasFiltradas = $filter('filter')($scope.gerencias,{gerepernivel:{perdepIntNivel: $scope.nivel[0].id, perdepPerIntIdtipoper: $scope.infoPerNivel.tpersona.id}});
          var gerencias = angular.copy($scope.gerencias);

          if(gerenciasFiltradas.length > 0){
            gerenciasFiltradas.forEach(function(gerencia){
                gerencias.forEach(function(gn,k2){
                    if(gerencia.ger_cod == gn.ger_cod){
                      gerencias.splice(k2,1);
                    }
                })
            });
          }
          $scope.gerenciasFiltradas = gerencias;
        }
      }

   $scope.editNivel = function(usuarioUno){
       $scope.usuarioUno = usuarioUno;
       console.log($scope.usuarioUno);
       $scope.infoPerNivel.idpernivel = $scope.usuarioUno.id;
       $scope.infoPerNivel.nivel = $filter('filter')($scope.niveles,{id : $scope.usuarioUno.pen_nomnivel})[0];
       console.log($scope.infoPerNivel.nivel);
       $scope.infoPerNivel.tpersona = $scope.usuarioUno.tipo_persona;
       $scope.infoPerNivel.tercero = $filter('filter')($scope.usuariosSinFiltro, {nombreEstablecimientoTercero : $scope.usuarioUno.pen_nombre})[0];
      //$scope.infoPerNivel.fnacimiento = $scope.usuarioUno.detpersona.perTxtFechaNac; //nO SE MUESTRA
       $scope.infoPerNivel.estado = $filter('filter')($scope.estados, {value : $scope.usuarioUno.detpersona.perTxtEstado})[0];
       $scope.infoPerNivel.numpasaporte = $scope.usuarioUno.detpersona.perTxtNoPasaporte;
       //$scope.infoPerNivel.fpasaporte = $scope.usuarioUno.detpersona.perTxtFechaNac; //nO SE MUESTRA
       $scope.infoPerNivel.ciuexpedicion = $filter('filter')($scope.ciudades, {ciuIntId : $scope.usuarioUno.detpersona.perIntCiudadExpPass})[0];
       $scope.infoPerNivel.lifemiles = $scope.usuarioUno.detpersona.perIntLifeMiles;

       $scope.infoPerNivel.territorio = $filter('filter')($scope.territorios, {id : $scope.usuarioUno.detpersona.detallenivelpersona[0].perdepIntTerritorio});
       $scope.infoPerNivel.territorio.map(function(territorio){
         territorio.oldTerritorio = 'true';
         return territorio;
       });

       $scope.infoPerNivel.canales = $filter('filter')($scope.canales, {can_id : $scope.usuarioUno.detpersona.personasdepende.ejecutivo});
       $scope.infoPerNivel.canales.map(function(canales){
         canales.oldCanal = 'true';
         return canales;
       });

       $scope.infoPerNivel.grupos = $filter('filter')($scope.grupos, {id : $scope.usuarioUno.detpersona.detallenivelpersona[0].perdepIntGrupo});
       $scope.infoPerNivel.grupos.map(function(grupos){
         grupos.oldGrupo = 'true';
         return grupos;
       });

       $scope.infoPerNivel.objeto = $filter('filter')($scope.usuariosN, {detpersona : {perIntId : $scope.usuarioUno.detpersona.personasdepende.perdepPerIntId}});


  }

  $scope.editarNivel = function(){
      if ($scope.infoPerNivel.idpernivel != undefined) {

        console.log($scope.infoPerNivel);
        $http.put($scope.url+'/'+$scope.infoPerNivel.idpernivel, $scope.infoPerNivel).then(function(response){
          //$scope.getInfo();
        });
      }
  }

  $scope.eliminarNivel = function(usuario){
     $scope.infoEnviar = usuario;

     var confirm = $mdDialog.confirm()
       .title('')
       .textContent('Desea eliminar la persona?')
       .ariaLabel('usuario')
       .ok('Enviar')
       .cancel('Cancelar');

      $mdDialog.show(confirm).then(function(){
        $http.post($scope.urlDelete, $scope.infoEnviar).then(function(response){
        });
      });
    }



}]);
