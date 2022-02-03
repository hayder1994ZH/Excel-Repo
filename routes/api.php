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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::group(['middleware' => ['auth']], function () {
Route::get('data', 'ImportController@excel');
Route::post('getData', 'ImportController@getList');
// });

Route::post('users/registeration','UserController@register');
Route::post('users/login','UserController@login');
Route::get('export','UserController@export');