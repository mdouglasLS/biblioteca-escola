<?php

use \App\Http\Response;
use \App\Controller\Admin;

$obRouter->get('/admin/usuarios',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\User::getUsers($request));
    }
]);

$obRouter->get('/admin/usuarios/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\User::getNewUser($request));
    }
]);

$obRouter->post('/admin/usuarios/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\User::setNewUser($request));
    }
]);

$obRouter->get('/admin/usuarios/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\User::getEditUser($request,$id));
    }
]);

$obRouter->post('/admin/usuarios/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\User::setEditUser($request,$id));
    }
]);