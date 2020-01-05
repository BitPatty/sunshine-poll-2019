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

Route::get('/', 'PollController@index');
Route::post('/submit', 'PollController@submit');

Route::get('/logout', 'AuthController@logout');
Route::get('/auth', 'AuthController@index')->name('login');
Route::post('/auth', 'AuthController@login');

Route::get('/verification', 'VerificationController@index');
Route::get('/verification/{id}', 'VerificationController@show');
Route::post('/verification/{id}', 'VerificationController@update');

