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
    $router->get('/pages', [
        'as' => 'admin.pages.list',
        'uses' => 'LandingPageController@listPages',
    ]);

    $router->post('/pages/landing/update', [
        'as' => 'admin.landing.update',
        'uses' => 'LandingPageController@update',
    ]);

    $router->post('/settings/update', [
        'as' => 'admin.settings.update',
        'uses' => 'SettingsController@createOrUpdate',
    ]);

    $router->post('/pages/header/update', [
        'as' => 'admin.header.update',
        'uses' => 'HeadersController@update',
    ]);

    $router->get('/pages/{code}', [
        'as' => 'admin.pages.list',
        'uses' => 'LandingPageController@index',
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