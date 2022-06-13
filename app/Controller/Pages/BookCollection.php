<?php

namespace App\Controller\Pages;

use App\Controller\User\BookCollection as UserBookCollection;
use App\Session\User\Login as SessionUser;
use App\Utils\View;

class BookCollection extends Page
{

    public static function getBookCollections(object $request): string
    {

        if(SessionUser::isLogged()) {
            return UserBookCollection::getBookCollections($request);
        }

        $content =  View::render('pages/book-collections',[
//            'items' => self::getBookReviewItems($request,$obPagination),
//            'pagination' => parent::getPagination($request,$obPagination)
        ]);
        return parent::getPage('Livros', $content);
    }

}