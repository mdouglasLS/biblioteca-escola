<?php

namespace App\Controller\Admin;

use App\Db\Pagination;
use App\Model\Entity\BookReview as EntityBookReview;
use App\Utils\View;

class BookReview extends Page
{

    private static function getBookReviewItems(object $request, &$obPagination): string
    {
        $items = '';

        $totalQuantity = EntityBookReview::getBookReviews('','','','COUNT(*) as qty')->fetchObject()->qty;

        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($totalQuantity,$currentPage,5);

        $results = EntityBookReview::getBookReviews('','id DESC',$obPagination->getLimit());

        while($obBookReview = $results->fetchObject(EntityBookReview::class)) {
            $items .=  View::render('admin/modules/book-reviews/item',[
                'id' => $obBookReview->id,
                'name' => $obBookReview->name,
                'message' => $obBookReview->message,
                'createdDate' => date('d-m-Y H:i:s',strtotime($obBookReview->createdDate))
            ]);
        }

        return $items;
    }

    public static function getBookReviews(object $request): string
    {
        $content = View::render('admin/modules/book-reviews/index',[
            'items' => self::getBookReviewItems($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination),
            'status' => self::getStatus($request)
        ]);
        return parent::getPanel('Resenhas', $content,'book-reviews');
    }

    public static function getNewBookReview(object $request): string
    {
        $content = View::render('admin/modules/book-reviews/form',[
            'title' => 'Publicar uma Resenha',
            'name' => '',
            'message' => '',
            'status' => ''
        ]);
        return parent::getPanel('Publicar uma Resenha', $content,'book-reviews');
    }

    public static function setNewBookReview(object $request)
    {
        $postVars = $request->getPostVars();

        $obBookReview = new EntityBookReview;
        $obBookReview->name = $postVars['name'] ?? '';
        $obBookReview->message = $postVars['message'] ?? '';
        $obBookReview->insertBookReview();

        $request->getRouter()->redirect('/admin/resenhas/'.$obBookReview->id.'/edit?status=create');

    }

    private static function getStatus(object $request)
    {
        $queryParams = $request->getQueryParams();
        if(!isset($queryParams['status'])) return '';

        switch ($queryParams['status']) {
            case 'create':
                return Alert::getSuccess('Resenha criada com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Resenha atualizada com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Resenha excluída com sucesso!');
                break;
        }
    }

    public static function getEditBookReview(object $request, int $id): string
    {
        $obBookReview = EntityBookReview::getBookReviewById($id);

        if(!$obBookReview instanceof EntityBookReview) {
            $request->getRouter()->redirect('/admin/resenhas');
        }

        $content = View::render('admin/modules/book-reviews/form',[
            'title' => 'Editar Resenha',
            'name' => $obBookReview->name,
            'message' => $obBookReview->message,
            'createdDate' => $obBookReview->createdDate,
            'status' => self::getStatus($request)
        ]);
        return parent::getPanel('Editar Resenha', $content,'book-reviews');
    }

    public static function setEditBookReview(object $request, int $id)
    {
        $obBookReview = EntityBookReview::getBookReviewById($id);

        if(!$obBookReview instanceof EntityBookReview) {
            $request->getRouter()->redirect('/admin/resenhas');
        }

        $postVars = $request->getPostVars();

        $obBookReview->name = $postVars['name'] ?? $obBookReview->name;
        $obBookReview->message = $postVars['message'] ?? $obBookReview->message;
        $obBookReview->updateBookReview();

        $request->getRouter()->redirect('/admin/resenhas/'.$id.'/edit?status=updated');
    }

    public static function getDeleteBookReview(object $request, int $id): string
    {
        $obBookReview = EntityBookReview::getBookReviewById($id);

        if(!$obBookReview instanceof EntityBookReview) {
            $request->getRouter()->redirect('/admin/resenhas');
        }

        $content = View::render('admin/modules/book-reviews/delete',[
            'name' => $obBookReview->name,
            'message' => $obBookReview->message,
            'createdDate' => $obBookReview->createdDate
        ]);
        return parent::getPanel('Excluir Resenha', $content,'book-reviews');
    }

    public static function setDeleteBookReview(object $request, int $id)
    {
        $obBookReview = EntityBookReview::getBookReviewById($id);

        if(!$obBookReview instanceof EntityBookReview) {
            $request->getRouter()->redirect('/admin/resenhas');
        }

        $obBookReview->deleteBookReview();

        $request->getRouter()->redirect('/admin/resenhas?status=deleted');
    }

}