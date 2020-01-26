<?php

Route::group(['middleware' => ['activity']], function () {

    Route::get('/', 'PollController@index');
    Route::post('/submit', 'PollController@submit');

    Route::get('/logout', 'AuthController@logout');
    Route::get('/auth', 'AuthController@index')->name('login');
    Route::post('/auth', 'AuthController@login');

    Route::get('/results', 'ResultsController@index');

    Route::get('/manage', 'PollManagementController@index');
    Route::post('/manage', 'PollManagementController@update');
    Route::get('/verification', 'VerificationController@index');
    Route::get('/verification/{id}', 'VerificationController@show');
    Route::post('/verification/{id}', 'VerificationController@update');

});
