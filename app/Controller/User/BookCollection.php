<?php

namespace App\Controller\User;


class BookCollection extends Page
{

    public static function getBookCollections(object $request): string
    {


//        $content =  View::render('pages/book-reviews',[
//            'items' => self::getBookReviewItems($request,$obPagination),
//            'pagination' => parent::getPagination($request,$obPagination)
//        ]);
        return parent::getPage('Livros', 'Livros User');
    }

}