<?php

$router->get('/', 'VoteController@index');
$router->post('/', 'VoteController@create');
$router->get('/import', 'ImportController@index');
$router->post('/verification', 'VerificationController@update');
$router->get('/verification', 'VerificationController@index');

