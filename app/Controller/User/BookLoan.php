<?php

namespace App\Controller\User;

use App\Utils\View;

class BookLoan extends Page
{

    public static function getBookLoans($request): string
    {

//        $content =  View::render('pages/book-loans',[
////            'name' => $obOrganization->name
//        ]);
        return parent::getPage('Minha conta', 'Empréstimos do usuario');


    }

}