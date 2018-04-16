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

  Route::group(['prefix' => 'pricat'], function () {
    Route::resource('responsables', 'Pricat\ResponsablesController', ['except' => ['create', 'show', 'edit']]);
    Route::get('responsablesinfo', 'Pricat\ResponsablesController@getInfo');

    Route::resource('notiactividad', 'Pricat\NotiActividadController', ['except' => ['create', 'show', 'edit']]);
    Route::get('notiactividadinfo', 'Pricat\NotiActividadController@getInfo');

    Route::resource('procesos', 'Pricat\ProcesosController', ['except' => ['create', 'show', 'edit']]);
    Route::get('procesosinfo', 'Pricat\ProcesosController@getInfo');
    Route::post('actividades', 'Pricat\ProcesosController@storeActividad');
    Route::put('actividades/{id}', 'Pricat\ProcesosController@updateActividad');
    Route::delete('actividades/{id}', 'Pricat\ProcesosController@destroyActividad');

    Route::resource('proyectos', 'Pricat\ProyectosController', ['except' => ['create', 'show', 'edit']]);
    Route::get('proyectosinfo', 'Pricat\ProyectosController@getInfo');
    Route::put('proyectos/pausar/{id}', 'Pricat\ProyectosController@pausar');
    Route::put('proyectos/cancelar/{id}', 'Pricat\ProyectosController@cancelar');
    Route::put('proyectos/activar/{id}', 'Pricat\ProyectosController@activar');

    Route::resource('marcas', 'Pricat\MarcasController');
    Route::get('marcasinfo', 'Pricat\MarcasController@getInfo');

    Route::resource('criterios', 'Pricat\CriteriosController');
    Route::get('criteriosinfo', 'Pricat\CriteriosController@getInfo');

    Route::resource('vocabas', 'Pricat\VocabasController', ['except' => ['create', 'show', 'edit']]);
    Route::get('vocabasinfo', 'Pricat\VocabasController@getInfo');

    Route::get('desarrolloactividades', 'Pricat\DesarrolloActividadesController@index');
    Route::get('workflow', 'Pricat\DesarrolloActividadesController@workflow');
    Route::get('workflowinfo', 'Pricat\DesarrolloActividadesController@getInfo');

    Route::get('desarrolloactividadesGetInfo', 'Pricat\DesarrolloActividadesController@desarrolloactividadesGetInfo');
    Route::post('desarrolloactividades', 'Pricat\DesarrolloActividadesController@store');
    Route::get('editactividades', 'Pricat\DesarrolloActividadesController@edit');

    Route::get('rechazoactividades', 'Pricat\RechazoActividadesController@index');
    Route::get('rechazoactividadesGetInfo', 'Pricat\RechazoActividadesController@getInfo');
    Route::post('rechazoactividades', 'Pricat\RechazoActividadesController@updateEstado');

    Route::resource('notificacionsanitaria', 'Pricat\NotificacionSanitariaController');
    Route::post('notificacionsanitariaupdate', 'Pricat\NotificacionSanitariaController@update');
    Route::get('notificacionsanitariainfo', 'Pricat\NotificacionSanitariaController@getInfo');

    Route::resource('paso1', 'Pricat\Paso1Controller');
    Route::get('paso1info', 'Pricat\Paso1Controller@getInfo');
    Route::get('paso1/{proy}/{act}',  'Pricat\Paso1Controller@edit');
    Route::post('paso1edit', 'Pricat\Paso1Controller@editProducto');

    Route::resource('paso2', 'Pricat\Paso2Controller', ['only' => ['index', 'update']]);

    Route::get('paso3', ['uses' => 'Pricat\Paso3Controller@index', 'as' => 'paso3.index']);

    Route::resource('paso4', 'Pricat\Paso4Controller');
    Route::get('paso4/{proy}/{act}',  'Pricat\Paso4Controller@edit');
    Route::put('paso4/{proy}/{act}',  'Pricat\Paso4Controller@editPosicion');

    Route::resource('paso5', 'Pricat\Paso5Controller');
    Route::get('paso5/{proy}/{act}',  'Pricat\Paso5Controller@edit');
    Route::put('paso5/{proy}/{act}',  'Pricat\Paso5Controller@editGrupo');

    Route::resource('paso6', 'Pricat\Paso6Controller');
    Route::post('paso6update', 'Pricat\Paso6Controller@update');
    Route::get('paso6info', 'Pricat\Paso6Controller@getInfo');
    Route::post('uploaditems', 'Pricat\Paso6Controller@upload');
    Route::get('paso6/{proy}/{act}',  'Pricat\Paso6Controller@edit');
    Route::post('paso6edit', 'Pricat\Paso6Controller@editMedidas');

    Route::resource('paso7', 'Pricat\Paso7Controller');
    Route::get('paso7info', 'Pricat\Paso7Controller@getInfo');
    Route::post('paso7', 'Pricat\Paso7Controller@update');

    Route::resource('paso8', 'Pricat\Paso8Controller');
    //Route::get('paso8/{proy}/{act}',  'Pricat\Paso8Controller@edit');
    //Route::put('paso8',  'Pricat\Paso8Controller@update');

    Route::resource('paso9', 'Pricat\Paso9Controller');

    Route::get('paso10', function () {
        return redirect(url('pricat/generar'));
    })->name('paso10.index');

    Route::resource('consulta', 'Pricat\ConsultaController');
    Route::get('consultainfo', 'Pricat\ConsultaController@getInfo');
    Route::post('consulta', 'Pricat\ConsultaController@consulta');
    Route::post('consultaexcel', 'Pricat\ConsultaController@generarExcel');

    Route::resource('fotos', 'Pricat\FotosController');
    Route::get('fotosinfo', 'Pricat\FotosController@getInfo');
    Route::post('fotos', 'Pricat\FotosController@store');


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
    Route::post('solicitudprecio', 'Pricat\SolicitudesController@precioBruto');
    Route::post('solicitudref', 'Pricat\SolicitudesController@referencia');

    Route::resource('generar', 'Pricat\PricatController');
    Route::get('generarinfo', 'Pricat\PricatController@getInfo');
    Route::post('generarpricat', 'Pricat\PricatController@solicitarPricat');


  });

});
