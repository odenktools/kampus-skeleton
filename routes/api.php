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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'auth::', 'namespace' => 'Auth'], function () {
    # Login
    Route::post('login', [ 'as' => 'api.login', 'uses' => 'LoginController@login']);
});

Route::group(['as' => 'api::', 'namespace' => 'Api', 'prefix' => 'v1'], function () {
    // === Kampus Routes
    Route::get('kampus', ['as' => 'kampus.index', 'uses' => 'KampusController@getIndex'])
        ->middleware( 'auth:api');
    Route::post('kampus/register', ['as' => 'kampus.insert', 'uses' => 'KampusController@postInsert']);
    //Route::put('kampus', ['as' => 'kampus.update', 'uses' => 'KampusController@putUpdate']);
    //Route::post('kampus/image', ['as' => 'kampus.addimage', 'uses' => 'KampusController@postImageKampus']);
    Route::delete('kampus/{id}', ['as' => 'kampus.update', 'uses' => 'KampusController@deleteHapus'])
        ->middleware( 'auth:api')
        ->where('id', '[0-9]+');
    Route::get('kampus/detail/{id}', ['as' => 'kampus.get', 'uses' => 'KampusController@getDetail'])
        ->middleware('auth:api')
        ->where('id', '[0-9]+');

    // Berita Routes, digunakan untuk response yang sangat simple, dan simple crud
    Route::get('berita', ['as' => 'berita.index', 'uses' => 'BeritaController@getIndex'])->middleware('auth:api');
    //Route::post('berita/insert', ['as' => 'berita.insert', 'uses' => 'BeritaController@postInsert'])->middleware('auth:api', 'App\Http\Middleware\ThrottleMiddleware:5,5');
    Route::post('berita/insert', ['as' => 'berita.insert', 'uses' => 'BeritaController@postInsert'])->middleware('auth:api');
    //Route::post('berita/update/{id}', ['as' => 'berita.update', 'uses' => 'BeritaController@postUpdate'])->middleware('auth:api', 'App\Http\Middleware\ThrottleMiddleware:5,5')->where('id', '[0-9]+');
    Route::post('berita/update/{id}', ['as' => 'berita.update', 'uses' => 'BeritaController@postUpdate'])->middleware('auth:api')->where('id', '[0-9]+');
    //Route::post('berita/delete/{id}', ['as' => 'berita.delete', 'uses' => 'BeritaController@postDelete'])->middleware('auth:api', 'App\Http\Middleware\ThrottleMiddleware:5,5')->where('id', '[0-9]+');
    Route::post('berita/delete/{id}', ['as' => 'berita.delete', 'uses' => 'BeritaController@postDelete'])->middleware('auth:api')->where('id', '[0-9]+');
});