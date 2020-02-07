<?php

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
|
*/

$router->group([
    'prefix' => 'admin/',
    'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers\Admin\Blog',
], function () use ($router) {
    $router->get('/blog', [
        'as' => 'admin.blog',
        'uses' => 'BlogsController@index',
    ]);
    
    $router->get('/blog/uuid', [
        'as' => 'admin.blog.uuid',
        'uses' => 'BlogsController@getUUID'
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
    
});

$router->group([
    'prefix' => 'blog/',
    'namespace' => 'App\Http\Controllers\Blog',
], function () use ($router) {
    $router->get('/', [
        'as' => 'blog.index',
        'uses' => 'BlogsController@index',
    ]);
});
