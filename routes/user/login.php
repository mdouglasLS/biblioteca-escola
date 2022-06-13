<?php

use \App\Http\Response;
use \App\Controller\User;

//Sign In
$obRouter->get('/login',[
    'middlewares' => [
        'required-user-logout'
    ],
    function($request){
        return new Response(200, User\Login::getLogin($request));
    }
]);

$obRouter->post('/login',[
    'middlewares' => [
        'required-admin-logout',
        'required-user-logout'
    ],
    function($request){
        return new Response(200, User\Login::setLogin($request));
    }
]);

$obRouter->get('/logout',[
    'middlewares' => [
        'required-user-login'
    ],
    function($request){
        return new Response(200, User\Login::setLogout($request));
    }
]);

//Sign Up
$obRouter->get('/user/signup',[
    'middlewares' => [
        'required-admin-logout',
        'required-user-logout'
    ],
    function($request){
        return new Response(200, User\Signup::getSignup($request));
    }
]);

$obRouter->post('/user/signup',[
    'middlewares' => [
        'required-admin-logout',
        'required-user-logout'
    ],
    function($request){
        return new Response(200, User\Signup::setNewUser($request));
    }
]);
