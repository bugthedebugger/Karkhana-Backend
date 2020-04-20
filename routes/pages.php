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

    $router->get('/settings', [
        'as' => 'admin.settings.index',
        'uses' => 'SettingsController@index',
    ]);

    $router->post('/pages/header/update', [
        'as' => 'admin.header.update',
        'uses' => 'HeadersController@update',
    ]);

    $router->post('/pages/contact/update', [
        'as' => 'admin.contact.update',
        'uses' => 'ContactUsController@update',
    ]);

    $router->post('/pages/products/update', [
        'as' => 'admin.products.update',
        'uses' => 'ProductsPageController@update',
    ]);

    $router->post('/pages/product-details/update', [
        'as' => 'admin.product-details.update',
        'uses' => 'ProductDetailsPageController@update',
    ]);

    $router->post('/pages/about/update', [
        'as' => 'admin.about.update',
        'uses' => 'AboutPageController@update',
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

    $router->get('/partners', [
        'as' => 'admin.partners.index',
        'uses' => 'PartnersController@index',
    ]);

    $router->post('/partners/create', [
        'as' => 'admin.partners.create',
        'uses' => 'PartnersController@create',
    ]);

    $router->post('/partners/update/{id}', [
        'as' => 'admin.partners.update',
        'uses' => 'PartnersController@update',
    ]);

    $router->get('/partners/{id}', [
        'as' => 'admin.partners.find',
        'uses' => 'PartnersController@findByID',
    ]);

    $router->delete('/partners/{id}', [
        'as' => 'admin.partners.delete',
        'uses' => 'PartnersController@delete',
    ]);

    $router->get('/team', [
        'as' => 'admin.team.all',
        'uses' => 'TeamController@list',
    ]);

    $router->post('/team/create', [
        'as' => 'admin.team.create',
        'uses' => 'TeamController@create',
    ]);

    $router->post('/team/update/{id}', [
        'as' => 'admin.team.update',
        'uses' => 'TeamController@update',
    ]);

    $router->get('/team/{id}', [
        'as' => 'admin.team.index',
        'uses' => 'TeamController@index',
    ]);

    $router->delete('/team/{id}', [
        'as' => 'admin.team.delete',
        'uses' => 'TeamController@delete',
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