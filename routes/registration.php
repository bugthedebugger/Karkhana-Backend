<?php

/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
|
*/
$router->group([
    'prefix' => 'admin/',
    'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers\Admin\Registration',
], function () use ($router) {
    $router->post('/register', [
        'uses' => 'RegistrationController@sendRegistrationLink',
    ]);

    $router->post('/register/resend-token', [
        'as' => 'admin.registration.resend',
        'uses' => 'RegistrationController@resendRegistrationLink',
    ]);

    $router->delete('/register/cancel/{email}', [
        'as' => 'admin.registration.cancel',
        'uses' => 'RegistrationController@cancelRegistration',
    ]);

    $router->get('/users/unregistered', [
        'as' => 'admin.users.unregistered',
        'uses' => 'RegistrationController@listUnregisteredUsers',
    ]);

    $router->get('/users/registered', [
        'as' => 'admin.users.registered',
        'uses' => 'RegistrationController@listRegisteredUsers',
    ]);

    $router->post('/guest/register', [
        'as' => 'admin.guest.register',
        'uses' => 'RegistrationController@registerGuest',
    ]);
});

$router->group([
    'namespace' => 'App\Http\Controllers\Registration',
], function () use ($router) {
    $router->get('/register/check/{token}', [
        'as' => 'registration.check',
        'uses' => 'RegistrationController@registrationCheck',
    ]);

    $router->post('/register', [
        'as' => 'registration.register',
        'uses' => 'RegistrationController@registerUser',
    ]);
});