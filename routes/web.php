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


Auth::routes();


Route::group(['middleware' => ['auth','cors']], function () {
  Route::get('/', function () {
    return redirect('login');
  });

  Route::get('/home', function () {
    return redirect(env('APPV1_URL'));
  });

  Route::get('reimprimirfactura', 'GVEmpleadoController@indexfacturas');
  Route::get('imprimirfactura/{ped_id}', 'GVEmpleadoController@imprimir');
  Route::get('generarventa', 'GVEmpleadoController@crear');
  Route::post('generarventa', 'GVEmpleadoController@guardar');
  Route::post('eliminarreferencia', 'GVEmpleadoController@eliminar');
  Route::get('finalizarcompra/{ped_id}', 'GVEmpleadoController@finalizar');
});


//Route::post('loginbesa', 'AplicativosController@load');

//Route::get('reimprimirfactura', 'GVEmpleadoController@reimprimirfactura');
//Route::get('facturasdata', 'GVEmpleadoController@facturasdata');
