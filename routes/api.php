<?php

use App\Platform;
use App\Tag;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/platforms', function() {
    return Platform::all();
});

Route::post('/platforms', function() {
    return Platform::create([
        'key' => request('key'),
        'name' => request('name'),
        'description' => request('description'),
    ]);
});

Route::get('/tags', function() {
    return Tag::all();
});


Route::post('/search', function() {
    return Group::where([
        'platform' => request('platform'),
        'tag' => request('tag'),
        'name' => request('name'),
    ]);
});