<?php

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

Route::get('/platforms', 'Api\PlatformController@index');
Route::post('/platforms', 'Api\PlatformController@create');

Route::get('/tags', 'Api\TagController@index');
Route::post('/tags', 'Api\TagController@create');

Route::get('/groups', 'Api\GroupController@index');
Route::post('/groups', 'Api\GroupController@create');
Route::post('/groups/submit-group', 'Api\GroupController@create');
