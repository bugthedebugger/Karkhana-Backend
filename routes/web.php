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
$router->get('/', ['middleware' => ['lang'], function () use ($router) {
	// dd($language);
    return $router->app->version();
}]);

$router->post('v1/login/email', [
    'as' => 'login.email', 'uses' => 'Login\LoginController@login'
]);

$router->get('v1/test', [
    'as' => 'test', 'uses' => 'TestController@test'
]);

$router->group(['prefix' => 'v1/pages'], function () use ($router) {
    $router->get('/{page}', [
    	'as' => 'pages', 'uses' => 'Pages\PageController@index'
	]);
});

$router->get('/languages', [
    'as' => 'lanugages',
    'uses' => 'LanguageController@index',
]);

$router->get('v1/user', [
    	'as' => 'user', 'uses' => 'Users\UserController@index', 'middleware' => ['auth']
]);

$router->get('v1/register', [
    	'as' => 'register', 'uses' => 'Register\RegisterController@index', 'middleware' => ['auth', 'admin']
]);

$router->get('v1/register/verify/{token}', [
    	'as' => 'register.verify', 'uses' => 'Register\RegisterController@verify'
]);
