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

// Install
Route::get('/install', 'Cmspapa\install\Controllers\InstallController@install');

// Install verify requirments
Route::get('/install-verify-requirments', 'Cmspapa\install\Controllers\InstallController@verifyRequirments');

// Install setup database
Route::get('/install-setup-database', 'Cmspapa\install\Controllers\InstallController@getSetupDatabase');
Route::post('/install-setup-database', 'Cmspapa\install\Controllers\InstallController@postSetupDatabase');

// Install papa dependencies
Route::get('/install-papa-dependencies', 'Cmspapa\install\Controllers\InstallController@getPapaDependencies');
Route::post('/install-papa-dependencies', 'Cmspapa\install\Controllers\InstallController@postPapaDependencies');

// Install configure Site
Route::get('/install-configure-site', 'Cmspapa\install\Controllers\InstallController@getConfigureSite');
Route::post('/install-configure-site', 'Cmspapa\install\Controllers\InstallController@postConfigureSite');

// Install finished
Route::get('/install-finished', 'Cmspapa\install\Controllers\InstallController@getFinished');