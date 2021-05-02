<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'UserController@login');

/**Recibe el request con los datos del usuario y aparte el id del rol de usuario para registrar el nuevo usuario */
Route::post('register/{id}', 'UserController@register');

/**Responde con los datos (mas el rol) de todos los usuarios registrados (listado de usuarios)*/
Route::get('users', 'UserController@index');
Route::post('quotitation', 'RequestQuotitationController@store');
Route::get('quotitations', 'RequestQuotitationController@index');

/**recibe un id de solitud de aquicion y responde con los detalles que perteneces a esa solicitud */
Route::get('quotitation/{id}', 'RequestQuotitationController@show');

Route::put('quotitation/status/{id}', 'RequestQuotitationController@updateState');

/**recibe un id de solicitud y responde con los archivos adjuntos que pertenecen a esa solicitud */
Route::get('requestQuotitation/files/{id}', 'RequestQuotitationController@showFiles');

Route::post('report/{id}', 'ReportController@store');
Route::post('upload/{id}', 'RequestQuotitationController@uploadFile');
Route::get('download', 'RequestQuotitationController@download');
Route::post('details', 'UserController@details');

/**resive los emails y la descripcion del mensage que se enviara a las empresas o a la empresa
 * y resive el id a la solicitud a la que pertenece*/
Route::post('sendEmail/{id}','EmailController@store');

/**Devuleve la lista de todos los roles */
Route::get('rols', 'RolController@index');

/**Recibe el id del usuario y el id del rol y modifica el rol de un usuario */
Route::put('users/update/{idu}/{idr}', 'UserController@updateRol');

/**Recibe el nombre y descripcion del nuevo rol para guardarlo */
Route::post('rols/new', 'RolController@store');

Route::group(['middleware' => 'auth:api'], function(){
    
});
