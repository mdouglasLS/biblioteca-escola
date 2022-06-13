<?php

namespace App\Controller\Admin;

use \App\Utils\View;
class Home extends Page
{

    public static function getHome(object $request): string
    {
        $content = View::render('admin/modules/home/index',[

        ]);
        return parent::getPanel('Dashboard', $content,'home');
    }

}