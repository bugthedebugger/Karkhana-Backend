<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', ['middleware' => ['lang'], function ($request, $language) use ($router) {
	dd($language);
    return $router->app->version();
}]);

$router->post('v1/login/email', [
    'as' => 'login.email', 'uses' => 'Login\LoginController@login'
]);

$router->group(['prefix' => 'v1/pages'], function () use ($router) {
    $router->post('/{page}', [
    	'as' => 'pages', 'uses' => 'Login\LoginController@index'
	]);
});