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

  /*
   * Creado por Juliana Palacios
   * Rutas para el aplicativo calidad de datos y homologacion
   * 21/03/2017
  */
  Route::group(['prefix' => 'pricat'], function () {
    Route::resource('responsables', 'Pricat\ResponsablesController', ['except' => ['create', 'show', 'edit']]);
    Route::get('responsablesinfo', 'Pricat\ResponsablesController@getInfo');

    Route::resource('procesos', 'Pricat\ProcesosController', ['except' => ['create', 'show', 'edit']]);
    Route::get('procesosinfo', 'Pricat\ProcesosController@getInfo');
    Route::post('actividades', 'Pricat\ProcesosController@storeActividad');
    Route::put('actividades/{id}', 'Pricat\ProcesosController@updateActividad');
    Route::delete('actividades/{id}', 'Pricat\ProcesosController@destroyActividad');

    Route::resource('proyectos', 'Pricat\ProyectosController', ['except' => ['create', 'show', 'edit']]);
    Route::get('proyectosinfo', 'Pricat\ProyectosController@getInfo');

    Route::resource('marcas', 'Pricat\MarcasController');
    Route::get('marcasinfo', 'Pricat\MarcasController@getInfo');

    Route::resource('criterios', 'Pricat\CriteriosController');
    Route::get('criteriosinfo', 'Pricat\CriteriosController@getInfo');

    Route::get('desarrolloactividades', 'Pricat\DesarrolloActividadesController@index');
    Route::get('workflow', 'Pricat\DesarrolloActividadesController@workflow');
    Route::get('workflowinfo', 'Pricat\DesarrolloActividadesController@getInfo');

    Route::resource('notificacionsanitaria', 'Pricat\NotificacionSanitariaController');
    Route::post('notificacionsanitariaupdate', 'Pricat\NotificacionSanitariaController@update');
    Route::get('notificacionsanitariainfo', 'Pricat\NotificacionSanitariaController@getInfo');

    Route::resource('paso1', 'Pricat\Paso1Controller', ['only' => ['index', 'store']]);
    Route::get('paso1info', 'Pricat\Paso1Controller@getInfo');

    Route::resource('paso2', 'Pricat\Paso2Controller', ['only' => ['index', 'update']]);

    Route::get('paso3', ['uses' => 'Pricat\Paso3Controller@index', 'as' => 'paso3.index']);

    Route::resource('paso4', 'Pricat\Paso4Controller', ['only' => ['index', 'update']]);

    Route::resource('paso5', 'Pricat\Paso5Controller', ['only' => ['index', 'update']]);

    Route::resource('paso6', 'Pricat\Paso6Controller');
    Route::post('paso6update', 'Pricat\Paso6Controller@update');
    Route::get('paso6info', 'Pricat\Paso6Controller@getInfo');
    Route::post('uploaditems', 'Pricat\Paso6Controller@upload');

    Route::resource('paso7', 'Pricat\Paso7Controller');

    Route::resource('createsubempaque', 'Pricat\SubempaqueController', ['only' => ['index', 'store']]);
    Route::get('createsubempaqueinfo', 'Pricat\SubempaqueController@getInfo');
    Route::get('confirmsubempaque', ['uses' => 'Pricat\ConfirmSubempaqueController@index', 'as' => 'confirmsubempaque.index']);

    Route::resource('clientes', 'Pricat\ClientesController');
    Route::get('clientesinfo', 'Pricat\ClientesController@getInfo');

    Route::resource('segmentos', 'Pricat\SegmentosController');
    Route::get('segmentosinfo', 'Pricat\SegmentosController@getInfo');

    Route::resource('solicitud', 'Pricat\SolicitudesController');
    Route::get('solicitudinfo', 'Pricat\SolicitudesController@getInfo');
    Route::get('solicitudcreateinfo', 'Pricat\SolicitudesController@getCreateInfo');

    Route::resource('generar', 'Pricat\PricatController');
  });
});
