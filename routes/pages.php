<?php

use \App\Http\Response;
use \App\Controller\Pages;

// Home
$obRouter->get('/',[
    function($request){
        return new Response(200, Pages\Home::getHome($request));
    }
]);

// Books
$obRouter->get('/livros',[
    function($request){
        return new Response(200, Pages\BookCollection::getBookCollections($request));
    }
]);

// Book Loans
$obRouter->get('/emprestimos',[
    function($request){
        return new Response(200, Pages\BookLoan::getBookLoans($request));
    }
]);

//Book Reviews
$obRouter->get('/resenhas',[
    function($request){
        return new Response(200, Pages\BookReview::getBookReviews($request));
    }
]);

// About
$obRouter->get('/sobre',[
    function($request){
        return new Response(200, Pages\About::getAbout($request));
    }
]);

// My account
$obRouter->get('/me',[
    function($request){
        return new Response(200, Pages\MyAccount::getMyAccount($request));
    }
]);

$obRouter->get('/pagina/{idPage}/{acao}',[
    function($idPage,$acao){
        return new Response(200, 'Página '.$idPage.' - '.$acao);
    }
]);