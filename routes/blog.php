<?php

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
|
*/

$router->get('/blog', [
    'as' => 'admin.blog',
    'uses' => 'BlogsController@index',
]);

$router->post('/blog/create', [
    'as' => 'admin.blog.create',
    'uses' => 'BlogsController@create',
]);

$router->post('/blog/update/{uuid}', [
    'as' => 'admin.blog.update',
    'uses' => 'BlogsController@update',
]);

$router->get('/tags', [
    'as' => 'admin.tags',
    'uses' => 'TagsController@index',
]);

$router->post('/tags/store', [
    'as' => 'admin.tags.store',
    'uses' => 'TagsController@store',
]);

