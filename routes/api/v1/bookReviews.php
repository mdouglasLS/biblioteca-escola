<?php

use \App\Http\Response;
use \App\Controller\Api;


$obRouter->get('/api/v1/bookReviews',[
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(200, Api\BookReview::getBookReviews($request),'application/json');
    }
]);

$obRouter->get('/api/v1/bookReviews/{id}',[
    'middlewares' => [
        'api'
    ],
    function($request,$id){
        return new Response(200, Api\BookReview::getBookReview($request,$id),'application/json');
    }
]);

$obRouter->post('/api/v1/bookReviews',[
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request){
        return new Response(201, Api\BookReview::setNewBookReview($request),'application/json');
    }
]);

$obRouter->put('/api/v1/bookReviews/{id}',[
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request,$id){
        return new Response(200, Api\BookReview::setEditBookReview($request,$id),'application/json');
    }
]);

$obRouter->delete('/api/v1/bookReviews/{id}',[
    'middlewares' => [
        'api',
        'user-basic-auth'
    ],
    function($request,$id){
        return new Response(200, Api\BookReview::setDeleteBookReview($request,$id),'application/json');
    }
]);

