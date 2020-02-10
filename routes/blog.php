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

    $router->delete('/blog/delete/{uuid}', [
        'as' => 'admin.blog.delete',
        'uses' => 'BlogsController@delete',
    ]);

    $router->post('/blog/publish/{uuid}', [
        'as' => 'admin.blog.publish',
        'uses' => 'BlogsController@publish',
    ]);

    $router->post('/blog/unpublish/{uuid}', [
        'as' => 'admin.blog.publish',
        'uses' => 'BlogsController@unPublish'
    ]);
    
    $router->post('/blog/update/{uuid}', [
        'as' => 'admin.blog.update',
        'uses' => 'BlogsController@update',
    ]);

    $router->get('/blog/gallery/{uuid}', [
        'as' => 'admin.gallery.find',
        'uses' => 'GalleryController@getGallery',
    ]);

    $router->post('/blog/gallery/{uuid}/upload', [
        'as' => 'admin.gallery.upload',
        'uses' => 'GalleryController@upload'
    ]);

    $router->delete('/blog/gallery/{uuid}/delete', [
        'as' => 'admin.gallery.upload',
        'uses' => 'GalleryController@delete'
    ]);

    $router->get('/blog/{uuid}', [
        'as' => 'admin.blog.find',
        'uses' => 'BlogsController@findByUUID',
    ]);
    
    $router->get('/tags', [
        'as' => 'admin.tags',
        'uses' => 'TagsController@index',
    ]);
    
    $router->post('/tags/store', [
        'as' => 'admin.tags.store',
        'uses' => 'TagsController@store',
    ]);

    $router->delete('/tags/delete/{tag}', [
        'as' => 'admin.tags.delete',
        'uses' => 'TagsController@delete',
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

    $router->get('/tags', [
        'as' => 'tag.index',
        'uses' => 'TagsController@index',
    ]);

    $router->get('/gallery/{uuid}', [
        'as' => 'admin.gallery.find',
        'uses' => 'GalleryController@getGallery',
    ]);

    $router->get('/{uuid}', [
        'as' => 'blog.find',
        'uses' => 'BlogsController@findByUUID',
    ]);
});
