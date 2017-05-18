/*
 * Funciones generales
 */
// Declaración de Modulo AngularJs
var app = angular.module('aplicativos', ['angular.filter','ngMaterial']);

//Declaracion de la paleta de colores para Angular Material
app.config(function($mdThemingProvider){
  $mdThemingProvider.theme('default')
    .primaryPalette('blue')
    .accentPalette('light-green');
});

// Declaracion de directiva para restringir caracteres en los campos de texto o textareas
app.directive('chars', function() {
  'use strict';
  return {
    require: 'ngModel',
    restrict: 'A',
    link: function($scope, $elem, attrs, ctrl) {
      var regReplace,
        preset = {
          'only-numbers': '0-9',
          'numbers': '0-9\\s',
          'only-letters': 'A-Za-z',
          'letters': 'A-Za-z\\s',
          'email': '\\wÑñ@._\\-',
          'alpha-numeric': '\\w\\s',
          'latin-alpha-numeric': '\\w\\sÑñáéíóúüÁÉÍÓÚÜ'
        },
        filter = preset[attrs.chars] || attrs.chars;

      $elem.on('input', function() {
        regReplace = new RegExp('[^' + filter + ']', 'ig');
        ctrl.$setViewValue($elem.val().replace(regReplace, ''));
        ctrl.$render();
      });
    }
  };
});

//Funciones para realizar autocomplete
$(function(){
  if(document.getElementById('usuarios')){
    $("#usuarios")
    .autocomplete({
      minLength: 2,
      source: function(request, response){
        var term = request.term;
        $.getJSON($("#url").val(), { "term": term }, response);
      },
      focus: function (event, ui) {
          var nombre = ui.item.dir_txt_nombre;
          $("#usuarios").val(nombre);
      },
      select: function (event, ui) {
          var nombre = ui.item.dir_txt_nombre;
          setTimeout(function(){ $("#usuarios").val(nombre); }, 100);
      }
    })
    .autocomplete("instance")._renderItem = function(ul, item) {
      return $( "<li>" )
      .append( "<div>" + item.dir_txt_cedula + " -> " + item.dir_txt_nombre + "</div>" )
      .appendTo( ul );
    };
  }
});
