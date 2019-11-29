<?php

$router->get('/', 'VoteController@landing');
$router->get('/import', 'ImportController@index');
$router->post('/verification', 'VerificationController@update');
$router->get('/verification', 'VerificationController@index');
$router->post('/{id}', 'VoteController@create');
$router->get('/{id}', 'VoteController@index');

