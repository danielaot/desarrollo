@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso7Ctrl" ng-cloak>
    <form name="paso7Form" ng-submit="paso4Form.$valid" class="form-horizontal" enctype="multipart/form-data">
      <div class="panel panel-primary">
        <div class="panel-heading">Información del Producto</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-12">
                  <h4>AAA000 - Shampoo BIOHERBAL Manzanilla X 350ml</h4>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <h4>Cod Producto: 7702277144540</h4>
            </div>
            <div class="col-sm-3">
              <h4>Cod Corrugado: 17702277144547</h4>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Tipo de Empaque:</label>
                <div class="col-sm-5">
                  <select class="form-control" ng-model="producto.tempaque" ng-options="opt.temp_nombre for opt in tempaque track by opt.temp_calificador" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Tipo de Embalaje:</label>
                <div class="col-sm-5">
                  <select class="form-control" ng-model="producto.tembalaje" ng-options="opt.temb_nombre for opt in tembalaje track by opt.temb_calificador" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-7 control-label">Condiciones de Manipulacion:</label>
                <div class="col-sm-5">
                  <select class="form-control" ng-model="producto.manipulacion" ng-options="opt.tcman_nombre for opt in cmanipulacion track by opt.tcman_calificador" required></select>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-6 form-group">
              <div class="row">
                <div class="col-sm-12">
                  Descripcion Embalaje Larga <br>
                  Descripcion Embalaje Corta
                </div>
              </div>
            </div>
            <div class="col-sm-6 form-group">
              <div class="row">
                <div class="col-sm-3">
                  <span id="dropzone" class="btn btn-success btn-sm dz-clickable">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Cargar Imágen</span>
                  </span>
                </div>
                <div class="col-sm-6">
                  <div class="table table-striped" class="files" id="previews">
                    <div id="template" class="file-row">
                      <!-- This is used as the file preview template -->
                      <div>
                        <span class="preview" style="margin: 5px 15px; border: 1px solid; display: inline-block;"><img data-dz-thumbnail /></span>
                        <button data-dz-remove class="btn btn-danger delete">
                          <i class="glyphicon glyphicon-trash"></i>
                        </button>
                      </div>
                      <div>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="panel panel-primary">
        <div class="panel-heading">Medidas del Producto</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Alto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.alto"/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Ancho:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.ancho"/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Profundo:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.profundo"/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Volumen:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.volumen" ng-value="producto.alto*producto.ancho*producto.profundo" disabled/>
                  <div class="input-group-addon">mm<sup>3</sup></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Neto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.pesoneto"/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Bruto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.pesobruto"/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Tara:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.tara" ng-value="producto.pesoneto-producto.pesobruto" disabled/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-primary">
        <div class="panel-heading">Medidas del Empaque</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Alto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.alto"/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Ancho:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.ancho"/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Profundo:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.profundo"/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Volumen:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.volumen" ng-value="empaque.alto*empaque.ancho*empaque.profundo" disabled/>
                  <div class="input-group-addon">mm<sup>3</sup></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Neto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.pesoneto"/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Bruto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.pesobruto"/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Tara:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.tara" ng-value="empaque.pesoneto-empaque.pesobruto" disabled/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-primary">
        <div class="panel-heading">Patrón de Arrume</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Unidad de Empaque:</label>
                <div class="col-sm-4">
                  <div class="input-group">
                    <input type="text" class="form-control" ng-model="producto.cantemb" maxlength="3"/>
                    <div class="input-group-addon">unds</div>
                  </div>
                </div>
                <div class="col-sm-1">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="1"/>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-7 control-label">Tendidos x Caja:</label>
                <div class="col-sm-2" style="padding-left: 0; padding-right: 0;">
                  <input type="number" class="form-control" ng-model="patron.numtendidos" maxlength="3"/>
                </div>
              </div>
            </div>
            <div class="col-sm-2 form-group">
              <div class="row">
                <label class="col-sm-9 control-label">Cajas x Tendido:</label>
                <div class="col-sm-2" style="padding-left: 0; padding-right: 0;">
                  <input type="number" class="form-control" ng-model="patron.cajten"/>
                </div>
              </div>
            </div>
            <div class="col-sm-2 form-group">
              <div class="row">
                <label class="col-sm-10 control-label">Tendidos x Estiba:</label>
                <div class="col-sm-2" style="padding-left: 0; padding-right: 0; margin-left: -15px;">
                  <input type="number" class="form-control" ng-model="patron.tenest"/>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2 form-group">
              <div class="row">
                <label class="col-sm-9 control-label">Unds x Tendido:</label>
                <div class="col-sm-2" style="padding-left: 0; padding-right: 0;">
                  <input type="number" class="form-control" ng-model="patron.undten" ng-value="producto.cantemb*patron.cajten" disabled/>
                </div>
              </div>
            </div>
            <div class="col-sm-2 form-group">
              <div class="row">
                <label class="col-sm-8 control-label">Unds x Estiba:</label>
                <div class="col-sm-2" style="padding-left: 0; padding-right: 0;">
                  <input type="number" class="form-control" ng-model="patron.undest" ng-value="patron.undten*patron.tenest" disabled/>
                </div>
              </div>
            </div>
            <div class="col-sm-2 form-group">
              <div class="row">
                <label class="col-sm-8 control-label">Cajas x Estiba:</label>
                <div class="col-sm-3" style="padding-left: 0; padding-right: 0;">
                  <input type="number" class="form-control" ng-model="patron.caest" ng-value="patron.cajten*patron.tenest" disabled/>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="text-center">
              <button class="btn btn-primary" id="submit" type="submit">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/paso7Ctrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
@push('script_custom')
<script type="text/javascript">
  $(document).ready(function() {
    var previewNode = document.getElementById("template");
    previewNode.id = "";
    var previewTemplate = previewNode.outerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(document.body, {
      clickable: "#dropzone",
      url: "storage/app/public/pricat",
      uploadMultiple: false,
      maxFiles: 1,
      maxFilesize: 10,
      thumbnailWidth: 80,
      thumbnailHeight: 80,
      autoProcessQueue: false,
      previewTemplate: previewTemplate,
      previewsContainer: "#previews",
      acceptedFiles: ".jpeg,.jpg,.png,.gif",
      dictDefaultMessage: "Arrastre la imagen aqui o haga click",
      dictMaxFilesExceeded: "Solo está permitido cargar una imagen",
      dictInvalidFileType: "Tipo de archivo inválido"
    });
  });

  Dropzone.autoDiscover = false;
</script>
@endpush
