<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// Bagian ini tidak perlu auth
$router->group(['namespace' => 'Auth', 'middleware' => 'guest'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    // Untuk Debug
    $router->get('auth-debug', 'AuthController@debug');
});

// Bagian ini wajib auth
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->group(['namespace' => 'Journal', 'prefix' => 'journal'], function () use ($router) {
        $router->get('/', 'JournalController@index');
        $router->post('/', 'JournalController@create');
    });
});
