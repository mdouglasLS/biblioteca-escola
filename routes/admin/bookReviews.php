<?php

use \App\Http\Response;
use \App\Controller\Admin;

$obRouter->get('/admin/resenhas',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\BookReview::getBookReviews($request));
    }
]);

$obRouter->get('/admin/resenhas/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\BookReview::getNewBookReview($request));
    }
]);

$obRouter->post('/admin/resenhas/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\BookReview::setNewBookReview($request));
    }
]);

$obRouter->get('/admin/resenhas/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\BookReview::getEditBookReview($request,$id));
    }
]);

$obRouter->post('/admin/resenhas/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\BookReview::setEditBookReview($request,$id));
    }
]);

$obRouter->get('/admin/resenhas/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\BookReview::getDeleteBookReview($request,$id));
    }
]);

$obRouter->post('/admin/resenhas/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\BookReview::setDeleteBookReview($request,$id));
    }
]);