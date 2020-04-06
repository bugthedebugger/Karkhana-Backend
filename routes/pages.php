<?php

/*
|--------------------------------------------------------------------------
| Pages Routes
|--------------------------------------------------------------------------
|
*/
$router->group([
    'prefix' => 'admin/',
    'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers\Admin\Pages',
], function () use ($router) {
    $router->post('/pages/landing/update', [
        'as' => 'admin.landing.update',
        'uses' => 'LandingPageController@update',
    ]);
});