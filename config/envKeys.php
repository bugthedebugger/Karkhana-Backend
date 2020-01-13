<?php 

return [
	'admin' => [
		'email' => env('ADMIN_EMAIL'),
		'password' => env('ADMIN_PASSWORD'),
		'name' => env('ADMIN_NAME')
	],
	'token' => [
		'ApiToken' => env('TOKEN_NAME')
	],
	'app_key' => env('APP_KEY')
];