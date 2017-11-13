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

Route::get('/', 'MainController@redirToEncreeption');

Route::get('/encreeption', 'MainController@encreeptionView');
Route::get('/decreeption', 'MainController@decreeptionView');

Route::post('/ajax/image-info', 'AjaxController@imageInfo');
Route::post('/ajax/encreeption', 'AjaxController@encreeptionMethod');
Route::post('/ajax/decreeption', 'AjaxController@decreeptionMethod');
