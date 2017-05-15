@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso1Ctrl" ng-cloak>
    <form name="paso1Form" ng-submit="paso1Form.$valid && saveProducto()" class="form-horizontal" novalidate>
      <div class="panel panel-primary">
        <div class="panel-heading">Descripción Interna Logyca</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-5 form-group">
              <div class="row">
                <label class="col-sm-4 control-label">Referencia:</label>
                <label class="col-sm-6 control-label">@{{referencia}}</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Tipo de Producto:</label>
                <div class="col-sm-5">
                  <select class="form-control" ng-model="producto.tipo" ng-change="validateTipo()">
                    <option value="Regular">Regular</option>
                    <option value="Etch.">Estuche</option>
                    <option value="Oft.">Oferta</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-7 form-group">
              <div class="row">
                <label class="col-sm-4 control-label">¿Tiene EAN Definido?</label>
                <div class="col-sm-2">
                  <select class="form-control" ng-model="producto.hasEan">
                    <option value="true">Si</option>
                    <option value="">No</option>
                  </select>
                </div>
                <div class="col-sm-5">
                  <input type="text" class="form-control" ng-model="producto.ean" ng-if="producto.hasEan == 'true'"/>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Uso<span class="required">*</span> :</label>
                  <md-autocomplete md-search-text="usoSearchText"
                                   md-items="uso in vocabasSearch(usoSearchText)"
                                   md-item-text="uso.tvoc_palabra"
                                   md-selected-item="producto.uso"
                                   md-selected-item-change="createDescripciones()"
                                   md-min-length="1"
                                   ng-disabled="usodisabled">
                    <md-item-template>
                      <span md-highlight-text="usoSearchText" md-highlight-flags="^i">@{{uso.tvoc_palabra}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{usoSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Marca<span class="required">*</span> :</label>
                  <md-autocomplete md-search-text="marcaSearchText"
                                   md-items="marca in marcaSearch(marcaSearchText)"
                                   md-item-text="marca.mar_nombre"
                                   md-selected-item="producto.marca"
                                   md-selected-item-change="createDescripciones()"
                                   md-min-length="1">
                    <md-item-template>
                      <span md-highlight-text="marcaSearchText" md-highlight-flags="^i">@{{marca.mar_nombre}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{marcaSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Variedad<span class="required">*</span> :</label>
                  <md-chips ng-model="producto.variedad" md-require-match="true" md-on-add="createDescripciones()">
                    <md-autocomplete md-search-text="variedadSearchText"
                                     md-items="variedad in vocabasSearch(variedadSearchText)"
                                     md-item-text="variedad.tvoc_palabra"
                                     md-no-cache="true"
                                     md-min-length="0">
                      <md-item-template>
                        <span md-highlight-text="variedadSearchText">@{{variedad.tvoc_palabra}}</span>
                      </md-item-template>
                    </md-autocomplete>
                    <md-chip-template>
                      <span>@{{$chip.tvoc_palabra}}</span>
                    </md-chip-template>
                  </md-chips>
                </div>
              </div>
              <br>
              <div class="row">
                <label class="col-sm-12 control-label">Contenido<span class="required">*</span> :</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" ng-model="producto.contenido" ng-change="createDescripciones()" required/>
                </div>
                <div class="col-sm-3">
                  <select class="form-control" ng-model="producto.contum" ng-change="createDescripciones()" required>
                    <option value="art">art</option>
                    <option value="gr">gr</option>
                    <option value="ml">ml</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Descripción Larga:</label><br>
                  <p>@{{producto.deslogyca}}</p>
                  <span>@{{producto.deslogyca.length}}</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Descripción Corta:</label><br>
                  <p>@{{producto.descorta}}</p>
                  <span>@{{producto.descorta.length}}</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Descripción Completa BESA:</label><br>
                  <p>@{{producto.desbesa}}</p>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-8 form-group">
              <div class="row">
                <label class="col-sm-3 control-label">Categoría LOGYCA<span class="required">*</span> :</label>
                <div class="col-sm-8">
                  <md-autocomplete md-search-text="categoriaSearchText"
                                   md-items="categoria in categoriaSearch(categoriaSearchText)"
                                   md-item-text="categoria.tcl_descripcion"
                                   md-selected-item="producto.catlogyca"
                                   md-min-length="1">
                    <md-item-template>
                      <span md-highlight-text="categoriaSearchText" md-highlight-flags="^i">@{{[categoria.tcl_codigo,categoria.tcl_descripcion].join(' - ')}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{categoriaSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Cantidad Embalaje<span class="required">*</span> :</label>
                <div class="col-sm-5 input-group">
                  <input type="number" class="form-control" ng-model="producto.embalaje" maxlength="3" required/>
                  <div class="input-group-addon">unds</div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Nombre del Fabricante<span class="required">*</span> :</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" ng-model="producto.fabricante" required/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-primary interno">
        <div class="panel-heading">Información Clasificación Interna</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-3 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Origen<span class="required">*</span> :</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.origen" ng-options="opt.descripcionItemCriterioMayor for opt in origen track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-2 form-group">
              <div class="row">
                <label class="col-sm-8 control-label">Tipo Marca<span class="required">*</span>:</label>
                <div class="col-sm-4">
                  <select class="form-control" ng-model="producto.tipomarca" ng-options="opt.descripcionItemCriterioMayor for opt in tipomarca track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group" ng-if="producto.tipo != 'Regular'">
              <div class="row">
                <label class="col-sm-5 control-label">Tipo Oferta<span class="required">*</span> :</label>
                <div class="col-sm-7">
                  <select class="form-control" ng-model="producto.tipooferta" ng-options="opt.descripcionItemCriterioMayor for opt in tipooferta track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group" ng-if="producto.tipo != 'Regular'">
              <div class="row">
                <label class="col-sm-9 control-label">Menu de Promociones<span class="required">*</span> :</label>
                <div class="col-sm-3">
                  <select class="form-control" ng-model="producto.menupromo" ng-options="opt.descripcionItemCriterioMayor for opt in menupromociones track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-3 form-group" ng-if="producto.tipo != 'Regular'">
              <div class="row">
                <label class="col-sm-7 control-label">Tipo Promoción<span class="required">*</span>:</label>
                <div class="col-sm-5">
                  <select class="form-control" ng-model="producto.tipopromo" ng-options="opt.descripcionItemCriterioMayor for opt in tipopromocion track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-5 form-group">
              <div class="row">
                <label class="col-sm-4 control-label">Presentación<span class="required">*</span> :</label>
                <div class="col-sm-8">
                  <select class="form-control" ng-model="producto.presentacion" ng-options="opt.descripcionItemCriterioMayor for opt in presentacion track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-4 control-label">Variedad<span class="required">*</span> :</label>
                <div class="col-sm-8">
                  <select class="form-control" ng-model="producto.variedadbesa" ng-options="opt.descripcionItemCriterioMayor for opt in variedad track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-4 control-label">Categoria :</label>
                <label class="col-sm-8 control-label">@{{producto.categoria}}</label>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-3 control-label">Linea<span class="required">*</span> :</label>
                <div class="col-sm-9">
                  <select class="form-control" ng-model="producto.linea" ng-options="opt.lineas[0].descripcionItemCriterioMayor for opt in (linea | filter : {mar_nombre : producto.marca.mar_nombre}) track by opt.lineas[0].idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Sublinea<span class="required">*</span> :</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.sublinea" ng-options="opt.descripcionItemCriterioMayor for opt in sublinea track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Sublinea Mercadeo:</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.sublinmercadeo" ng-options="opt.descripcionItemCriterioMayor for opt in sublinmercadeo track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Sublinea Mercadeo 2:</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.sublinmercadeo2" ng-options="opt.descripcionItemCriterioMayor for opt in sublinmercadeo2 track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-5 control-label">Submarca<span class="required">*</span> :</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.submarca" ng-options="opt.descripcionItemCriterioMayor for opt in submarca track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Regalias:</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.regalias" ng-options="opt.descripcionItemCriterioMayor for opt in regalias track by opt.idItemCriterioMayor"></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group" ng-if="producto.categoria == 'Accesorios'">
              <div class="row">
                <label class="col-sm-6 control-label">Segmento<span class="required">*</span> :</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.segmento" ng-options="opt.descripcionItemCriterioMayor for opt in segmento track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group" ng-if="producto.categoria == 'Accesorios'">
              <div class="row">
                <label class="col-sm-5 control-label">Clasificación<span class="required">*</span> :</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.clasificacion" ng-options="opt.descripcionItemCriterioMayor for opt in clasificacion track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <div class="col-sm-4 form-group" ng-if="producto.categoria == 'Accesorios'">
              <div class="row">
                <label class="col-sm-6 control-label">Acondicionamiento<span class="required">*</span> :</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.acondicionamiento" ng-options="opt.descripcionItemCriterioMayor for opt in acondicionamiento track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>

            <!--div class="col-sm-4 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Referencia Homóloga:</label>
                <div class="col-sm-6">
                  <select class="form-control" ng-model="producto.refhomo"></select>
                </div>
              </div>
            </div-->
          </div>
          <br>
          <div class="row">
            <div class="text-center">
              {!! Form::hidden('idproyecto', $idproyecto, ['ng-model' => 'proyecto']) !!}
              <button class="btn btn-primary" type="submit">Solicitar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/paso1Ctrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
