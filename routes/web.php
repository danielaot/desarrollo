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
});

/** Aplicativo Tiquetes y Hotel**/

  Route::group(['prefix' => 'tiquetes'], function(){

    Route::resource('solicitud', 'Tiquetes\SolicitudController');
    Route::get('solicitudinfo', 'Tiquetes\SolicitudController@getInfo');
    Route::get('paisesInfo', 'Tiquetes\SolicitudController@paisesInfo');
    Route::get('solicitudes', 'Tiquetes\SolicitudController@modifica');  
    Route::post('solicitud', 'Tiquetes\SolicitudController@CrearSolicitud');
  });
