<?php

namespace App\Controller\Pages;

use App\Controller\User\BookLoan as UserBookLoan;
use App\Model\Entity\Organization;
use App\Session\User\Login as SessionUser;
use App\Utils\View;
class BookLoan extends Page
{

    public static function getBookLoans($request): string
    {

        if(SessionUser::isLogged()) {
            return UserBookLoan::getBookLoans($request);
        }

        $obOrganization = new Organization();

        $content =  View::render('pages/book-loans',[
//            'name' => $obOrganization->name
        ]);
        return parent::getPage('Minha conta', $content);


    }

}