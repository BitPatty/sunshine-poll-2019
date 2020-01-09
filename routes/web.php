<?php

Route::get('/', 'PollController@index');
Route::post('/submit', 'PollController@submit');

Route::get('/logout', 'AuthController@logout');
Route::get('/auth', 'AuthController@index')->name('login');
Route::post('/auth', 'AuthController@login');

Route::get('/verification', 'VerificationController@index');
Route::get('/verification/{id}', 'VerificationController@show');
Route::post('/verification/{id}', 'VerificationController@update');

