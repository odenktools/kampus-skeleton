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

    Route::get('/berita', ['as' => 'get', 'uses' => 'BeritaController@getIndex']);
    Route::post('/berita/insert', ['as' => 'insert', 'uses' => 'BeritaController@postInsert']);
    Route::post('/berita/delete/{id}', ['as' => 'delete', 'uses' => 'BeritaController@postDelete']);
	Route::post('/berita/update/{id}', ['as' => 'delete', 'uses' => 'BeritaController@postUpdate']);

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

    Route::get('karyawan', ['as' => 'karyawan.index', 'uses' => 'KaryawanController@getIndex']);
    Route::post('karyawan/insert', ['as' => 'karyawan.store', 'uses' => 'KaryawanController@postCreateData']);
    Route::delete('karyawan/id/{id}', ['as' => 'karyawan.delete', 'uses' => 'KaryawanController@deleteHapus']);
});