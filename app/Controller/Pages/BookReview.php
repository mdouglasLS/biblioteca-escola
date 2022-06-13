<?php

namespace App\Controller\Pages;

use App\Controller\User\BookReview as UserBookReview;
use App\Session\User\Login as SessionUser;
use App\Utils\View;
use \App\Model\Entity\BookReview as EntityBookReview;
use \App\Db\Pagination;

class BookReview extends Page
{

    private static function getBookReviewItems(object $request, &$obPagination): string
    {

        $items = '';

        $totalQuantity = EntityBookReview::getBookReviews('','','','COUNT(*) as qty')->fetchObject()->qty;

        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($totalQuantity,$currentPage,3);

        $results = EntityBookReview::getBookReviews('','id DESC',$obPagination->getLimit());

        while($obBookReview = $results->fetchObject(EntityBookReview::class)) {
            $items .=  View::render('pages/book-review/item',[
                'name' => $obBookReview->name,
                'message' => $obBookReview->message,
                'createdDate' => date('d-m-Y H:i:s',strtotime($obBookReview->createdDate))
            ]);
        }

        return $items;
    }

    public static function getBookReviews(object $request): string
    {

        if(SessionUser::isLogged()) {
            return UserBookReview::getBookReviews($request);
        }

//        $content =  View::render('pages/book-reviews',[
//            'items' => self::getBookReviewItems($request,$obPagination),
//            'pagination' => parent::getPagination($request,$obPagination)
//        ]);
        return parent::getPage('Resenhas', 'Resenhas');
    }

}