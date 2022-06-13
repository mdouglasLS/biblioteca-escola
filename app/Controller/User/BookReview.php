<?php

namespace App\Controller\User;

class BookReview extends Page
{

    public static function getBookReviews(object $request): string
    {
//        $content =  View::render('pages/book-reviews',[
//            'items' => self::getBookReviewItems($request,$obPagination),
//            'pagination' => parent::getPagination($request,$obPagination)
//        ]);
        return parent::getPage('Resenhas', 'Resenhas userr');
    }

}