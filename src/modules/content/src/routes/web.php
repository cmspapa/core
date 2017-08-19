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

Route::group(['middleware' => ['web']], function () 
{
	Route::get('/admin/content-types', '\Cmspapa\content\Controllers\ContentTypesController@index');
	Route::get('/admin/content-types/create', '\Cmspapa\content\Controllers\ContentTypesController@create');
	Route::post('/admin/content-types', '\Cmspapa\content\Controllers\ContentTypesController@save');
	Route::get('/admin/content-types/{contentTypeId}/manage-fields', '\Cmspapa\content\Controllers\ContentTypesController@manageFields');
	Route::get('/admin/content-types/{contentTypeId}/manage-fields/create', '\Cmspapa\content\Controllers\ContentTypesController@createField');
	Route::post('/admin/content-types/{contentTypeId}/manage-fields', '\Cmspapa\content\Controllers\ContentTypesController@saveField');

	// Content
	Route::get('/admin/contents', '\Cmspapa\content\Controllers\ContentsController@listAllcontentsIndexLinks');
	Route::get('/admin/contents/create', '\Cmspapa\content\Controllers\ContentsController@listAllcontentsCreateLinks');
	Route::get('/admin/contents/{contentTypeId}', '\Cmspapa\content\Controllers\ContentsController@index');
	Route::get('/admin/contents/{contentTypeId}/create', '\Cmspapa\content\Controllers\ContentsController@create');
	Route::post('/admin/contents/{contentTypeId}', '\Cmspapa\content\Controllers\ContentsController@save');
});