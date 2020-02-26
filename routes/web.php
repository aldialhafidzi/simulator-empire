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

Route::get('/', 'HomeController@index');
Route::get('/regresi', 'HomeController@regresi');
Route::post('/addRequest', 'HomeController@addRequest')->name('addRequest');
Route::post('/addRegresi', 'HomeController@addRegresi')->name('addRegresi');