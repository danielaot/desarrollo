@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso1Ctrl" ng-cloak>
    <form name="paso1Form" ng-submit="paso1Form.$valid && saveProducto($event)" class="form-horizontal" novalidate>
      <div class="panel panel-primary">
        <div class="panel-heading">Descripción Interna Logyca</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-5 form-group">
              <div class="row">
                <label class="col-sm-4 control-label">Referencia:</label>
                <label class="col-sm-6 control-label">{{$referencia}}</label>
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
            <div class="col-sm-5 form-group">
              <div class="row">
                <label class="col-sm-6 control-label">Estado Referencia:</label>
                <div class="col-sm-5">
                  <select class="form-control" ng-model="producto.estadoref" ng-options="opt.descripcionItemCriterioMayor for opt in estadoref track by opt.idItemCriterioMayor"></select>
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
            <div class="col-sm-6">
              <label class="control-label">Uso<span class="required">*</span> :</label>
              <md-autocomplete md-search-text="usoSearchText"
                               md-items="uso in vocabasSearch(usoSearchText)"
                               md-item-text="uso.tvoc_palabra"
                               md-selected-item="producto.uso"
                               md-selected-item-change="createDescripciones()"
                               md-min-length="0"
                               ng-disabled="usodisabled"
                               required>
                <md-item-template>
                  <span md-highlight-text="usoSearchText" md-highlight-flags="^i">@{{uso.tvoc_palabra}}</span>
                </md-item-template>
                <md-not-found>
                  No se encontraron resultados para "@{{usoSearchText}}".
                </md-not-found>
              </md-autocomplete>
            </div>
            <div class="col-sm-6">
              <label class="control-label">Marca<span class="required">*</span> :</label>
              <md-autocomplete md-search-text="marcaSearchText"
                               md-items="marca in marcaSearch(marcaSearchText)"
                               md-item-text="marca.mar_nombre"
                               md-selected-item="producto.marca"
                               md-selected-item-change="createDescripciones()"
                               md-min-length="0"
                               required>
                <md-item-template>
                  <span md-highlight-text="marcaSearchText" md-highlight-flags="^i">@{{marca.mar_nombre}}</span>
                </md-item-template>
                <md-not-found>
                  No se encontraron resultados para "@{{marcaSearchText}}".
                </md-not-found>
              </md-autocomplete>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-6">
              <label class="control-label">Variedad<span class="required">*</span> :</label>
              <md-chips ng-model="producto.variedad" md-require-match="true" md-on-add="createDescripciones()" md-on-remove="createDescripciones()">
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
            <div class="col-sm-6">
              <label class="control-label">Contenido<span class="required">*</span> :</label>
              <div class="row">
                <div class="col-sm-4">
                  <input type="number" class="form-control" ng-model="producto.contenido" ng-change="createDescripciones()" required/>
                </div>
                <div class="col-sm-3">
                  <select class="form-control" ng-model="producto.contum" ng-change="createDescripciones()" required>
                    <option value="art" ng-if="producto.tipo != 'Regular'">art</option>
                    <option value="gr">gr</option>
                    <option value="ml">ml</option>
                    <option value="und">und</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <p class="col-sm-3"><label>Descripción Larga:</label></p>
            <p class="col-sm-5">@{{producto.deslogyca}} <span ng-class="{'has-error':producto.deslogyca.length > 40}">(@{{producto.deslogyca.length}})</span><br>
            <input type="text" class="form-control" ng-show="producto.deslogyca.length > 40" ng-model="descvariedad" ng-change="modifyDescripciones()"/></p>
            <p class="has-error" ng-if="producto.deslogyca.length > 40">Este campo tiene una restricción de 40 caracteres</p>
          </div>
          <div class="row">
            <p class="col-sm-3"><label>Descripción Corta:</label></p>
            <p class="col-sm-5">@{{producto.descorta}} <span ng-class="{'has-error':producto.descorta.length > 18}">(@{{producto.descorta.length}})</span></p>
            <p class="has-error" ng-if="producto.descorta.length >18">Este campo tiene una restricción de 18 caracteres</p>
          </div>
          <div class="row">
            <p class="col-sm-3"><label>Descripción Completa:</label></p>
            <p class="col-sm-5">@{{producto.desbesa}}</p>
          </div>
          <div class="row">
            <div class="col-sm-8 form-group">
              <div class="row">
                <label class="col-sm-3 control-label">Categoría LOGYCA<span class="required">*</span> :</label>
                <div class="col-sm-8">
                  <md-autocomplete md-search-text="categoriaSearchText"
                                   md-items="categoria in categoriaSearch(categoriaSearchText)"
                                   md-item-text="[categoria.tcl_codigo,categoria.tcl_descripcion].join(' - ')"
                                   md-selected-item="producto.catlogyca"
                                   md-min-length="0"
                                   required>
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
        <div class="panel-body" style="padding: 15px 0;">
          <div class="row form-group">
            <div class="col-md-6">
              <label class="col-sm-12 control-label">Origen<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <select class="form-control" ng-model="producto.origen" ng-options="opt.descripcionItemCriterioMayor for opt in origen track by opt.idItemCriterioMayor" required></select>
              </div>
              <label class="col-sm-12 control-label">Tipo Marca<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <select class="form-control" ng-model="producto.tipomarca" ng-options="opt.descripcionItemCriterioMayor for opt in tipomarca track by opt.idItemCriterioMayor" required></select>
              </div>
                <label class="col-sm-12 control-label">Variedad<span class="required">*</span> :</label>
                <div class="col-sm-12">
                  <md-autocomplete md-search-text="variedadbesaSearchText"
                                   md-items="variedadbesa in variedadbesaSearch(variedadbesaSearchText)"
                                   md-item-text="variedadbesa.descripcionItemCriterioMayor"
                                   md-selected-item="producto.variedadbesa"
                                   md-min-length="0"
                                   required
                                   md-menu-class="autocomplete-custom-template">
                    <md-item-template>
                      <span md-highlight-text="variedadbesaSearchText" md-highlight-flags="^i">@{{variedadbesa.descripcionItemCriterioMayor}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{variedadbesaSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
                <label class="col-sm-12 control-label">Linea<span class="required">*</span> :</label>
                <div class="col-sm-12">
                  <select class="form-control" ng-model="producto.linea" ng-options="opt.lineas[0].descripcionItemCriterioMayor for opt in (linea | filter : {mar_nombre : producto.marca.mar_nombre}) track by opt.lineas[0].idItemCriterioMayor" required></select>
                </div>
                <label class="col-sm-12 control-label">Sublinea Mercadeo<span class="required">*</span> :</label>
                <div class="col-sm-12">
                  <md-autocomplete md-search-text="sublinmercadeoSearchText"
                                   md-items="sublinmercadeo in sublinmercadeoSearch(sublinmercadeoSearchText)"
                                   md-item-text="sublinmercadeo.descripcionItemCriterioMayor"
                                   md-selected-item="producto.sublinmercadeo"
                                   md-min-length="0"
                                   required>
                    <md-item-template>
                      <span md-highlight-text="sublinmercadeoSearchText" md-highlight-flags="^i">@{{sublinmercadeo.descripcionItemCriterioMayor}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{sublinmercadeoSearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
                <label class="col-sm-12 control-label">Submarca<span class="required">*</span> :</label>
                <div class="col-sm-12">
                  <select class="form-control" ng-model="producto.submarca" ng-options="opt.descripcionItemCriterioMayor for opt in submarca track by opt.idItemCriterioMayor" required></select>
                </div>
                <div ng-if="producto.tipo != 'Regular'">
                  <label class="col-sm-12 control-label">Tipo Oferta<span class="required">*</span> :</label>
                  <div class="col-sm-12" ng-if="producto.tipo != 'Regular'">
                    <select class="form-control" ng-model="producto.tipooferta" ng-options="opt.descripcionItemCriterioMayor for opt in tipooferta track by opt.idItemCriterioMayor" required></select>
                  </div>
                  <label class="col-sm-12 control-label">Menu de Promociones<span class="required">*</span>:</label>
                  <div class="col-sm-12">
                    <select class="form-control" ng-model="producto.menupromo" ng-options="opt.descripcionItemCriterioMayor for opt in menupromociones track by opt.idItemCriterioMayor" required></select>
                  </div>
                </div>
              <div ng-if="producto.tipo != 'Regular'">
                <label class="col-sm-12 control-label">Ref 2 :</label>
                <div class="col-sm-12">
                  <md-autocomplete md-search-text="item2SearchText"
                                   md-items="item2 in itemSearch(item2SearchText)"
                                   md-item-text="[item2.ite_txt_referencia,item2.ite_txt_descripcion].join(' - ')"
                                   md-selected-item="producto.comp2"
                                   md-min-length="0">
                    <md-item-template>
                      <span md-highlight-text="item2SearchText" md-highlight-flags="^i">@{{[item2.ite_txt_referencia,item2.ite_txt_descripcion].join(' - ')}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{item2SearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
                  <label class="col-sm-12 control-label">Ref 4 :</label>
                  <div class="col-sm-12">
                    <md-autocomplete md-search-text="item4SearchText"
                                     md-items="item4 in itemSearch(item4SearchText)"
                                     md-item-text="[item4.ite_txt_referencia,item4.ite_txt_descripcion].join(' - ')"
                                     md-selected-item="producto.comp4"
                                     md-min-length="0">
                      <md-item-template>
                        <span md-highlight-text="item4SearchText" md-highlight-flags="^i">@{{[item4.ite_txt_referencia,item4.ite_txt_descripcion].join(' - ')}}</span>
                      </md-item-template>
                      <md-not-found>
                        No se encontraron resultados para "@{{item4SearchText}}".
                      </md-not-found>
                    </md-autocomplete>
                  </div>
              </div>
              <div ng-if="producto.tipo != 'Regular'">
                <label class="col-sm-12 control-label">Ref 6 :</label>
                <div class="col-sm-12">
                  <md-autocomplete md-search-text="item6SearchText"
                                   md-items="item6 in itemSearch(item6SearchText)"
                                   md-item-text="[item6.ite_txt_referencia,item6.ite_txt_descripcion].join(' - ')"
                                   md-selected-item="producto.comp6"
                                   md-min-length="0">
                    <md-item-template>
                      <span md-highlight-text="item6SearchText" md-highlight-flags="^i">@{{[item6.ite_txt_referencia,item6.ite_txt_descripcion].join(' - ')}}</span>
                    </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{item6SearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
                <label class="col-sm-12 control-label">Ref 8 :</label>
                <div class="col-sm-12">
                <md-autocomplete md-search-text="item8SearchText"
                                 md-items="item8 in itemSearch(item8SearchText)"
                                 md-item-text="[item8.ite_txt_referencia,item8.ite_txt_descripcion].join(' - ')"
                                 md-selected-item="producto.comp8"
                                 md-min-length="0">
                  <md-item-template>
                    <span md-highlight-text="item8SearchText" md-highlight-flags="^i">@{{[item8.ite_txt_referencia,item8.ite_txt_descripcion].join(' - ')}}</span>
                  </md-item-template>
                    <md-not-found>
                      No se encontraron resultados para "@{{item8SearchText}}".
                    </md-not-found>
                  </md-autocomplete>
                </div>
              </div>
              <div ng-if="producto.tipo == 'Etch.'">
                <label class="col-sm-12 control-label">Año Temporada :</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" ng-model="producto.anotemporada"/>
                </div>
              </div>
              <div ng-if="producto.categoria.cat_txt_descrip == 'Accesorios'">
                <label class="col-sm-12 control-label">Segmento<span class="required">*</span> :</label>
                <div class="col-sm-12">
                  <select class="form-control" ng-model="producto.segmento" ng-options="opt.descripcionItemCriterioMayor for opt in segmento track by opt.idItemCriterioMayor" required></select>
                </div>
              </div>
            </div>
            <!-- fin izquierda -->
            <!-- inicio derecha -->
            <div class="col-md-6">
              <label class="col-sm-12 control-label">Clase<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <select class="form-control" ng-model="producto.clase" ng-options="opt.descripcionItemCriterioMayor for opt in clase track by opt.idItemCriterioMayor" required></select>
              </div>
              <label class="col-sm-12 control-label">Presentación<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <md-autocomplete md-search-text="presentacionSearchText"
                md-items="presentacion in presentacionSearch(presentacionSearchText)"
                md-item-text="presentacion.descripcionItemCriterioMayor"
                md-selected-item="producto.presentacion"
                md-min-length="0"
                required>
                <md-item-template>
                  <span md-highlight-text="presentacionSearchText" md-highlight-flags="^i">@{{presentacion.descripcionItemCriterioMayor}}</span>
                </md-item-template>
                <md-not-found>
                  No se encontraron resultados para "@{{presentacionSearchText}}".
                </md-not-found>
              </md-autocomplete>
            </div>
            <label class="col-sm-12 control-label">Categoria :</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" ng-model="producto.categoria.cat_txt_descrip" disabled>
            </div>
            <label class="col-sm-12 control-label">Sublinea<span class="required">*</span> :</label>
            <div class="col-sm-12">
              <md-autocomplete md-search-text="sublineaSearchText"
                               md-items="sublinea in sublineaSearch(sublineaSearchText)"
                               md-item-text="sublinea.descripcionItemCriterioMayor"
                               md-selected-item="producto.sublinea"
                               md-min-length="0"
                               required>
                <md-item-template>
                  <span md-highlight-text="sublineaSearchText" md-highlight-flags="^i">@{{sublinea.descripcionItemCriterioMayor}}</span>
                </md-item-template>
                <md-not-found>
                  No se encontraron resultados para "@{{sublineaSearchText}}".
                </md-not-found>
              </md-autocomplete>
            </div>
            <label class="col-sm-12 control-label">Sublinea Mercadeo2<span class="required">*</span>:</label>
            <div class="col-sm-12">
              <md-autocomplete md-search-text="sublinmercadeo2SearchText"
                               md-items="sublinmercadeo2 in sublinmercadeo2Search(sublinmercadeo2SearchText)"
                               md-item-text="sublinmercadeo2.descripcionItemCriterioMayor"
                               md-selected-item="producto.sublinmercadeo2"
                               md-min-length="0"
                               required>
                <md-item-template>
                  <span md-highlight-text="sublinmercadeo2SearchText" md-highlight-flags="^i">@{{sublinmercadeo2.descripcionItemCriterioMayor}}</span>
                </md-item-template>
                <md-not-found>
                  No se encontraron resultados para "@{{sublinmercadeo2SearchText}}".
                </md-not-found>
              </md-autocomplete>
            </div>
            <label class="col-sm-12 control-label">Regalias<span class="required">*</span> :</label>
            <div class="col-sm-12">
              <select class="form-control" ng-model="producto.regalias" ng-options="opt.descripcionItemCriterioMayor for opt in regalias track by opt.idItemCriterioMayor" required></select>
            </div>
            <div ng-if="producto.tipo != 'Regular'">
              <label class="col-sm-12 control-label">Tipo Promoción<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <select class="form-control" ng-model="producto.tipopromo" ng-options="opt.descripcionItemCriterioMayor for opt in tipopromocion track by opt.idItemCriterioMayor" required></select>
              </div>
              <label class="col-sm-12 control-label">Ref 1<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <md-autocomplete md-search-text="item1SearchText"
                                 md-items="item1 in itemSearch(item1SearchText)"
                                 md-item-text="[item1.ite_txt_referencia,item1.ite_txt_descripcion].join(' - ')"
                                 md-selected-item="producto.comp1"
                                 md-min-length="0"
                                 required>
                  <md-item-template>
                    <span md-highlight-text="item1SearchText" md-highlight-flags="^i">@{{[item1.ite_txt_referencia,item1.ite_txt_descripcion].join(' - ')}}</span>
                  </md-item-template>
                  <md-not-found>
                    No se encontraron resultados para "@{{item1SearchText}}".
                  </md-not-found>
                </md-autocomplete>
              </div>
            </div>
            <div ng-if="producto.tipo != 'Regular'">
              <label class="col-sm-12 control-label">Ref 3 :</label>
              <div class="col-sm-12">
                <md-autocomplete md-search-text="item3SearchText"
                                 md-items="item3 in itemSearch(item3SearchText)"
                                 md-item-text="[item3.ite_txt_referencia,item3.ite_txt_descripcion].join(' - ')"
                                 md-selected-item="producto.comp3"
                                 md-min-length="0">
                  <md-item-template>
                    <span md-highlight-text="item3SearchText" md-highlight-flags="^i">@{{[item3.ite_txt_referencia,item3.ite_txt_descripcion].join(' - ')}}</span>
                  </md-item-template>
                  <md-not-found>
                    No se encontraron resultados para "@{{item3SearchText}}".
                  </md-not-found>
                </md-autocomplete>
              </div>

              <label class="col-sm-12 control-label">Ref 5 :</label>
              <div class="col-sm-12">
                <md-autocomplete md-search-text="item5SearchText"
                                 md-items="item5 in itemSearch(item5SearchText)"
                                 md-item-text="[item5.ite_txt_referencia,item5.ite_txt_descripcion].join(' - ')"
                                 md-selected-item="producto.comp5"
                                 md-min-length="0">
                  <md-item-template>
                    <span md-highlight-text="item5SearchText" md-highlight-flags="^i">@{{[item5.ite_txt_referencia,item5.ite_txt_descripcion].join(' - ')}}</span>
                  </md-item-template>
                  <md-not-found>
                    No se encontraron resultados para "@{{item5SearchText}}".
                  </md-not-found>
                </md-autocomplete>
              </div>
            </div>
            <div ng-if="producto.tipo != 'Regular'">
              <label class="col-sm-12 control-label">Ref 7 :</label>
              <div class="col-sm-12">
                <md-autocomplete md-search-text="item7SearchText"
                                 md-items="item7 in itemSearch(item7SearchText)"
                                 md-item-text="[item7.ite_txt_referencia,item7.ite_txt_descripcion].join(' - ')"
                                 md-selected-item="producto.comp7"
                                 md-min-length="0">
                  <md-item-template>
                    <span md-highlight-text="item7SearchText" md-highlight-flags="^i">@{{[item7.ite_txt_referencia,item7.ite_txt_descripcion].join(' - ')}}</span>
                  </md-item-template>
                  <md-not-found>
                    No se encontraron resultados para "@{{item7SearchText}}".
                  </md-not-found>
                </md-autocomplete>
              </div>
            </div>
            <div ng-if="producto.tipo == 'Etch.'">
              <label class="col-sm-12 control-label">Nombre Temporada<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <select class="form-control" ng-model="producto.nomtemporada" ng-options="opt.descripcionItemCriterioMayor for opt in nomtemporada track by opt.idItemCriterioMayor" required></select>
              </div>
            </div>
            <div ng-if="producto.categoria.cat_txt_descrip == 'Accesorios'">
              <label class="col-sm-12 control-label">Acondicionamiento<span class="required">*</span> :</label>
              <div class="col-sm-12">
                <select class="form-control" ng-model="producto.acondicionamiento" ng-options="opt.descripcionItemCriterioMayor for opt in acondicionamiento track by opt.idItemCriterioMayor" required></select>
              </div>
            </div>
          </div>
          <!-- fin derecha -->
          </div>
        </div>
      </div>
      <div class="panel panel-primary">
        <div class="panel-heading">Fecha de Captura de Medidas</div>
        <div class="panel-body">
          <div class="row form-group">
            <label class="col-sm-2 control-label">Fecha de Captura<span class="required">*</span> :</label>
            <div class="col-sm-4">
              <input type="date" class="form-control" ng-model="captura" min="@{{hoy}}" required/>
            </div>
          </div>
          <div class="row">
            <div class="text-center">
              <input type="hidden" ng-model="producto.proy" ng-init="producto.proy = {{$idproyecto}}"/>
              <input type="hidden" ng-model="producto.act" ng-init="producto.act = {{$idactividad}}"/>
              <button class="btn btn-primary" type="submit">Solicitar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/pricat/paso1Ctrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
