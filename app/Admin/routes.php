<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('dynasties/list', 'DynastyController@list')->name('dynasties.list');
    $router->get('poets/list', 'PoetController@list')->name('poets.list');
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('users', UserController::class);
    $router->resource('poets', PoetController::class);
    $router->resource('tags', TagController::class);
    $router->resource('dynasties', DynastyController::class);
    $router->resource('poetries', PoetryController::class);
    $router->resource('verses', VerseController::class);
    $router->resource('host_searches', HostSearchController::class);

});
