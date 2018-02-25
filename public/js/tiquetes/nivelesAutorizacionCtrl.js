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
  $scope.searchTerceroText;
  $scope.tercerosTemp = [];
  $scope.pernivelEditTemporal = {};

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

  $scope.setEditPernivel = function(infoPerNivel){

    $scope.isEdit = true;
    $scope.pernivelEdit = {};
    $scope.pernivelEditTemporal = {};
    $scope.pernivelEdit = angular.copy(infoPerNivel);
  //  $scope.infoPerNivel = angular.copy(infoPerNivel);
    $scope.nivel = angular.copy($scope.pernivelEdit.nivel);

    $scope.pernivelEdit.idpernivel = $scope.pernivelEdit.id;
    $scope.pernivelEdit.tpersona = $scope.pernivelEdit.tipo_persona.tpp_descripcion;

    console.log($scope.pernivelEdit);

    $scope.pernivelEdit.estado = $filter('filter')($scope.estados, {value : $scope.pernivelEdit.detpersona.perTxtEstado})[0];

    //$scope.pernivelEdit.numpasaporte = $scope.pernivelEdit.detpersona.perTxtNoPasaporte;
    //console.log($scope.pernivelEdit.numpasaporte);

    //$scope.infoPerNivel.fpasaporte = $scope.usuarioUno.detpersona.perTxtFechaNac; //nO SE MUESTRA
    //$scope.pernivelEdit.ciuexpedicion = $filter('filter')($scope.ciudades, {ciuIntId : $scope.pernivelEdit.detpersona.perIntCiudadExpPass})[0];
    //$scope.pernivelEdit.lifemiles = $scope.infoPerNivel.detpersona.perIntLifeMiles;

    var persona = $filter('filter')($scope.usuariosSinFiltro,{dirnacional : {dir_txt_cedula : $scope.pernivelEdit.pen_cedula}});

    if(persona.length > 0){
      $scope.tercerosTemp = angular.copy($scope.usuariosSinFiltro);
      $scope.tercerosTemp.push(persona[0]);
      $scope.pernivelEdit.nuevoBeneficiario = angular.copy(persona[0]);
    }

    if($scope.pernivelEdit.tipo_persona.id == 1 || $scope.pernivelEdit.tipo_persona.id == 2){

      if($scope.pernivelEdit.tipo_persona.id == 1){
        var canalesPluckeados = _.pluck($scope.pernivelEdit.detpersona.detallenivelpersona, 'canal');
        canalesPluckeados = _.uniq(canalesPluckeados, 'can_id');
        canalesPluckeados.map(function(canal){
          canal.isNew = false;
          return canal;
        })

        if($scope.pernivelEdit.nivel.id == 2 || $scope.pernivelEdit.nivel.id == 3){

          canalesPluckeados.map(function(canal){
            canal.usuarios = [];
            canal.tercerosFiltrados = $scope.filtrarPersonasArregloEditar(canal);

            var filterCanalDepende = $filter('filter')($scope.pernivelEdit.detpersona.personasdepende, {perdepIntCanal: canal.can_id},true);
            console.log(filterCanalDepende);
            if(filterCanalDepende.length > 0){
              filterCanalDepende = _.pluck(filterCanalDepende, 'perejecutivo');
              filterCanalDepende.forEach(function(perDepende){
                perDepende.isNew = false;
                perDepende.cedulaNombre = [perDepende.pen_cedula, perDepende.pen_nombre].join(' - ');
                canal.tercerosFiltrados.push(perDepende);
                canal.usuarios.push(perDepende);
              })
            }
            return canal;
          });
        }
        $scope.pernivelEdit.canales = angular.copy(canalesPluckeados);

        }else {

            var territoriosPluckeados = _.pluck(angular.copy($scope.pernivelEdit.detpersona.detallenivelpersona), 'territorio');
            territoriosPluckeados = _.uniq(territoriosPluckeados, 'id');

            territoriosPluckeados.map(function(ter){
              ter.isNew = false;
              ter.canales = [];
              var filterCanalesTerritorio = $filter('filter')($scope.pernivelEdit.detpersona.detallenivelpersona, {perdepIntTerritorio : ter.id.toString()},true);
              if(filterCanalesTerritorio.length > 0){
                ter.canales = _.pluck(filterCanalesTerritorio, 'canal');
                ter.canales.forEach(function(canal){
                  canal.isNew = false;
                });
              }
              return ter;
            });

            if($scope.pernivelEdit.nivel.id == 2 || $scope.pernivelEdit.nivel.id == 3){

              territoriosPluckeados.forEach(function(terr,key){

                $scope.filtrarPersonasArregloEditar(terr);
                terr.canales.forEach(function(canal,key){
                  canal.usuarios = $filter('filter')($scope.pernivelEdit.detpersona.personasdepende, {perdepIntCanal: canal.can_id, perdepIntTerritorio: terr.id.toString()},true);
                  canal.usuarios = _.pluck(canal.usuarios,'perejecutivo');
                  canal.usuarios.forEach(function(tercero){
                    tercero.cedulaNombre = [tercero.pen_cedula,tercero.pen_nombre].join(' - ');
                    if(canal.tercerosFiltrados != undefined){
                      canal.tercerosFiltrados.push(tercero);
                    }
                  })
                })
              })

            }
            $scope.pernivelEdit.territorios = angular.copy(territoriosPluckeados);
          }
      }else if($scope.pernivelEdit.tipo_persona.id == 3 || $scope.pernivelEdit.tipo_persona.id == 4){

        var gruposPluckeados = _.pluck($scope.pernivelEdit.detpersona.detallenivelpersona, 'grupo');
        gruposPluckeados = _.uniq(gruposPluckeados, 'id');

        gruposPluckeados.map(function(grupo){
          grupo.isNew = false;
          return grupo;
        })

        if($scope.pernivelEdit.nivel.id == 2){
          gruposPluckeados.forEach(function(grupo){
            var canalesGrupo = $filter('filter')($scope.pernivelEdit.detalle, {perdepIntGrupo : grupo.id.toString()},true);
            var canalesPluckeados = _.pluck(canalesGrupo,'canal');
            grupo.canales = angular.copy(canalesPluckeados);
            grupo.canalesFiltrados = $scope.filtrarPersonasArregloEditar(grupo);
            grupo.canales.forEach(function(canal){
              grupo.canalesFiltrados.push(canal);
            })
          })
        }

        $scope.pernivelEdit.grupos = angular.copy(gruposPluckeados);

      }else if($scope.pernivelEdit.tipo_persona.id == 5){

        if($scope.pernivelEdit.nivel.id > 1 && $scope.pernivelEdit.nivel.id < 4){

          var terceros = [];
          var tercerosPluckeados = [];
          var tercerosFiltrados = [];
          $scope.filtrarPersonasArregloEditar();

          terceros = angular.copy($scope.pernivelEdit.perniveldepende);
          tercerosPluckeados = _.pluck(terceros,'tpernivelejecutivo');
          tercerosFiltrados = angular.copy($scope.tercerosFiltrados);

          tercerosPluckeados.forEach(function(tercero){
            tercero.cedulaNombre = [tercero.pen_cedula, tercero.pen_nombre].join(' - ');
            tercerosFiltrados.push(tercero);
          });

          $scope.pernivelEdit.tercerosFiltrados = angular.copy(tercerosFiltrados);
          $scope.pernivelEdit.terceros = angular.copy(tercerosPluckeados);


          $scope.pernivelEdit.tercerosFiltrados = angular.copy(tercerosFiltrados);
          $scope.pernivelEdit.terceros = angular.copy(tercerosPluckeados);


        }else if($scope.pernivelEdit.nivel.id == 4){

          $scope.filtrarPersonasArregloEditar();

          var gerenciasPluckeadas = _.pluck($scope.pernivelEdit.detalle, 'gerencia');
          gerenciasPluckeadas = _.uniq(gerenciasPluckeadas, 'ger_cod');

          gerenciasPluckeadas.forEach(function(gerencia){
            gerencia.codigoGerencia = [gerencia.ger_id,gerencia.ger_nom].join(' - ');
            $scope.gerenciasFiltradas.push(angular.copy(gerencia));
            gerencia.isNew = false;
          });

        }
    }

    $scope.pernivelEditTemporal = angular.copy($scope.pernivelEdit);

  }


  $scope.onEditBeneficiario = function(){


    if($scope.pernivelEdit.tipo_persona.id == 1 || $scope.pernivelEdit.tipo_persona.id == 2){

      if($scope.pernivelEdit.tipo_persona.id == 1){

        if($scope.pernivelEdit.nivel.id == 2 || $scope.pernivelEdit.nivel.id == 3){

          if($scope.pernivelEdit.canales != undefined && $scope.pernivelEdit.canales.length > 0){

            var ultimoCanalAgregado = ($scope.pernivelEdit.canales.length -1);
            var canalNuevo = $scope.pernivelEdit.canales[ultimoCanalAgregado];
            var filterExist = $filter('filter')($scope.pernivelEditTemporal.canales,{can_id: canalNuevo.can_id},true);

            if(filterExist.length == 0){
              delete canalNuevo.canalesperniveles;
              canalNuevo.isNew = true;
              canalNuevo.usuarios = [];
              canalNuevo.tercerosFiltrados = $scope.filtrarPersonasArregloEditar(canalNuevo);
              if(canalNuevo.tercerosFiltrados.length > 0){
                $scope.pernivelEditTemporal.canales.push(angular.copy(canalNuevo));
                $scope.pernivelEdit.canales = angular.copy($scope.pernivelEditTemporal.canales);
              }else{
                var alerta = $mdDialog.alert()
                .parent(angular.element(document.querySelector('#popupContainer')))
                .clickOutsideToClose(false)
                .title("Error!")
                .textContent("No se encuentran personas vinculadas al canal que intenta agregar, por favor verifique su información.")
                .ariaLabel('Alert Dialog Demo')
                .ok('Ok')

                $mdDialog.show(alerta).then(function(){
                  $scope.pernivelEdit.canales = angular.copy($scope.pernivelEditTemporal.canales);
                });
              }
            }else{

              $scope.pernivelEditTemporal.canales.forEach(function(can,key){
                var filterExistTemp = $filter('filter')($scope.pernivelEdit.canales,{can_id: can.can_id},true);
                if(filterExistTemp.length == 0){
                  $scope.pernivelEditTemporal.canales.splice(key,1);
                }
              });
              $scope.pernivelEdit.canales = angular.copy($scope.pernivelEditTemporal.canales);
            }
          }else{
            console.log("No hay nada que mostrar");
          }
        }

      }else{

        if($scope.pernivelEdit.nivel.id == 1 || $scope.pernivelEdit.nivel.id == 2 || $scope.pernivelEdit.nivel.id == 3){
          if($scope.pernivelEdit.territorios != undefined && $scope.pernivelEdit.territorios.length > 0){

            var ultimoTerritorioAgregado  = ($scope.pernivelEdit.territorios.length - 1);
            var territorioNuevo = $scope.pernivelEdit.territorios[ultimoTerritorioAgregado];
            var filterExist = $filter('filter')($scope.pernivelEditTemporal.territorios, {id: territorioNuevo.id},true);

            if(filterExist.length == 0){
              delete territorioNuevo.zonanw;
              territorioNuevo.isNew = true;
              territorioNuevo.canales = [];
              $scope.pernivelEditTemporal.territorios.push(angular.copy(territorioNuevo));
              $scope.pernivelEdit.territorios = angular.copy($scope.pernivelEditTemporal.territorios);
            }else{

              $scope.pernivelEditTemporal.territorios.forEach(function(terr,key){
                var filterExistTemp = $filter('filter')($scope.pernivelEdit.territorios, {id : terr.id},true);
                if(filterExistTemp.length == 0){
                  $scope.pernivelEditTemporal.territorios.splice(key,1);
                }
              });
              $scope.pernivelEdit.territorios = angular.copy($scope.pernivelEditTemporal.territorios);
            }
          }else{
            console.log("No hay nada que mostrar");
          }
        }
      }
    }else if($scope.pernivelEdit.tipo_persona.id == 3 || $scope.pernivelEdit.tipo_persona.id == 4){

      if($scope.pernivelEdit.grupos != undefined && $scope.pernivelEdit.grupos.length > 0){

        if($scope.pernivelEdit.nivel.id == 2){

          var ultimoGrupoAgregado = ($scope.pernivelEdit.grupos.length - 1);
          var grupoNuevo = $scope.pernivelEdit.grupos[ultimoGrupoAgregado];
          var filterExist = $filter('filter')($scope.pernivelEditTemporal.grupos, {id: grupoNuevo.id},true);

          if(filterExist.length == 0){

            delete grupoNuevo.grupopernivel;
            grupoNuevo.isNew = true;
            grupoNuevo.canales = [];
            grupoNuevo.canalesFiltrados = $scope.filtrarPersonasArregloEditar(grupoNuevo);
            if(grupoNuevo.canalesFiltrados.length > 0){
              $scope.pernivelEditTemporal.grupos.push(angular.copy(grupoNuevo));
              $scope.pernivelEdit.grupos = angular.copy($scope.pernivelEditTemporal.grupos);
            }else{
              var alerta = $mdDialog.alert()
              .parent(angular.element(document.querySelector('#popupContainer')))
              .clickOutsideToClose(false)
              .title("Error!")
              .textContent("No se encuentran canales disponibles para el grupo que intenta agregar, por favor verifique su información.")
              .ariaLabel('Alert Dialog Demo')
              .ok('Ok')

              $mdDialog.show(alerta).then(function(){
                $scope.pernivelEdit.grupos = angular.copy($scope.pernivelEditTemporal.grupos);
              });
            }
          }else{
            $scope.pernivelEditTemporal.grupos.forEach(function(grp,key){
              var filterExistTemp = $filter('filter')($scope.pernivelEdit.grupos, {id : grp.id},true);
              if(filterExistTemp.length == 0){
                $scope.pernivelEditTemporal.grupos.splice(key,1);
              }
            });
            $scope.pernivelEdit.grupos = angular.copy($scope.pernivelEditTemporal.grupos);
          }
        }
      }else{
        $scope.pernivelEdit.grupos = angular.copy(gruposPluckeados);
        console.log("No hay nada que mostrar");
      }
    }
  }

  $scope.agregandoObjetoEditar = function(objeto,esHijo = false,territorio = null){

    if($scope.pernivelEdit.tipo_persona.id == 1 || $scope.pernivelEdit.tipo_persona.id == 2){

      if($scope.pernivelEdit.tipo_persona.id == 1){

        if($scope.pernivelEdit.nivel.id == 2 || $scope.pernivelEdit.nivel.id == 3){
console.log("entreeeeeeeeeeeeeeeeeeeeee");
          var canalTemporal = $filter('filter')($scope.pernivelEditTemporal.canales,{can_id: objeto.can_id},true)[0];
          var ultimaPersona = {};

          if(objeto.terceros != undefined){
            ultimaPersona = angular.copy(objeto.terceros[objeto.terceros.length - 1]);
            var filterPersonaExist = $filter('filter')(canalTemporal.terceros, {id : ultimaPersona.id},true);
console.log(filterPersonaExist);
            if(filterPersonaExist.length == 0){
              canalTemporal.terceros.push(ultimaPersona);
            }
          }
        }

      }else{

        if($scope.pernivelEdit.nivel.id == 1){

          var territorioTemporal = $filter('filter')($scope.pernivelEditTemporal.territorios, {id: objeto.id},true)[0];
          var ultimoCanal = {};

          if(objeto.canales != undefined){
            ultimoCanal = angular.copy(objeto.canales[objeto.canales.length - 1]);
            var filterCanalExist = $filter('filter')(territorioTemporal.canales, {can_id : ultimoCanal.can_id},true);
            if(filterCanalExist.length == 0){
              ultimoCanal.isNew = true;
              territorioTemporal.canales.push(ultimoCanal);
            }
          }
        }else if($scope.pernivelEdit.nivel.id == 2 || $scope.pernivelEdit.nivel.id == 3){

          if(esHijo == false){

            var territorioTemporal = $filter('filter')($scope.pernivelEditTemporal.territorios, {id: objeto.id},true)[0];
            var ultimoCanal = {};

            if(objeto.canales != undefined){

              var posicionUltimoCanal = objeto.canales.length - 1;
              ultimoCanal = angular.copy(objeto.canales[posicionUltimoCanal]);
              var filterCanalExist = $filter('filter')(territorioTemporal.canales, {can_id : ultimoCanal.can_id},true);

              if(filterCanalExist.length == 0){

                delete ultimoCanal.canalesperniveles;
                ultimoCanal.isNew = true;
                ultimoCanal.terceros = [];
                territorioTemporal.canales.push(ultimoCanal);
                $scope.filtrarPersonasArregloEditar(territorioTemporal);

                territorioTemporal.canales.map(function(canal,key){
                  if(canal.isNew == true && canal.terceros.length == 0){
                    canal.terceros = $filter('filter')($scope.pernivelEdit.perniveldepende,{pnd_canal: canal.can_id, pnd_territorio: territorioTemporal.id.toString()},true);
                    if(canal.terceros.length > 0){
                      canal.terceros = _.pluck(canal.terceros,'tpernivelejecutivo');
                      canal.terceros.forEach(function(tercero){
                        tercero.cedulaNombre = [tercero.pen_cedula,tercero.pen_nombre].join(' - ');
                        canal.tercerosFiltrados.push(tercero);
                      });
                    }
                  }else{
                    canal.tercerosFiltrados = canal.terceros;
                  }
                  return canal;
                });

                objeto.canales = angular.copy(territorioTemporal.canales);

              }else{

                territorioTemporal.canales.forEach(function(canal,key){
                  var filterExistTemp = $filter('filter')(objeto.canales, {can_id : canal.can_id},true);
                  if(filterExistTemp.length == 0){
                    territorioTemporal.canales.splice(key,1);
                  }
                });

                objeto.canales = angular.copy(territorioTemporal.canales);
              }
            }
          }else{

            var territorioTemporal = $filter('filter')($scope.pernivelEditTemporal.territorios, {id:territorio.id},true)[0];
            var canalTemporal = $filter('filter')(territorioTemporal.canales,{can_id: objeto.can_id},true)[0];
            var ultimaPersona = {};

            if(objeto.terceros != undefined){

              ultimaPersona = angular.copy(objeto.terceros[objeto.terceros.length - 1]);
              var filterPersonaExist = $filter('filter')(canalTemporal.usuarios, {id : ultimaPersona.id},true);

              if(filterPersonaExist.length == 0){
                canalTemporal.terceros.push(ultimaPersona);
                objeto.terceros = angular.copy(canalTemporal.terceros);
              }else{

                canalTemporal.usuarios.forEach(function(tercero,key){
                  console.log(tercero);
                  var filterExistTercero = $filter('filter')(objeto.usuarios, {id: tercero.id},true);
                  if(filterExistTercero.length == 0){
                    canalTemporal.usuarios.splice(key,1);
                  }
                })

                objeto.terceros = angular.copy(canalTemporal.terceros);
              }
            }
          }
        }
      }
    }else if($scope.pernivelEdit.tipo_persona.id == 3 || $scope.pernivelEdit.tipo_persona.id == 4){

      if($scope.pernivelEdit.nivel.id == 2){

        var grupoTemporal = $filter('filter')($scope.pernivelEditTemporal.grupos, {id: objeto.id},true)[0];
        var ultimoCanal = {};

        if(objeto.canales != undefined){
          ultimoCanal = angular.copy(objeto.canales[objeto.canales.length - 1]);
          var filterCanalExist = $filter('filter')(grupoTemporal.canales, {can_id : ultimoCanal.can_id},true);
          if(filterCanalExist.length == 0){
            grupoTemporal.canales.push(ultimoCanal);
          }
        }
      }
    }
  }

  $scope.filtrarPersonasArregloEditar = function(objeto = null){
    console.log("--->entre funcion nueva");
       $scope.tercerosFiltrados = [];
       $scope.canalesFiltrados = [];
       $scope.gerenciasFiltradas = [];

       //if($scope.nivel[0].id > 1 && $scope.nivel[0].id < 4){

       if($scope.nivel.id > 1 && $scope.nivel.id < 4){
console.log("entrada1");
         if($scope.pernivelEdit.tipo_persona.id == 1 || $scope.pernivelEdit.tipo_persona.id == 2){
console.log("entrada2");
           if($scope.pernivelEdit.tipo_persona.id == 1){
console.log("entrada3");

               $scope.tercerosFiltrados = $filter('filter')
               ($scope.usuarios,
                 {
                   nivel: {niv_padre: $scope.nivel.id},
                   pen_idtipoper: $scope.pernivelEdit.tipo_persona.id,
                   detpersona: {detallenivelpersona : {perdepIntCanal: objeto.can_id,perdepPerIntIdAprueba: 0}}
                 }
               );
               return $scope.tercerosFiltrados;
console.log($scope.tercerosFiltrados);
console.log($scope.usuarios);
           }else if($scope.pernivelEdit.tipo_persona.id == 2){
console.log("entrada4");

             if(objeto.canales != undefined){
                   objeto.canales.map(function(canal){
                     $scope.tercerosFiltrados = $filter('filter')
                     ($scope.usuarios,{
                       nivel: {niv_padre: $scope.nivel.id},
                       pen_idtipoper: $scope.pernivelEdit.tipo_persona.id,
                       detpersona: {detallenivelpersona : {perdepIntCanal: objeto.can_id,perdepPerIntIdAprueba: 0}}
                       //detpersona: {detallenivelpersona : {perdepIntCanal: canal.can_id,perdepIntTerritorio: objeto.id,perdepPerIntIdAprueba: 0}}
                     });
                     canal.tercerosFiltrados = $scope.tercerosFiltrados;
                     return canal;
                   });
               }
           }
         }

         else if($scope.pernivelEdit.tipo_persona.id == 5){
           $scope.tercerosFiltrados = $filter('filter')($scope.usuarios,{nivel: {niv_padre: $scope.nivel.id},pen_idtipoper: $scope.pernivelEdit.tipo_persona.id, detpersona : {detallenivelpersona : {perdepPerIntIdAprueba: 0}}});
         }

       }
       else if($scope.nivel.id == 4){

         var gerenciasFiltradas = $filter('filter')($scope.gerencias,{gerenciapernivel:{perdepIntNivel: $scope.nivel.id, perdepPerIntIdtipoper: $scope.pernivelEdit.tipo_persona.id}});
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


  $scope.getTercerosSinFiltro = function(query){

    var filtro = $filter('filter')($scope.tercerosTemp,{directorionacional: {dir_txt_nombre: query}});
    if(filtro.length == 0){
      filtro = $filter('filter')($scope.tercerosTemp,{directorionacional:{dir_txt_cedula: query}});
    }
    return filtro;
  }

  $scope.nombreSearch = function(query){
    var filter = [];
    filter = $filter('filter')($scope.usuarios, {nombreEstablecimientoTercero : query});
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

        //if($scope.nivel[0].id > 1 && $scope.nivel[0].id < 4){

        if($scope.nivel[0].id > 1 && $scope.nivel[0].id < 4){

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
            }
          }
          //else if($scope.infoPerNivel.tpersona.id == 3 || $scope.infoPerNivel.tpersona.id == 4){
          //
          //     if($scope.nivel[0].id == 2){
          //
          //       $scope.canalesFiltrados = $filter('filter')($scope.canales, {canalesperniveles:{perdepIntGrupo: objeto.id, perdepIntNivel: $scope.nivel[0].id, perdepPerIntIdtipoper: $scope.infoPerNivel.tpersona.id}});
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
          //       var gruposFiltrados = $filter('filter')($scope.grupos,{grupopernivel:{pnd_nivel: $scope.nivel[0].id, pnd_tipopersona: $scope.infoPerNivel.tipopersona.id}});
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

          var gerenciasFiltradas = $filter('filter')($scope.gerencias,{gerenciapernivel:{perdepIntNivel: $scope.nivel[0].id, perdepPerIntIdtipoper: $scope.infoPerNivel.tpersona.id}});
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

   /*$scope.editNivel = function(usuarioUno){
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
console.log($scope.infoPerNivel.objeto);

}*/

  $scope.editarNivel = function(){
console.log("entreeeeeee");
console.log($scope.pernivelEdit);
      if ($scope.pernivelEdit.idpernivel != undefined) {
        console.log($scope.pernivelEdit);
        $http.put($scope.url+'/'+$scope.pernivelEdit.idpernivel, $scope.pernivelEdit).then(function(response){
          console.log($scope.pernivelEdit);
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
