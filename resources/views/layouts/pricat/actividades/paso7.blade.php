@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso7Ctrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <form name="paso4Form" ng-submit="paso4Form.$valid" class="form-horizontal">
          {!! Form::token() !!}
          <div class="row">
            <div class="col-sm-5 form-group">
              <label class="col-sm-6 control-label">Tipo de Empaque:</label>
              <div class="col-sm-6">
                <md-autocomplete md-search-text="searchText" md-selected-item-change="selectedItemChange(item)"
                                 md-items="item in querySearch(searchText)" md-item-text="item.tvoc_palabra" md-min-length="1">
                  <md-item-template>
                    <span md-highlight-text="searchText" md-highlight-flags="^i">@{{item.tvoc_palabra}}</span>
                  </md-item-template>
                  <md-not-found>
                    No se encontraron resultados para "@{{searchText}}".
                  </md-not-found>
                </md-autocomplete>
              </div>
            </div>
            <div class="col-sm-7 form-group">
              <label class="col-sm-6 control-label">Cantidad de Embalaje:</label>
              <div class="col-sm-5">
                <div class="input-group">
                  <input type="text" class="form-control" ng-model="producto.cantemb" maxlength="3"/>
                  <div class="input-group-addon">unidades</div>
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
          <div class="row">
            <div class="col-sm-4 form-group">
              <label class="col-sm-6 control-label">Tipo de Embalaje:</label>
              <div class="col-sm-6">
                <select class="form-control" ng-model="producto.tembalaje" ng-options="option.temb_nombre for option in tembalaje track by option.id"></select>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <label class="col-sm-6 control-label">Número de tendidos:</label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input type="text" class="form-control" ng-model="producto.numtendidos" maxlength="3"/>
                  <div class="input-group-addon">unidades</div>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <label class="col-sm-6 control-label">Numero de unidades apilables de embalaje:</label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input type="text" class="form-control" ng-model="producto.numuniapi" maxlength="3"/>
                  <div class="input-group-addon">unidades</div>
                </div>
              </div>
            </div>
          </div>
          Descripcion Embalaje Larga <br>
          Descripcion Embalaje Corta <br>
          <div class="row">
            <div class="col-sm-6 form-group">
              <label class="col-sm-4 control-label">¿Tiene SubEmpaque?</label>
              <div class="col-sm-4">
                <select class="form-control" ng-model="producto.hasSubEmp">
                  <option value="true">Si</option>
                  <option value="">No</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 form-group">
              <label class="control-label">Medidas del Producto</label>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Alto:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="producto.alto"/>
                <div class="input-group-addon">mm</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Ancho:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="producto.ancho"/>
                <div class="input-group-addon">mm</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Profundo:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="producto.profundo"/>
                <div class="input-group-addon">mm</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Volumen:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="producto.volumen" ng-value="producto.alto*producto.ancho*producto.profundo" disabled/>
                <div class="input-group-addon">mm<sup>3</sup></div>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Peso Bruto:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="producto.pesobruto"/>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Peso Neto:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="producto.pesoneto"/>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Tara:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="producto.tara" ng-value="producto.pesoneto-producto.pesobruto" disabled/>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-sm-12 form-group">
              <label class="control-label">Medidas del Empaque</label>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Alto:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="empaque.alto"/>
                <div class="input-group-addon">mm</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Ancho:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="empaque.ancho"/>
                <div class="input-group-addon">mm</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Profundo:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="empaque.profundo"/>
                <div class="input-group-addon">mm</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Volumen:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="empaque.volumen" ng-value="empaque.alto*empaque.ancho*empaque.profundo" disabled/>
                <div class="input-group-addon">mm<sup>3</sup></div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Peso Bruto:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="empaque.pesobruto"/>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Peso Neto:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="empaque.pesoneto"/>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
            <div class="col-sm-3">
              <label class="col-sm-5 control-label">Tara:</label>
              <div class="input-group">
                <input type="number" class="col-sm-6 form-control" ng-model="empaque.tara" ng-value="empaque.pesoneto-empaque.pesobruto" disabled/>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
          </div>
          Condiciones de Manipulacion <br>
          <div class="row">
            <div class="text-center form-group">
              <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/paso7Ctrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
