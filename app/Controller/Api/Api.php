<?php

namespace App\Controller\Api;

class Api
{

    public static function getDetails(object $request): array
    {
        return [
            'name' => 'API - Biblioteca',
            'version' => 'v1.0.0',
            'author' => 'Michael Douglas',
            'email' => 'contato.dodolopes@gmail.com'
        ];
    }

    protected static function getPagination(object $request, object $obPagination): array
    {
        $queryParams = $request->getQueryParams();

        $pages = $obPagination->getPages();

        return [
            'currentPage' => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
            'totalPages' => !empty($pages) ? count($pages) : 1
        ];
    }

}