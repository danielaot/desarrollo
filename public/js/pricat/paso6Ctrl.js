app.controller('paso6Ctrl', ['$scope', '$http' , '$window', '$mdDialog', function($scope, $http, $window, $mdDialog){
  $scope.getUrl = '../../paso6info';
  $scope.url = '../../paso6update';

  $scope.getInfo =  function(){
    $http.get($scope.getUrl).then(function(response){
      var info = response.data;
      console.log(info);
      $scope.tempaque = angular.copy(info.tempaque);
      $scope.tembalaje = angular.copy(info.tembalaje);
      $scope.cmanipulacion = angular.copy(info.cmanipulacion);
    });
  }

  $scope.getInfo();

  /*var previewNode = document.getElementById("template");
  previewNode.id = "";
  var previewTemplate = previewNode.outerHTML;
  previewNode.parentNode.removeChild(previewNode);

  $scope.dzOptions = {
    clickable: "#dropzone",
    url: "uploaditems",
    uploadMultiple: false,
    maxFiles: 1,
    maxFilesize: 10,
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    autoProcessQueue: false,
    previewTemplate: previewTemplate,
    previewsContainer: "#previews",
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    dictMaxFilesExceeded: "Solo está permitido cargar una imagen",
    dictInvalidFileType: "Tipo de archivo inválido"
  };

  $scope.dzCallbacks = {
    'processingfile' : function(file) {
      file.name = $scope.producto.ref;
    },
    'addedfile' : function(file){
      console.info(file);
    }
  };*/

  $scope.saveProducto = function(){
    if($scope.confirm){
      $scope.progress = true;

      var formData = new FormData();

      angular.forEach($scope.producto, function (value, key) {
        if(key == 'manipulacion' || key == 'tembalaje' || key == 'tempaque')
          formData.append('producto['+key+']', value.id);
        else
          formData.append('producto['+key+']', value);
      });

      angular.forEach($scope.empaque, function (value, key) {
        formData.append('empaque['+key+']', value);
      });

      angular.forEach($scope.patron, function (value, key) {
        formData.append('patron['+key+']', value);
      });

      formData.append('imagen', $scope.imagen);

      $http.post($scope.url, formData, {
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined}
      })
      .then(function(response){
        $scope.progress = false;
        if(response.data.errores == undefined)
          $window.location = response.data;
        else
          console.log(response.data.errores);
      }, function(){});
    }
    else{
      $mdDialog.show(
        $mdDialog.alert()
          .parent(angular.element(document.querySelector('body')))
          .clickOutsideToClose(true)
          .title('')
          .textContent('Confirme la Unidad de Empaque para poder continuar.')
          .ariaLabel('Embalaje')
          .ok('Aceptar')
          .targetEvent()
      );
    }
  }

  $scope.editProducto = function(){

      var object = {};
      object.producto = $scope.producto;
      object.empaque =  $scope.empaque;
      object.patron = $scope.patron;
      object.image = $scope.imagen;

      $http.post($scope.url, object).then(function(response){
        $scope.getInfo();
        $window.location = response.data;
  });
}
}]);
