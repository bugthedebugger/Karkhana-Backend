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