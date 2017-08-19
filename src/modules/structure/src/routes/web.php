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


Route::get('/admin/structure', 'Cmspapa\structure\Controllers\StructureController@index');
Route::get('/admin/structure/get-structure', 'Cmspapa\structure\Controllers\StructureController@getStructure');
Route::post('/admin/structure/save', 'Cmspapa\structure\Controllers\StructureController@save');

Route::get('/admin/structure/get-structure-with-components', 'Cmspapa\structure\Controllers\StructureController@getStructureWithComponents');