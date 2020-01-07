<?php

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
|
*/

$router->get('/', function () use ($router) {
    return 'routed';
});


$router->get('/', [
    'as' => 'admin.blog',
    'uses' => 'BlogsController@index',
]);