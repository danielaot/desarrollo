<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;" role="document">
    <div class="modal-content panel-primary">
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Detalle Referencia - @{{referencia.ite_referencia}}</h4>
      </div>
      <div class="modal-body">
        <md-tabs md-dynamic-height md-border-bottom>
          <!-- inicio paso 1 -->
          <md-tab label="Creación de Item">
            <md-content class="md-padding">
              <div class="table-responsive">
                <div class="panel panel-primary interno">
                <div class="panel-heading">Descripción Interna Logyca</div>
                <div class="panel-body">
                  <div class="row">
                        <label class="col-sm-3 control-label">Referencia:</label>
                        <label class="col-sm-5 control-label">@{{referencia.ite_referencia}}</label>
                  </div>
                  <div class="row">
                    <p class="col-sm-3"><label>Tipo de Producto:</label></p>
                    <p class="col-sm-5">@{{referencia.tipo.descripcionItemCriterioMayor}}</p><br>
                  </div>
                  <div class="row">
                    <p class="col-sm-3"><label>Contenido:</label></p>
                    <p class="col-sm-5">@{{referencia.detalles.ide_contenido}} @{{referencia.detalles.ide_umcont}}</p><br>
                  </div>
                  <div class="row">
                    <p class="col-sm-3"><label>Descripción Larga:</label></p>
                    <p class="col-sm-5">@{{referencia.detalles.ide_deslarga}}</p><br>
                  </div>
                  <div class="row">
                    <p class="col-sm-3"><label>Descripción Corta:</label></p>
                    <p class="col-sm-5">@{{referencia.detalles.ide_descorta}}</p><br>
                  </div>
                  <div class="row">
                    <p class="col-sm-3"><label>Descripción Completa:</label></p>
                    <p class="col-sm-7">@{{referencia.detalles.ide_descompleta}}</p><br>
                  </div>
                  <div class="row">
                    <p class="col-sm-3"><label>Categoría LOGYCA:</label></p>
                    <p class="col-sm-5">@{{referencia.detalles.logcategorias.tcl_codigo}} - @{{referencia.detalles.logcategorias.tcl_descripcion}}</p><br>
                  </div>
                  <div class="row">
                    <p class="col-sm-3"><label>Nombre del Fabricante:</label></p>
                    <p class="col-sm-5">@{{referencia.detalles.ide_nomfab}}</p><br>
                  </div>
                </div>
              </div>
            </div>
              <div class="panel panel-primary interno">
                <div class="panel-heading">Información Clasificación Interna</div>
                <div class="panel-body" style="padding: 15px 0;">
                  <div class="row form-group">
                    <div class="col-md-6">
                      <label class="col-sm-12 control-label">Origen :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.origen" disabled>
                      </div>
                      <label class="col-sm-12 control-label">Tipo Marca :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.tipomarca" disabled>
                      </div>
                        <label class="col-sm-12 control-label">Variedad :</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" ng-model="producto.variedad" disabled>
                        </div>
                        <label class="col-sm-12 control-label">Linea :</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" ng-model="producto.linea" disabled>
                        </div>
                        <label class="col-sm-12 control-label">Sublinea Mercadeo :</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" ng-model="producto.sublinmercadeo" disabled>
                        </div>
                        <label class="col-sm-12 control-label">Submarca :</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" ng-model="producto.submarca" disabled>
                        </div>
                        <div ng-if="producto.tipo != 1301">
                          <label class="col-sm-12 control-label">Tipo Oferta :</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" ng-model="producto.tipooferta" disabled>
                          </div>
                          <label class="col-sm-12 control-label">Menu de Promociones<span class="required">*</span>:</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" ng-model="producto.menupromo" disabled>
                          </div>
                        </div>
                      <div ng-if="producto.tipo != '1301'">
                        <label class="col-sm-12 control-label">Ref 2 :</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" ng-model="producto.menupromo" disabled>
                        </div>
                          <label class="col-sm-12 control-label">Ref 4 :</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" ng-model="producto.menupromo" disabled>
                          </div>
                      </div>
                      <div ng-if="producto.tipo != '1301'">
                        <label class="col-sm-12 control-label">Ref 6 :</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" ng-model="producto.menupromo" disabled>
                        </div>
                        <label class="col-sm-12 control-label">Ref 8 :</label>
                        <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.menupromo" disabled>
                        </div>
                      </div>
                      <div ng-if="producto.tipo == '1306'">
                        <label class="col-sm-12 control-label">Año Temporada :</label>
                        <div class="col-sm-12">
                          <input type="number" class="form-control" ng-model="producto.anotemporada"/>
                        </div>
                      </div>
                      <div ng-if="producto.categoria.cat_txt_descrip == 'Accesorios'">
                        <label class="col-sm-12 control-label">Segmento<span class="required">*</span> :</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" ng-model="producto.menupromo" disabled>
                        </div>
                      </div>
                    </div>
                    <!-- fin izquierda -->
                    <!-- inicio derecha -->
                    <div class="col-md-6">
                      <label class="col-sm-12 control-label">Clase<span class="required">*</span> :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.clase" disabled>
                      </div>
                      <label class="col-sm-12 control-label">Presentación:</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.presentacion" disabled>
                    </div>
                    <label class="col-sm-12 control-label">Categoria :</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" ng-model="producto.categoria" disabled>
                    </div>
                    <label class="col-sm-12 control-label">Sublinea<span class="required">*</span> :</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" ng-model="producto.sublinea" disabled>
                    </div>
                    <label class="col-sm-12 control-label">Sublinea Mercadeo2<span class="required">*</span>:</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" ng-model="producto.submercadeo2" disabled>
                    </div>
                    <label class="col-sm-12 control-label">Regalias<span class="required">*</span> :</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" ng-model="producto.regalias" disabled>
                    </div>
                    <div ng-if="producto.tipo != '1301'">
                      <label class="col-sm-12 control-label">Tipo Promoción<span class="required">*</span> :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.tpromocion" disabled>
                      </div>
                      <label class="col-sm-12 control-label">Ref 1<span class="required">*</span> :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.ref1" disabled>
                      </div>
                    </div>
                    <div ng-if="producto.tipo != '1301'">
                      <label class="col-sm-12 control-label">Ref 3 :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.ref3" disabled>
                      </div>

                      <label class="col-sm-12 control-label">Ref 5 :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.ref5" disabled>
                      </div>
                    </div>
                    <div ng-if="producto.tipo != '1301'">
                      <label class="col-sm-12 control-label">Ref 7 :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.ref7" disabled>
                      </div>
                    </div>
                    <div ng-if="producto.tipo == '1306'">
                      <label class="col-sm-12 control-label">Nombre Temporada<span class="required">*</span> :</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" ng-model="producto.nomtemporada" disabled>
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
                </div>
              </div>
            </md-content>
          </md-tab>
          <!-- fin paso 1 -->
          <!-- inicio paso 4 -->
          <md-tab label="Posición Arancelaria">
            <md-content class="md-padding">
              <div class="row">
                <div class="col-sm-4">
                  <div class="row">
                    <label class="col-sm-4">Referencia :</label>
                    <p class="col-sm-8">@{{referencia.ite_referencia}}</p>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-3">Descripción :</label>
                    <p class="col-sm-9">@{{referencia.detalles.ide_descompleta}}</p>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-4">
                  <div class="row">
                    <label class="col-sm-4">Categoria :</label>
                    <p class="col-sm-8">@{{referencia.detalles.ide_categoria}} - @{{referencia.detalles.categoria.descripcionItemCriterioMayor}}</p>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="row">
                    <label class="col-sm-3">Línea :</label>
                    <p class="col-sm-9">@{{referencia.detalles.ide_linea}} - @{{referencia.detalles.linea.descripcionItemCriterioMayor}}</p>
                  </div>
                </div>
              </div>
                <br>
                <div class="col-sm-12" ng-if = "referencia.tipo.descripcionItemCriterioMayor != 'Regular'">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 1 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp1}}</p>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 2 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp2}}</p>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 3 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp3}}</p>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 4 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp4}}</p>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row">
                  <label class="col-sm-3">Posición Arancelaria :</label>
                    <p class="col-sm-6">@{{referencia.detalles.posicionarancelaria.id_pos_arancelaria}} - @{{referencia.detalles.posicionarancelaria.desc_pos_arancelaria}}</p>
                </div>
            </md-content>
          </md-tab>
          <!-- fin paso 4 -->
          <!-- inicio paso 5 -->
          <md-tab label="Grupo Impositivo">
            <md-content class="md-padding">
              <div class="row">
                <div class="col-sm-4">
                  <div class="row">
                    <label class="col-sm-4">Referencia :</label>
                    <p class="col-sm-8">@{{referencia.ite_referencia}}</p>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <label class="col-sm-3">Descripción :</label>
                    <p class="col-sm-9">@{{referencia.detalles.ide_descompleta}}</p>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-4">
                  <div class="row">
                    <label class="col-sm-4">Categoria :</label>
                    <p class="col-sm-8">@{{referencia.detalles.ide_categoria}} - @{{referencia.detalles.categoria.descripcionItemCriterioMayor}}</p>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="row">
                    <label class="col-sm-3">Línea :</label>
                    <p class="col-sm-9">@{{referencia.detalles.ide_linea}} - @{{referencia.detalles.linea.descripcionItemCriterioMayor}}</p>
                  </div>
                </div>
              </div>
                <br>
                <div class="col-sm-12" ng-if = "referencia.tipo.descripcionItemCriterioMayor != 'Regular'">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 1 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp1}}</p>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 2 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp2}}</p>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 3 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp3}}</p>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="row">
                      <label class="col-sm-6">Componente 4 :</label>
                      <p class="col-sm-6">@{{referencia.detalles.ide_comp4}}</p>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row">
                  <label class="col-sm-3">Posición Arancelaria :</label>
                    <p class="col-sm-6">@{{referencia.detalles.posicionarancelaria.id_pos_arancelaria}} - @{{referencia.detalles.posicionarancelaria.desc_pos_arancelaria}}</p>
                </div>
                <div class="row">
                  <label class="col-sm-3">Grupo Impositivo :</label>
                    <p class="col-sm-6">@{{referencia.detalles.grupoimpositivo.cod_grupoimpo}} - @{{referencia.detalles.grupoimpositivo.desc_grupoimpo}}</p>
                </div>
            </md-content>
          </md-tab>
          <!-- fin paso 5 -->
          <!-- inicio paso 6 -->
          <md-tab label="Medidas del Producto">
            <md-content class="md-padding">
              <div class="panel panel-primary">
                <div class="panel-heading">Información del Producto</div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-12">
                          <h4>@{{referencia.ite_referencia}} - @{{referencia.detalles.ide_descompleta}}</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <h4>EAN13: @{{referencia.ite_ean13}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4>EAN14: @{{referencia.eanes[0]['iea_ean']}}</h4>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-4 form-group">
                      <div class="row">
                        <label class="col-sm-6 control-label">Tipo de Embalaje:</label>
                        <div class="col-sm-5">
                          <p>@{{referencia.eanppal.tembalaje.temb_nombre}}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 form-group">
                      <div class="row">
                        <label class="col-sm-6 control-label">Tipo de Empaque:</label>
                        <div class="col-sm-5">
                          <p>@{{referencia.detalles.tipoempaque.temp_nombre}}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 form-group">
                      <div class="row">
                        <label class="col-sm-7 control-label" style="padding-top: 0;">Condiciones de Manipulacion:</label>
                        <div class="col-sm-5">
                          <p>@{{referencia.detalles.condmanipulacion.tcman_nombre}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <div class="row">
                        <p class="col-sm-4"><label>Descripción Larga: </label></p>
                        <p class="col-sm-6">@{{referencia.detalles.ide_deslarga}}</p>
                      </div>
                      <div class="row">
                        <p class="col-sm-4"><label>Descripción Corta: </label></p>
                        <p class="col-sm-6">@{{referencia.detalles.ide_descorta}}</p>
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
                              <input type="text" class="form-control" ng-model="producto.alto" disabled>
                              <div class="input-group-addon">mm</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Ancho:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="producto.ancho" disabled>
                              <div class="input-group-addon">mm</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Profundo:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="producto.profundo" disabled>
                              <div class="input-group-addon">mm</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Volumen:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="producto.volumen" disabled>
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
                              <input type="text" class="form-control" ng-model="producto.pesobruto" disabled>
                              <div class="input-group-addon">Kg</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Peso Neto:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="producto.pesoneto" disabled>
                              <div class="input-group-addon">Kg</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Tara:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="producto.tara" disabled>
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
                              <input type="text" class="form-control" ng-model="empaque.alto" disabled>
                              <div class="input-group-addon">mm</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Ancho:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="empaque.ancho" disabled>
                              <div class="input-group-addon">mm</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Profundo:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="empaque.profundo" disabled>
                              <div class="input-group-addon">mm</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Volumen:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="empaque.volumen" disabled>
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
                              <input type="text" class="form-control" ng-model="empaque.pesobruto" disabled>
                              <div class="input-group-addon">Kg</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Peso Neto:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="empaque.pesoneto" disabled>
                              <div class="input-group-addon">Kg</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3 form-group">
                          <div class="row">
                            <label class="col-sm-5 control-label">Tara:</label>
                            <div class="col-sm-6 input-group">
                              <input type="text" class="form-control" ng-model="empaque.tara" disabled>
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
                                <input type="text" class="form-control" ng-model="producto.cantemb" disabled>
                                <div class="input-group-addon">unds</div>
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
                              <input type="text" class="form-control" ng-model="patron.numtendidos" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 form-group">
                          <div class="row">
                            <label class="col-sm-6 control-label">Cajas x Tendido:</label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" ng-model="patron.cajten" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 form-group">
                          <div class="row">
                            <label class="col-sm-6 control-label">Tendidos x Estiba:</label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" ng-model="patron.tenest" disabled>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4 form-group">
                          <div class="row">
                            <label class="col-sm-6 control-label">Unds x Tendido:</label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" ng-model="patron.undten" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 form-group">
                          <div class="row">
                            <label class="col-sm-6 control-label">Unds x Estiba:</label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" ng-model="patron.undest" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 form-group">
                          <div class="row">
                            <label class="col-sm-6 control-label">Cajas x Estiba:</label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control" ng-model="patron.caest" disabled>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </md-content>
        </md-tab>
          <!-- fin paso 6 -->
          <!-- inicio paso 6 -->
          <md-tab label="Registro Sanitario">
            <md-content class="md-padding">
            </md-content>
        </md-tab>
    </md-tabs>

  </div>
  <div class="modal-footer">
    <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
  </div>
</div>
</div>
</div>
