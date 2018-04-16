@extends('app')

@section('content')
  @include('includes.titulo')
  <div id="medidas" ng-controller="paso6Ctrl" ng-init="getInfo()" ng-cloak>
    <form name="paso6Form" ng-submit="saveProducto()" class="form-horizontal" enctype="multipart/form-data" novalidate>
      <div class="panel panel-primary">
        <div class="panel-heading">Información del Producto</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-12">
                  <h4>{{$item['ite_referencia']}} - {{$item['detalles']['ide_descompleta']}}</h4>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <h4>EAN13: {{$item['ite_ean13']}}</h4>
            </div>
            <div class="col-sm-3">
              <h4>EAN14: {{$item['eanes'][0]['iea_ean']}}</h4>
            </div>
          </div>
          <br>
          <div class="row">
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
                <label class="col-sm-6 control-label">Tipo de Empaque:</label>
                <div class="col-sm-5">
                  <select class="form-control" ng-model="producto.tempaque" ng-options="opt.temp_nombre for opt in tempaque track by opt.temp_calificador" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-7 control-label" style="padding-top: 0;">Condiciones de Manipulacion:</label>
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
                <p class="col-sm-4"><label>Descripción Larga: </label></p>
                <p class="col-sm-8">@{{producto.tembalaje.temb_abreviatura}} {{$deslarga}}@{{producto.cantemb}}art</p>
              </div>
              <div class="row">
                <p class="col-sm-4"><label>Descripción Corta: </label></p>
                <p class="col-sm-8">@{{producto.tembalaje.temb_abreviatura}} {{$descorta}}@{{producto.cantemb}}art</p>
              </div>
            </div>
            <div class="col-sm-6 form-group">
              <input file-model="imagen" type="file" class="form-control" accept=".png, .jpg, .jpeg"/>
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
                  <input type="number" class="form-control" ng-model="producto.alto" min="0" required/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Ancho:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.ancho" min="0" required/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Profundo:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.profundo" min="0" required/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Volumen:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.volumen" ng-value="producto.alto*producto.ancho*producto.profundo" min="0" readonly/>
                  <div class="input-group-addon">mm<sup>3</sup></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Bruto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.pesobruto" min="0" required/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Neto:</label>
                <div class="col-sm-6 input-group">
                  <input ng-if="pesoneto == ''" type="number" class="form-control" ng-model="producto.pesoneto" min="0" required/>
                  <input type="number" class="form-control" ng-model="producto.pesoneto" ng-init="producto.pesoneto = {{$pesoneto}}" min="0" required/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Tara:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="producto.tara" ng-value="producto.pesobruto-producto.pesoneto" readonly/>
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
                  <input type="number" class="form-control" ng-model="empaque.alto" min="0" required/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Ancho:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.ancho" min="0" required/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Profundo:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.profundo" min="0" required/>
                  <div class="input-group-addon">mm</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Volumen:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.volumen" ng-value="empaque.alto*empaque.ancho*empaque.profundo" min="0" readonly/>
                  <div class="input-group-addon">mm<sup>3</sup></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Bruto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.pesobruto" min="0" required/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Peso Neto:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.pesoneto" ng-value="producto.cantemb*producto.pesoneto" ng-init="empaque.pesoneto = {{$pesoneto*$item['eanes'][0]['iea_cantemb']}}" min="0" required/>
                  <div class="input-group-addon">Kg</div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Tara:</label>
                <div class="col-sm-6 input-group">
                  <input type="number" class="form-control" ng-model="empaque.tara" ng-value="empaque.pesobruto-(producto.cantemb*producto.pesoneto)" readonly/>
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
                    <input type="text" class="form-control" ng-model="producto.cantemb" maxlength="3" ng-init="producto.cantemb = {{$item['eanes'][0]['iea_cantemb']}}" required/>
                    <div class="input-group-addon">unds</div>
                  </div>
                </div>
                <div class="col-sm-1">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" ng-model="confirm" value="1"/>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Tendidos x Caja:</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" ng-model="patron.numtendidos" maxlength="3" min="0"/>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Cajas x Tendido:</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" ng-model="patron.cajten" min="0"/>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Tendidos x Estiba:</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" ng-model="patron.tenest" min="0"/>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Unds x Tendido:</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" ng-model="patron.undten" ng-value="producto.cantemb*patron.cajten" min="0" readonly/>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Unds x Estiba:</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" ng-model="patron.undest" ng-value="producto.cantemb*patron.cajten*patron.tenest" readonly/>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Cajas x Estiba:</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" ng-model="patron.caest" ng-value="patron.cajten*patron.tenest" min="0" readonly/>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="text-center">
              <input type="hidden" ng-model="producto.proy" ng-init="producto.proy = {{$idproyecto}}"/>
              <input type="hidden" ng-model="producto.act" ng-init="producto.act = {{$idactividad}}"/>
              <input type="hidden" ng-model="producto.item" ng-init="producto.item = {{$item['id']}}"/>
              <input type="hidden" ng-model="producto.ref" ng-init="producto.ref = {{$item['ite_referencia']}}"/>
              <button class="btn btn-primary" id="submit" type="submit">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/paso6Ctrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
@push('script_after')
  <script>
    $("#imagen").fileinput({
      language: 'es',
      uploadUrl: '#',
      theme: "explorer",
      allowedFileExtensions: ['jpg', 'png', 'gif']
    });
  </script>
@endpush
