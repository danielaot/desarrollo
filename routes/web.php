<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
Route::get('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);

Route::get('loginredirect', function () {
  return view('loginredirect');
});

Route::group(['middleware' => ['auth']], function () {
  Route::get('/', function () {
    return view('loginredirect');
  });

  Route::get('home', function () {
    return redirect(env('APPV1_URL'));
  });

  Route::get('autocomplete', ['uses' => 'GenericasController@autocomplete', 'as' => 'autocomplete']);


  Route::group(['prefix' => 'tcc'], function () {
    Route::resource('tccws', 'tccws\tccwsController');
    Route::get('agrupaPedidosGetInfo', 'tccws\tccwsController@agrupaPedidosGetInfo');
    Route::post('obtenerPlano', 'tccws\tccwsController@getPlano');
    Route::post('unidadesLogisticas', 'tccws\tccwsController@getUnidadesLogisticas');
    Route::post('excluirDocumentos', 'tccws\tccwsController@excluirDocumentos');

    Route::resource('parametros', 'tccws\parametrostccController');
    Route::get('parametrosinfo', 'tccws\parametrostccController@getInfo');

    Route::resource('clientes', 'tccws\cliboomerangController');
    Route::get('clientesinfo', 'tccws\cliboomerangController@getInfo');

    Route::get('consultas', 'tccws\tccwsController@getConsultaRemesas');
    Route::get('consultasinfo', 'tccws\tccwsController@consultaRemesasGetInfo');
    Route::post('consultasbusqueda', 'tccws\tccwsController@consultaBusquedasGetInfo');
    Route::post('consultasfecha', 'tccws\tccwsController@consultaFechasGetInfo');

    Route::resource('ciudades', 'tccws\ciudadesController', ['except' => ['create', 'show', 'edit', 'destroy']]);
    Route::get('ciudadesinfo', 'tccws\ciudadesController@getInfo');
  });


});
