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

    Route::get('descargarInforme/{fechaInicial}/{fechaFinal}/{placaVehiculo}', 'tccws\tccwsController@descargarInforme')->name('descargarInforme');
  });

  /** Aplicativo Tiquetes y Hotel**/

  Route::group(['prefix' => 'tiquetes'], function(){

    /*Solicitud*/
    Route::resource('solicitudTiquetes', 'Tiquetes\SolicitudController');
    Route::get('solicitudinfo', 'Tiquetes\SolicitudController@getInfo');
    Route::get('paisesInfo', 'Tiquetes\SolicitudController@paisesInfo');
    Route::get('solicitudes', 'Tiquetes\SolicitudController@modifica');
    Route::post('solicitudTiquetes/enviaAprobar/{isCreating}', 'Tiquetes\SolicitudController@store');
    Route::get('editarSolicitud/{idSolicitud}', 'Tiquetes\SolicitudController@edit')->name('editarSolicitud');
    Route::post('editarSoli', 'Tiquetes\SolicitudController@editSolicitud');
    Route::post('editarSoli/enviaEditAprobar/{isCreating}', 'Tiquetes\SolicitudController@editSolicitud');

    /*Mis Solicitudes*/

    Route::resource('misSolicitudesTiquetes', 'Tiquetes\MisSolicitudesController');
    Route::get('missolicitudesinfo', 'Tiquetes\MisSolicitudesController@getInfo');
    Route::post('enviarSol', 'Tiquetes\MisSolicitudesController@enviarSolicitud');
    Route::post('anularSol', 'Tiquetes\MisSolicitudesController@anularSolicitud');
    Route::get('imprimirLegalizacionTiquetes', 'Tiquetes\MisSolicitudesController@imprimirLegalizacion')->name('imprimirLegalizacionTiquetes');
    Route::get('misSolicitudesTiquetes', 'Tiquetes\MisSolicitudesController@index')->name('misSolicitudesTiquetes');

    /*Niveles Autorizacion*/
    Route::resource('nivelesautorizacionTiquetes', 'Tiquetes\NivelesAutorizacionController');
    Route::get('nivelesautorizacioninfo', 'Tiquetes\NivelesAutorizacionController@getInfo');
    Route::post('nivelesautorizacionTiquetes', 'Tiquetes\NivelesAutorizacionController@savePerNivel');
    Route::put('nivelesautorizacionTiquetes', 'Tiquetes\NivelesAutorizacionController@editPerNivel');
    Route::post('nivelesautorizaciondelete', 'Tiquetes\NivelesAutorizacionController@deletePerNivel');

    /*Bandeja Aprobacion*/
    Route::resource('bandejaaprobacion', 'Tiquetes\BandejaAprobacionController');
    Route::get('bandejaaprobacioninfo', 'Tiquetes\BandejaAprobacionController@getInfo');
  });

});
