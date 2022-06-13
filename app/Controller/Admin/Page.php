<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use const http\Client\Curl\VERSIONS;

class Page
{

    private static array $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL.'/admin'
        ],
        'book-reviews' => [
            'label' => 'Resenhas',
            'link' => URL.'/admin/resenhas'
        ],
        'users' => [
            'label' => 'Usuários',
            'link' => URL.'/admin/usuarios'
        ]
    ];

    public static function getPage(string $title,string $content): string
    {
        return View::render('admin/page',[
            'title' => $title,
            'content' => $content
            ]);
    }

    private static function getMenu(string $currentModule): string
    {
        $links = '';
        foreach (self::$modules as $hash=>$module) {
            $links .= View::render('admin/menu/link',[
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'text-warning' : ''
            ]);
        }

        return View::render('admin/menu/box',[
            'links' => $links
        ]);
    }

    public static function getPanel(string $title,string $content,string $currentModule): string
    {
        $contentPanel =  View::render('admin/panel',[
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        return self::getPage($title,$contentPanel);
    }

    public static function getPagination(object $request,object $obPagination): string
    {
        $pages = $obPagination->getPages();

        if(count($pages) <= 1) return '';

        $links = '';

        $url = $request->getRouter()->getCurrentUrl();

        $queryParams = $request->getQueryParams();

        foreach ($pages as $page) {
            $queryParams['page'] = $page['page'];
            $link = $url.'?'.http_build_query($queryParams);

            $links .= View::render('admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        return View::render('admin/pagination/box', [
            'links' => $links
        ]);

    }

}