<?php

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Check if we are running on Google App Engine
 *
 * NOTE: This is determined based on the .env file.  hidden files
 * (files starting with a dot) are not sent over to Google App
 * Engine on deploy.  This is because these files match the
 * Google App Engine ignore regex.
 *
 * Example Deploy Verbose Output:
 * `2015-08-19 15:10:11,380 INFO appcfg.py:2684 Ignoring
 * file '.env': File matches ignore regex.`
 *
 * @return bool
 */
function is_gae() {
    return !file_exists(__DIR__ . '/../.env');
}

/*
|—————————————————————————————————————
| Create The Application
|—————————————————————————————————————
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

if(is_gae()) {
    $app = new App\Bootstrap\GoogleApp(
        realpath(__DIR__ . '/../')
    );
}

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'guest' => App\Http\Middleware\RedirectIfAuthenticated::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Superbalist\LaravelGoogleCloudStorage\GoogleCloudStorageServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

/*
|--------------------------------------------------------------------------
| Set Storage Path
|--------------------------------------------------------------------------
|
| This script allows you to override the default storage location used by
| the  application.  You may set the APP_STORAGE environment variable
| in your .env file,  if not set the default location will be used
|
*/
$app->useStoragePath(env('APP_STORAGE', base_path() . '/storage'));

return $app;
