<?php

// Composer AUTOLOAD
require __DIR__.'/../vendor/autoload.php';

use \App\Utils\View;
use \App\Common\Environment;
use \App\Db\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

// Load environment variables
Environment::load(__DIR__.'/../');

// Configure database settings
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

define('URL', getenv('URL'));

View::init([
    'URL' => URL
]);

MiddlewareQueue::setMap([
    'maintenence' => \App\Http\Middleware\Maintenence::class,
    'required-admin-logout' => \App\Http\Middleware\RequireAdminLogout::class,
    'required-admin-login' => \App\Http\Middleware\RequireAdminLogin::class,
    'required-user-logout' => \App\Http\Middleware\RequireUserLogout::class,
    'required-user-login' => \App\Http\Middleware\RequireUserLogin::class,
    'api' => \App\Http\Middleware\Api::class,
    'user-basic-auth' => \App\Http\Middleware\UserBasicAuth::class,
    'jwt-auth' => \App\Http\Middleware\JWTAuth::class
]);

MiddlewareQueue::setDefault([
    'maintenence'
]);