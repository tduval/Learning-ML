<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	    return view('dashboard');
});


Route::get('/data', 'UploadFilesController@index');
Route::post('/data', 'UploadFilesController@store');
Route::delete('/data/{id}', 'UploadFilesController@destroy');
Route::get('/data/{id}', 'UploadFilesController@show');


Route::get('/regression/linear', 'LinearRegressionController@index');
Route::post('/regression/linear', 'LinearRegressionController@store');

