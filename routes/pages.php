<?php

/*
|--------------------------------------------------------------------------
| Pages Routes
|--------------------------------------------------------------------------
|
*/
$router->group([
    'prefix' => 'admin/',
    'middleware' => ['auth', 'admin'],
    'namespace' => 'App\Http\Controllers\Admin\Pages',
], function () use ($router) {
    $router->post('/pages/landing/update', [
        'as' => 'admin.landing.update',
        'uses' => 'LandingPageController@update',
    ]);

    $router->post('/pages/header/update', [
        'as' => 'admin.header.update',
        'uses' => 'HeadersController@update',
    ]);

    $router->get('/product/all', [
        'as' => 'admin.product.all',
        'uses' => 'ProductsController@all',
    ]);

    $router->get('/product/{id}', [
        'as' => 'admin.product.all',
        'uses' => 'ProductsController@findProductByID',
    ]);

    $router->post('/product/create', [
        'as' => 'admin.product.create',
        'uses' => 'ProductsController@create',
    ]);

    $router->post('/product/update', [
        'as' => 'admin.product.update',
        'uses' => 'ProductsController@update',
    ]);

    $router->post('/media/upload', [
        'as' => 'admin.media.upload',
        'uses' => 'ResourcesController@upload',
    ]);

    $router->get('/media/all', [
        'as' => 'admin.media.all',
        'uses' => 'ResourcesController@allResources',
    ]);

    $router->get('/media/{code}', [
        'as' => 'admin.media.by.page',
        'uses' => 'ResourcesController@listResourceByIdentifier',
    ]);
});

$router->group([
    'prefix' => 'pages/',
    'namespace' => 'App\Http\Controllers\Pages',
], function () use ($router) { 

    $router->get('/', [
        'as' => 'pages.list',
        'uses' => 'PageController@listPages',
    ]);

    $router->get('/{code}', [
        'as' => 'pages.find.by.code',
        'uses' => 'PageController@index',
    ]);

});