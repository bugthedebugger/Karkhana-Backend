<?php

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
|
*/

$router->get('/', [
    'as' => 'admin.blog',
    'uses' => 'BlogsController@index',
]);

$router->get('/tags', [
    'as' => 'admin.tags',
    'uses' => 'TagsController@index',
]);

$router->post('/tags/store', [
    'as' => 'admin.tags.store',
    'uses' => 'TagsController@store',
]);