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
Route::post('register', 'UserController@register');
Route::get('users', 'UserController@index');
Route::post('quotitation', 'RequestQuotitationController@store');
Route::get('quotitations', 'RequestQuotitationController@index');

/**recibe un id de solitud de adquicion y responde con los detalles que perteneces a esa solicitud */
Route::get('quotitation/{id}', 'RequestQuotitationController@show');

Route::put('quotitation/status/{id}', 'RequestQuotitationController@updateState');
Route::post('report/{id}', 'ReportController@store');
Route::post('upload/{id}', 'RequestQuotitationController@uploadFile');
Route::get('download', 'RequestQuotitationController@download');
Route::post('details', 'UserController@details');
Route::post('sendEmail','EmailController@store');
Route::post('administrativeUnit/new','AdministrativeUnitController@register');
Route::post('limiteAmount/new','LimiteAmountController@register');
Route::post('updateLimiteAmount/{id}','LimiteAmountController@updateLimiteAmount');
Route::get('limiteAmounts/{id}','LimiteAmountController@index');
Route::get('Faculties','FacultyController@index');
//envia el registro actual de los montos limites dado un id de unidad administrativa
Route::get('lastRecord/{id}','LimiteAmountController@sendCurrentData');

Route::group(['middleware' => 'auth:api'], function(){
    
});
