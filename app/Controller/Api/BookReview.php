<?php

namespace App\Controller\Api;

use App\Db\Pagination;
use App\Model\Entity\BookReview as EntityBookReview;
class BookReview extends Api
{

    private static function getBookReviewItems(object $request, &$obPagination): array
    {
        $items = [];

        $totalQuantity = EntityBookReview::getBookReviews('','','','COUNT(*) as qty')->fetchObject()->qty;

        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($totalQuantity,$currentPage,5);

        $results = EntityBookReview::getBookReviews('','id DESC',$obPagination->getLimit());

        while($obBookReview = $results->fetchObject(EntityBookReview::class)) {
            $items[] = [
                'id' => $obBookReview->id,
                'name' => $obBookReview->name,
                'message' => $obBookReview->message,
                'createdDate' => $obBookReview->createdDate
            ];
        }

        return $items;
    }

    public static function getBookReviews(object $request): array
    {
        return [
            'bookReviews' => self::getBookReviewItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getBookReview($request, $id): array
    {
        if(!is_numeric($id)) {
            throw new \Exception("O id ".$id." não é válido.",400);
        }

        $obBookReview = EntityBookReview::getBookReviewById($id);

        if(!$obBookReview instanceof EntityBookReview) {
            throw new \Exception("A resenha ".$id." não foi encontrada.",404);
        }

        return [
            'id' => $obBookReview->id,
            'name' => $obBookReview->name,
            'message' => $obBookReview->message,
            'createdDate' => $obBookReview->createdDate
        ];
    }

    public static function setNewBookReview(object $request)
    {
        $postVars = $request->getPostVars();

        if(!isset($postVars['name']) or !isset($postVars['message'])) {
            throw new \Exception("Os campos 'Nome' e 'mensagem' são obrigatórios.",400);
        }

        $obBookReview = new EntityBookReview;
        $obBookReview->name = $postVars['name'];
        $obBookReview->message = $postVars['message'];
        $obBookReview->insertBookReview();

        return [
            'id' => $obBookReview->id,
            'name' => $obBookReview->name,
            'message' => $obBookReview->message,
            'createdDate' => $obBookReview->createdDate
        ];
    }

    public static function setEditBookReview(object $request, $id)
    {
        $postVars = $request->getPostVars();

        if(!isset($postVars['name']) or !isset($postVars['message'])) {
            throw new \Exception("Os campos 'Nome' e 'mensagem' são obrigatórios.",400);
        }

        $obBookReview = EntityBookReview::getBookReviewById($id);
        if(!$obBookReview instanceof EntityBookReview) {
            throw new \Exception("O depoimento ".$id." não foi encontrado.",404);
        }

        $obBookReview->name = $postVars['name'];
        $obBookReview->message = $postVars['message'];
        $obBookReview->updateBookReview();

        return [
            'id' => $obBookReview->id,
            'name' => $obBookReview->name,
            'message' => $obBookReview->message,
            'createdDate' => $obBookReview->createdDate
        ];
    }

    public static function setDeleteBookReview(object $request, $id)
    {

        $obBookReview = EntityBookReview::getBookReviewById($id);

        if(!$obBookReview instanceof EntityBookReview) {
            throw new \Exception("O depoimento ".$id." não foi encontrado.",404);
        }

        $obBookReview->deleteBookReview();

        return [
            'success' => true
        ];
    }

}