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

Route::get('/admin/components', 'Cmspapa\components\Controllers\ComponentsController@index');
Route::post('/admin/components', 'Cmspapa\components\Controllers\ComponentsController@save');
Route::post('/admin/components/vue-path', 'Cmspapa\components\Controllers\ComponentsController@viewPath');