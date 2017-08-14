@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="paso7Ctrl" ng-cloak>
    <form name="paso7Form" ng-submit="paso7Form.$valid && saveProducto($event)" class="form-horizontal" novalidate>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-4">
              <div class="row">
                <label class="col-sm-4">Referencia :</label>
                <p class="col-sm-7">{{$item['ite_referencia']}}</p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <label class="col-sm-4">Categoria :</label>
                <p class="col-sm-7">{{$item['detalles']['ide_categoria']}} - {{$item['detalles']['categoria']['descripcionItemCriterioMayor']}}</p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="row">
                <label class="col-sm-4">Línea :</label>
                <p class="col-sm-7">{{$item['detalles']['ide_linea']}} - {{$item['detalles']['linea']['descripcionItemCriterioMayor']}}</p>
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
              <md-chips ng-model="producto.variedad" md-require-match="true">
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
            <div class="text-center">
              <input type="hidden" ng-model="producto.proy" ng-init="producto.proy = {{$idproyecto}}"/>
              <input type="hidden" ng-model="producto.act" ng-init="producto.act = {{$idactividad}}"/>
              <input type="hidden" ng-model="item" ng-init="item = {{$item}}"/>
              <button class="btn btn-primary" type="submit">Confirmar</button>
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
