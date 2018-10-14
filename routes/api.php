<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'API\UserController@login');
Route::post('register','API\UserController@register');
Route::get('events','API\EventController@index');
Route::get('categories','API\CategoryController@index');
Route::get('categories/{id}', 'API\CategoryController@fetch');
Route::get('events/{id}', 'API\EventController@view');
Route::get('users/{id}', 'API\UserController@fetch');

Route::group(['middleware'=>'auth:api'], function(){
	Route::get('users','API\UserController@details');
	Route::post('events/new','API\EventController@create');
	Route::post('events/{id}/join', 'API\EventController@join');	
	Route::post('events/{id}/exit', 'API\EventController@exit');
});