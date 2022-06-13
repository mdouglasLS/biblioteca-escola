<?php

namespace App\Controller\User;

use App\Utils\View;

class Home extends Page
{

    public static function getHome($request): string
    {

        $content =  View::render('user/modules/home/index',[

        ]);
        return parent::getPage('User', $content);
    }

}